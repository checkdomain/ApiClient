<?php

namespace ApiClient\Client\Domain;

use ApiClient\Client\Core;

class Nameservers
{
    /**
     * @var Core
     */
    private $core;

    public function __construct(Core $core, $identifier = null, $parentUri = null)
    {
        $this->core = $core;

        $this->core->buildPath($identifier, __CLASS__);
    }

    public function retrieve()
    {
        return $this->core->get();
    }

    protected function replace()
    {

    }
}
