<?php

namespace app\controller;

use app\BaseController;
use app\lib\domain\Upload;

class Index extends BaseController
{
    public function index()
    {
       $upload = new Upload();

        return $upload->save();
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }


}
