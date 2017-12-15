<?php

namespace ApiClient\Client;

use ApiClient\Client;

class Domains extends Base
{
    public function __construct(Core $core, $identifier = null)
    {
        parent::__construct($core, $identifier);

        $this->core->buildPath($identifier, __CLASS__);
    }

    public function nameserver()
    {
        if(null !== $this->identifier) {
            return new Client\Domain\Nameservers($this->core,null);
        } else {
            throw new \Exception("Domain identifier required");
        }
    }

    public function checks()
    {
        $this->core->buildActionPath(__FUNCTION__);

        return $this->core->get();
    }

    public function retrieve()
    {
        return $this->core->get();
    }

    protected function create()
    {
        return $this->core->post();
    }

    protected function replace()
    {

    }

    protected function update()
    {

    }
}
