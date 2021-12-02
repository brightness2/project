<?php

namespace app\controller;

use app\BaseController;
use app\lib\exception\ZException;
use app\model\AuthGroupAccess;
use app\model\User as ModelUser;
use think\wenhainan\Auth;

class User extends BaseController
{
    
    public function getTotal()
    {
      $total = ModelUser::scope('removed')->count();
      return show($total);
    }

    public function get()
    {
      $id = $this->request->param('id');
      if(empty($id)){
        throw new ZException('id不能为空');
      }
      $user = (new ModelUser())->getUser($id);
      return show($user->hidden(['password']));
    }

    public function getList()
    {
      $searchParams = $this->request->param(['name','limit','page']);
      $list = ModelUser::getList($searchParams);
      return show($list->hidden(['password']));
    }

    public function add()
    {
      $data = $this->request->param();
      $this->validate($data,'User.add');
      $key = (new ModelUser())->add($data);
      return show($key,'新增成功');
    }

    public function edit()
    {
      $data = $this->request->except(['password']);
      $this->validate($data,'User.edit');
      $model = new ModelUser();
      $res = $model->edit($data[$model->getPk()],$data);
      return show($res,'更新成功');
    }

    public function delete()
    {
      $id = $this->request->param('id');
      if(empty($id)){
        throw new ZException('id不能为空');
      }
      $res = (new ModelUser())->remove($id);
      return show($res,'删除成功');
    }

    public function resetPassword()
    {
        $id = $this->request->param('id');
        if(empty($id)){
          throw new ZException('id不能为空');
        }
        $res = (new ModelUser())->changePassword($id,'123456');
        return show($res,'密码重置成功');
    }

    public function getGroupByUser()
    {
      $userId = $this->request->param('id');
      if(empty($userId)){
        throw new ZException("用户id不能为空");
      }
      $data = (new AuthGroupAccess())->getGroupByUser($userId);
      return show($data);
    }
    
    public function setGroup()
    {
      $groupIds = $this->request->param('group_ids');
      $userId = $this->request->param('id');
      if(empty($userId)){
        throw new ZException("用户id不能为空");
      }
      if(empty($groupIds) or !is_array($groupIds)){
        throw new ZException("分组参数必须是数组");
      }
    
      $model = new AuthGroupAccess();
      $rs = $model->saveGroups($userId,$groupIds);
      return show($rs,"更新成功");

    }
   
}
