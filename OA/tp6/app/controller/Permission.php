<?php

namespace app\controller;

use app\BaseController;
use app\model\AuthRule;

class Permission extends BaseController
{
  
    public function getTotal()
    {
      $total = AuthRule::scope('status')->count();
      return show($total);
    }

    public function getList()
    {
      $searchParam = $this->request->param(['limit','page']);
      $list =   AuthRule::getList($searchParam);
      return show($list);
    }


}
