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
    const BASE_URI = "";

    /**
     * @var GuzzleClient
     */
    protected $guzzleClient;

    /**
     * @var array
     */
    protected $guzzleOptions;

    public function __construct($token)
    {
        $this->buildHeader($token);

        $this->guzzleClient = new GuzzleClient([
            'base_uri' => self::BASE_URI,
        ]);
    }

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
            $response = $this->guzzleClient->request(
                $methode,
                $uri,
                $this->guzzleOptions
            );

            $json = $response->getBody();
        } catch (RequestException $exception) {
            $json = $exception->getResponse()->getBody()->getContents();
        }

        return json_decode($json);
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
