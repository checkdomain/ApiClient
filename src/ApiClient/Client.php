<?php

namespace ApiClient;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

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
    const BASE_URI      = "https://api.checkdomain.de/{version}/";

    /**
     * @var GuzzleClient
     */
    private $guzzleClient;

    /**
     * @var array
     */
    private $guzzleOptions;

    /**
     * Client constructor.
     *
     * @param $version
     * @param $token
     */
    public function __construct($version, $token, $config = array())
    {
        $this->guzzleClient = new GuzzleClient(
             array_merge(['base_uri' => $this->getBasePath($version)], $config)
        );

        $this->guzzleOptions = [
            "headers" =>  $this->getHeader($token)
        ];
    }

    /**
     * @param string     $method
     * @param string     $uri
     * @param array      $param
     * @param array|null $body
     *
     * @throws \Exception
     * @return mixed
     */
    public function request(
        $method,
        $uri,
        $param = null,
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
                $method,
                $uri,
                $this->guzzleOptions
            );
            return $this->getResponseObject($guzzleResponse);
        } catch (RequestException $exception) {
            return $this->getResponseObject($exception);
        }
    }

    /**
     * @param ResponseInterface|RequestException $guzzleResponse
     *
     * @return array
     * @throws \Exception
     */
    private function getResponseObject($guzzleResponse)
    {
        $response = [
            'code' => null,
            'location' => null,
            'message' => null,
            'body' => null
        ];

        if ($guzzleResponse instanceof RequestException){
            if(null !== $guzzleResponse->getResponse()) {
                $errorResponse = json_decode($guzzleResponse->getResponse()->getBody()->getContents());
                if(false === empty($errorResponse)) {
                    $response['code'] = $errorResponse->code;
                    $response['message'] = $errorResponse->message;
                    $response['body'] = $errorResponse->errors;
                } else {
                    $response['code'] = $guzzleResponse->getResponse()->getStatusCode();
                    $response['message'] = $guzzleResponse->getResponse()->getReasonPhrase();
                }
            } else {
                $response['code'] = $guzzleResponse->getCode();
                $response['message'] = $guzzleResponse->getMessage();
            }
        } else {
            /** @var ResponseInterface $guzzleResponse */
            $response['code'] = $guzzleResponse->getStatusCode();
            $response['location'] = $guzzleResponse->getHeader('Location')[0];
            $response['body'] = json_decode($guzzleResponse->getBody()->getContents());
        }

        return $response;
    }

    /**
     * @param string $token
     *
     * @return array
     */
    private function getHeader($token)
    {
        return [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ];
    }

    /**
     * @param string $version
     *
     * @return mixed
     */
    private function getBasePath($version)
    {
        return str_replace('{version}', $version,self::BASE_URI);
    }
}
