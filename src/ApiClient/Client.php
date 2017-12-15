<?php

namespace ApiClient;

use ApiClient\Client\Core;
use ApiClient\Client\Domains;

class Client
{
    /**
     * @var array
     */
    private $config;

    public function __construct($baseUri, $accessToken)
    {
        $this->config = [
            'base_uri' => $baseUri,
            'token' => $accessToken
        ];
    }

    public function domains($identifier = null)
    {
        return new Domains(new Core($this->config), $identifier);
    }
}
