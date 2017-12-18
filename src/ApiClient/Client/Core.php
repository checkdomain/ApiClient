<?php

namespace ApiClient\Client;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use phpDocumentor\Reflection\Types\Object_;
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

    public function get($filter = null)
    {
        if(null !== $filter) {
            $this->guzzleOptions['query'] = $this->convertModelToArray($filter);
        }

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

        return json_decode($json);
    }

    public function put($request)
    {
        $this->guzzleOptions['body'] = json_encode($request);

        try {
            $response = $this->guzzleClient->put(
                $this->uri,
                $this->guzzleOptions
            );

            $json = $response->getBody();
        } catch (RequestException $exception) {
            $json = $exception->getResponse()->getBody()->getContents();
        }

        return json_decode($json);
    }

    public function patch($request)
    {
        $this->guzzleOptions['body'] = json_encode($request);

        try {
            $response = $this->guzzleClient->patch(
                $this->uri,
                $this->guzzleOptions
            );

            $json = $response->getBody();
        } catch (RequestException $exception) {
            $json = $exception->getResponse()->getBody()->getContents();
        }

        return json_decode($json);
    }


    public function buildPath($identifier, $className)
    {
        $uri = $this->getPathFromClassName($className);

        if (!empty($this->uri)) {
            $this->uri .= "/" . $uri;
        } else {
            $this->uri = $uri;
        }

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

    /**
     * Convertiert die Private Vars eines Models zu einem Array
     *
     * @param        $object
     * @param        $skipEmpty
     *
     * @return array $array
     */
    private function convertModelToArray($object, $skipEmpty = true)
    {
        $array = [];

        $methodes = get_class_methods($object);
        foreach ($methodes as $methode) {
            if (strpos($methode, "get") !== false) {
                $value = $object->$methode();
                if(true === $skipEmpty && empty($value)) {
                    continue;
                }
                if (is_object($value)) {
                    $value = $this->convertModelToArray($value);
                }

                $array[strtolower(str_replace('get','', $methode))] = $value;
            }
        }

        return $array;
    }
}
