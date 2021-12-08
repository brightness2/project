<?php
namespace app\model;

use app\lib\exception\ZException;
use app\lib\model\Zmodel;


class User extends Zmodel{

    protected $SeqName = 'user'; //计数序列
    protected $SeqPkPrefix = 'PM'; //计数主键前缀
    protected $pk='user_id';

    // 定义全局的查询范围
    protected $globalScope = ['removed'];

    public function scopeRemoved($query)
    {
        $query->where('removed',0);
    }

    /*******操作****** */

    public function getUser($userId)
    {
        $row = $this->find($userId);
        if(!$row){
            throw new ZException('账号不存在');
        }
        return $row;
    }

    public function add($data)
    {   
        $data['password'] = encryptPwd('123456');
        $this->save($data);
        return $this->user_id;
    }

    public function edit($userId,$data)
    {
        $row = $this->find($userId);
        if(!$row){
            throw new ZException('数据不存在');
        }
        return $row->save($data);
    }

    public function remove($userId)
    {
        $row = $this->find($userId);
        if(!$row){
            throw new ZException('账号不存在');
        }
        return $row->save(['removed'=>1]);
    }

    public function changePassword($userId,$pwd)
    {
        $row = $this->find($userId);
        if(!$row){
            throw new ZException('账号不存在');
        }
        return $row->save(['password'=>encryptPwd($pwd)]);
    }

    /*******搜索器*** */

     /**
    * 根据名称模糊查询
    */
   public function searchNameAttr($query, $value, $data)
   {
       $query->where('name','like', '%'.$value . '%');
   }
} 
