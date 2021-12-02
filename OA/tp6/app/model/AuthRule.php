<?php
namespace app\model;

use app\lib\model\Zmodel;

class AuthRule extends Zmodel{

     // 定义全局的查询范围
     protected $globalScope = ['status'];

     public function scopeStatus($query)
     {
         $query->where('status',1);
     }
 
} 
