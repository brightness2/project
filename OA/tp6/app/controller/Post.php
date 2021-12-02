<?php

namespace app\controller;

use app\BaseController;
use app\lib\exception\ZException;
use app\model\Post as ModelPost;

class Post extends BaseController
{
  
    public function getTotal()
    {
      $total = ModelPost::count();
      return show($total);
    }

    public function getList()
    {
      $searchParam = $this->request->param(['name','exc','limit','page']);
      $list =   ModelPost::getList($searchParam,['parent']);
      return show($list);
    }

    public function get()
    {
      $id = $this->request->param('id');
      if(empty($id)){
        throw new ZException('id不能为空');
      }
      $data = ModelPost::with(['parent'])->find($id);
      return show( $data); 
    }

    public function add()
    {
      $data = $this->request->param();
      $this->validate($data,'Post.add');
      $key = ModelPost::create($data)->getKey();
      return show($key,'新增成功');
    }

    public function edit()
    {
      $data = $this->request->param();
      $this->validate($data,'Post.edit');
      $model = new ModelPost();
      $res = $model->edit($data[$model->getPk()],$data);
      return show($res,'更新成功');
    }

    public function delete()
    {
      $id = $this->request->param('id');
      if(empty($id)){
        throw new ZException('id不能为空');
      }
      $res = (new ModelPost())->remove($id);
      return show($res,'删除成功');
    }

}
