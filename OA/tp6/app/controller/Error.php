<?php

namespace app\controller;

use app\lib\exception\ZException;

class Error
{

    public function __call($name, $arguments)
    {
        throw new ZException("资源不存在");
    }
}
