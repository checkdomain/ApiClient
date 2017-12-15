<?php

namespace ApiClient\Client;

use GuzzleHttp\Client as GuzzleClient;
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
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }

        return $this->buildReponse($response);
    }

    public function post($request)
    {
        $this->guzzleOptions['body'] = json_encode($request);

        try {
            $response = $this->guzzleClient->post(
                $this->uri,
                $this->guzzleOptions
            );
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }

        return $this->buildReponse($response);
    }

    public function buildPath($identifier, $className)
    {
        $uri = $this->getPathFromClassName($className);

        $this->uri .= $uri;
        if (null !== $identifier) {
            $this->uri .= "/" . $identifier;
        }
    }

    public function buildActionPath($actionUri)
    {
        $this->uri .= "/".$actionUri;
    }

    protected function buildReponse(MessageInterface $response = null)
    {
        return json_decode($response->getBody());
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
