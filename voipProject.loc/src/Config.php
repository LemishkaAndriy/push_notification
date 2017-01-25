<?php

namespace Src;


class Config
{
    private $params;

    public function __construct()
    {
        $this->params = require_once('config.php');
    }

    /**
     * param string $id
     * return mixed
     */
    public function get($id)
    {
        if (!isset($this->params[$id])) {
            throw new \InvalidArgumentException(sprintf('Parameter "%s" does not exists!'), $id);
        }
        return $this->params[$id];
    }

    /**
     * param string $id
     * return bool
     */
    public function has($id)
    {
        return isset($this->params[$id]);
    }
}