<?php

namespace ApiClient;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;

/**
 * Guzzle Client Wrapper für die Checkdomain API
 *
 */
class Client
{
    /** Allowed Http Methodes  */
    const HTTP_POST     = 'post';
    const HTTP_GET      = 'get';
    const HTTP_PUT      = 'put';
    const HTTP_PATCH    = 'patch';

    /** Base Api Url */
    const BASE_URI      = "http://api-public.checkdomain.vm/{version}/";

    /**
     * @var GuzzleClient
     */
    protected $guzzleClient;

    /**
     * @var array
     */
    protected $guzzleOptions;

    /**
     * Client constructor.
     *
     * @param $version
     * @param $token
     */
    public function __construct($version, $token)
    {
        $this->buildHeader($token);

        $this->guzzleClient = new GuzzleClient([
            'base_uri' => str_replace('{version}', $version,self::BASE_URI),
        ]);
    }

    /**
     * @param string     $methode
     * @param string     $uri
     * @param array      $param
     * @param array|null $body
     *
     * @throws \Exception
     * @return mixed
     */
    public function request(
        $methode,
        $uri,
        $param,
        $body = null
    ) {
        if (null !== $param) {
            $this->guzzleOptions['query'] = $param;
        }

        if (null !== $body) {
            $this->guzzleOptions['body'] = json_encode($body);
        }

        $location = null;

        try {
            $guzzleResponse = $this->guzzleClient->request(
                $methode,
                $uri,
                $this->guzzleOptions
            );

            $code = $guzzleResponse->getStatusCode();
            $location = $guzzleResponse->getHeader('Location')[0];

            $response = json_decode($guzzleResponse->getBody()->getContents());
        } catch (RequestException $exception) {
            $code = $exception->getCode();
            if(null !== $exception->getResponse()) {
                $response = json_decode($exception->getResponse()->getBody()->getContents());
            } else {
                throw new \Exception($exception->getMessage());
            }
        }

        return [
            'code' => $code,
            'location' => $location,
            'response' => $response
        ];
    }

    /**
     * @param $token
     */
    private function buildHeader($token)
    {
        $header = [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ];

        $this->guzzleOptions = [
            "headers" => $header
        ];
    }
}
