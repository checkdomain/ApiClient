<?php

namespace ApiClient\Client\Domain;

use ApiClient\Client\Base;
use ApiClient\Client\Core;
use ApiClient\Client\Domain\Nameserver\Records;

class Nameservers extends Base
{
    public function __construct(Core $core, $identifier = null)
    {
        parent::__construct($core, $identifier);

        $this->core->buildPath($identifier, __CLASS__);
    }

    public function records($identifier = null)
    {
        return new Records($this->core, $identifier);
    }

    public function retrieve()
    {
        return $this->core->get();
    }

    protected function replace()
    {

    }
}
