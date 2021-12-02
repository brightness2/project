<?php

namespace app\controller;

use app\BaseController;
use app\lib\domain\Tools;
use app\lib\exception\ZException;
use app\model\DocCate as ModelDocCate;

class DocCate extends BaseController
{
  
    public function getTotal()
    {
      $total = ModelDocCate::count();
      return show($total);
    }

    public function getList()
    {
      $searchParam = $this->request->param(['name','exc','limit','page']);
      $list =   ModelDocCate::getList($searchParam,['parent']);
      return show($list);
    }

    public function getTree()
    {
      $searchParam = $this->request->param(['name','exc','limit','page']);
      $list =   ModelDocCate::getList($searchParam);
      $list = $list->toArray();
      $tree = Tools::list_to_tree($list,'dc_id','dc_pid');
      return show($tree);
    }

    public function get()
    {
      $id = $this->request->param('id');
      if(empty($id)){
        throw new ZException('id不能为空');
      }
      $data = ModelDocCate::with(['parent'])->find($id);
      return show( $data); 
    }

    public function add()
    {
      $data = $this->request->param();
      $this->validate($data,'DocCate.add');
      $key = ModelDocCate::create($data)->getKey();
      return show($key,'新增成功');
    }

    public function edit()
    {
      $data = $this->request->param();
      $this->validate($data,'DocCate.edit');
      $model = new ModelDocCate();
      $res = $model->edit($data[$model->getPk()],$data);
      return show($res,'更新成功');
    }

    public function delete()
    {
      $id = $this->request->param('id');
      if(empty($id)){
        throw new ZException('id不能为空');
      }
      $res = (new ModelDocCate())->remove($id);
      return show($res,'删除成功');
    }

}
