<?php
namespace app\model;

use app\lib\exception\ZException;
use app\lib\model\Zmodel;

class AuthGroup extends Zmodel{

    /*******操作************* */
    public function edit($id,$data)
    {
        $row = $this->find($id);
        if(!$row){
            throw new ZException('数据不存在');
        }
        return $row->save($data);
    }

    public function remove($id)
    {
        $row = $this->find($id);
        if(!$row){
            throw new ZException('数据不存在');
        }
        return $row->delete();
    }

    /**
     * 设置规则
     *
     * @param int $id
     * @param array $rules 规则id数组
     * @return void
     */
    public function setRules($id,$rules = [])
    {
        $row = $this->find($id);
        if(!$row){
            throw new ZException('数据不存在');
        }
        $rules = implode(",",$rules);
        return $row->save(['rules'=>$rules]);
    }

    /**
     * 通过分组id获取权限
     *
     * @param int $groupId
     * @return array
     */
    public function getRulesByGroupId($groupId)
    {
       $row = $this->find($groupId);
       if(!$row){
           throw new ZException("数据不存在");
       }

       $rules = explode(",",$row->rules);
       return $rules;
    }
    /*********搜索器 */
    public function searchTitleAttr($query, $value, $data)
    {
        $query->where('title','like','%'.$value.'%');
    }
} 
