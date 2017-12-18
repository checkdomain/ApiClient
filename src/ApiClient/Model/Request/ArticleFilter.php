<?php

namespace ApiClient\Model\Request\Domain;

use ApiClient\Model\AbstractFilter;

class ArticleFilter extends AbstractFilter
{
    private $title;

    private $tld;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTld()
    {
        return $this->tld;
    }

    /**
     * @param mixed $tld
     *
     * @return $this
     */
    public function setTld($tld)
    {
        $this->tld = $tld;

        return $this;
    }
}
