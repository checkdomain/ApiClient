<?php

namespace ApiClient\Client;

use ApiClient\Model\AbstractFilter;

class Articles extends Base
{
    public function __construct(Core $core, $identifier = null)
    {
        parent::__construct($core, $identifier);

        $this->core->buildPath($identifier, __CLASS__);
    }

    public function retrieve(AbstractFilter $filter = null)
    {
        return $this->core->get($filter);
    }
}
