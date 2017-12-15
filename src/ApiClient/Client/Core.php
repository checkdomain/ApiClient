<?php

namespace ApiClient\Client;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\MessageInterface;

class Core
{
    /**
     * @var string
     */
    public $uri;

    /**
     * @var GuzzleClient
     */
    protected $guzzleClient;

    /**
     * @var array
     */
    protected $guzzleOptions;

    /**
     * @var array
     */
    private $config;

    public function __construct($config)
    {
        $this->config = $config;

        $this->guzzleClient = new GuzzleClient([
            'base_uri' => $this->config['base_uri']
        ]);

        $this->buildGuzzleOptions();
    }

    public function domains($identifier = null)
    {
        return new Domains($identifier);
    }

    public function get($query = array())
    {
        $this->guzzleOptions['query'] = $query;

        try {
            $response = $this->guzzleClient->get(
                $this->uri,
                $this->guzzleOptions
            );

            $json = $response->getBody();
        } catch (RequestException $exception) {
            $json = $exception->getResponse()->getBody()->getContents();
        }

        return json_decode($json);
    }

    public function post($request)
    {
        $this->guzzleOptions['body'] = json_encode($request);

        try {
            $response = $this->guzzleClient->post(
                $this->uri,
                $this->guzzleOptions
            );

            $json = $response->getBody();
        } catch (RequestException $exception) {
            $json = $exception->getResponse()->getBody()->getContents();
        }

        return [
            'header' => json_decode($response->getHeaders()),
            'code' => $response->getStatusCode(),
            'content' => json_decode($json),
        ];

        //return json_decode($json);
    }

    public function buildPath($identifier, $className)
    {
        $uri = $this->getPathFromClassName($className);

        $this->uri = trim($this->uri, "/");

        $this->uri .= "/".$uri;
        if (null !== $identifier) {
            $this->uri .= "/" . $identifier;
        }
    }

    public function buildActionPath($actionUri)
    {
        $this->uri .= "/".$actionUri;
    }

    private function buildHeader()
    {
        return [
            'Authorization' => 'Bearer ' . $this->config['token'],
            'Accept'        => 'application/json',
        ];
    }

    private function buildGuzzleOptions()
    {
        $this->guzzleOptions = [
            "headers" => $this->buildHeader()
        ];
    }

    private function getPathFromClassName($classname){
        $c = basename(str_replace('\\', '/', $classname));
        return strtolower($c);
    }
}
