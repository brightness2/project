<?php

namespace app\controller;

use app\BaseController;
use app\lib\exception\ZException;
use app\model\Dept as ModelDept;

class Dept extends BaseController
{
  
    public function getTotal()
    {
      $total = ModelDept::count();
      return show($total);
    }

    public function getList()
    {
      $searchParam = $this->request->param(['name','exc','limit','page']);
      $list =   ModelDept::getList($searchParam,['parent']);
      return show($list);
    }

    public function get()
    {
      $id = $this->request->param('id');
      if(empty($id)){
        throw new ZException('id不能为空');
      }
      $data = ModelDept::with(['parent'])->find($id);
      return show( $data); 
    }

    public function add()
    {
      $data = $this->request->param();
      $this->validate($data,'Dept.add');
      $key = ModelDept::create($data)->getKey();
      return show($key,'新增成功');
    }

    public function edit()
    {
      $data = $this->request->param();
      $this->validate($data,'Dept.edit');
      $model = new ModelDept();
      $res = $model->edit($data[$model->getPk()],$data);
      return show($res,'更新成功');
    }

    public function delete()
    {
      $id = $this->request->param('id');
      if(empty($id)){
        throw new ZException('id不能为空');
      }
      $res = (new ModelDept())->remove($id);
      return show($res,'删除成功');
    }

}
