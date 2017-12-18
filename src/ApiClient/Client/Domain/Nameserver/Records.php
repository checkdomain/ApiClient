<?php

namespace ApiClient\Client\Domain\Nameserver;

use ApiClient\Client\Base;
use ApiClient\Client\Core;
use ApiClient\Model\Request\Domain\Nameserver\Record;

class Records extends Base
{
    public function __construct(Core $core, $identifier = null)
    {
        parent::__construct($core, $identifier);

        $this->core->buildPath($identifier, __CLASS__);
    }

    public function retrieve()
    {
        return $this->core->get();
    }

    public function create(Record $request)
    {
        return $this->core->post($request);
    }

    public function replace(Record $request)
    {
        return $this->core->put($request);
    }
}
