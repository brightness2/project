<?php

namespace app\controller;

use app\BaseController;
use app\lib\exception\ZException;
use app\model\AuthGroup;

class Group extends BaseController
{
  
    public function getTotal()
    {
      $total = AuthGroup::count();
      return show($total);
    }

    public function getList()
    {
      $searchParam = $this->request->param(['title','exc','limit','page']);
      $list =   AuthGroup::getList($searchParam);
      return show($list);
    }

    public function get()
    {
      $id = $this->request->param('id');
      if(empty($id)){
        throw new ZException('id不能为空');
      }
      $data = AuthGroup::find($id);
      return show( $data); 
    }

    public function add()
    {
      $data = $this->request->except(['rules']);
      $this->validate($data,'Group.add');
      $key = AuthGroup::create($data)->getKey();
      return show($key,'新增成功');
    }

    public function edit()
    {
      $data = $this->request->except(['rules']);
      $this->validate($data,'Group.edit');
      $model = new AuthGroup();
      $res = $model->edit($data[$model->getPk()],$data);
      return show($res,'更新成功');
    }

    public function delete()
    {
      $id = $this->request->param('id');
      if(empty($id)){
        throw new ZException('id不能为空');
      }
      $res = (new AuthGroup())->remove($id);
      return show($res,'删除成功');
    }

    public function setRules()
    {
      $data = $this->request->post(['id','rules']);
      $this->validate($data,'Group.setRules');
      $model = new AuthGroup();
      $res = $model->setRules($data['id'],$data['rules']);      
      return show(true,"设置成功");
      
    }

    public function getRules()
    {
      $groupId = $this->request->param('id');
      if(!$groupId){
        throw new ZException("分组id不能为空");
      }
      $permission = (new AuthGroup())->getRulesByGroupId($groupId);
      return show($permission);
    }
}
