<?php

namespace app\controller;

use app\BaseController;
use app\lib\domain\Upload as DomainUpload;
use app\lib\exception\ZException;

class Upload extends BaseController
{
    
   public function index()
   {
     $file = $this->request->param('file');
     $upload = new DomainUpload();
     $res = $upload->checkFile($file);
     return show($res);
   }
}
