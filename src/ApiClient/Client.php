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

        try {
            $guzzleResponse = $this->guzzleClient->request(
                $methode,
                $uri,
                $this->guzzleOptions
            );

            $response = json_decode($guzzleResponse->getBody()->getContents());
            if(null === $response) {
                $response = new \stdClass();
                $response->code = $guzzleResponse->getStatusCode();
                $response->location = $guzzleResponse->getHeader('Location')[0];
            }

        } catch (RequestException $exception) {
            if(null == $exception->getResponse()) {
                $response = new \stdClass();
                $response->code = $exception->getCode();
                $response->message =  $exception->getMessage();
            } else {
                $response = json_decode($exception->getResponse()->getBody()->getContents());
            }
        }

        // return allways same stdObject struct
        if (!isset($response->message)) {
            $response->message = null;
        }
        if (!isset($response->errors)) {
            $response->errors = null;
        }
        if (!isset($response->location)) {
            $response->location = null;
        }

        return $response;
    }

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
