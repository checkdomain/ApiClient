<?php

namespace ApiClient\Client;

abstract class Base {

    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var Core
     */
    protected $core;

    public function __construct(Core $core, $identifier = null)
    {
        $this->core = $core;

        $this->identifier = $identifier;
    }

}
