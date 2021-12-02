<?php

namespace app\controller;

use app\BaseController;
use app\lib\exception\ZException;
use app\model\Doc as ModelDoc;
use app\model\DocCate;

class Doc extends BaseController
{

    public function getTotal()
    {
      $cateId = $this->request->param('cate_id');
      
      if(empty($cateId)){
        throw new ZException("cate_id参数不能为空");
      }
      $model = new ModelDoc();
      $cateModel = new DocCate();
      $data = $model->getTotalByCategory($cateId,$cateModel);
      return show($data);
    }

    public function getList()
    {
      $cateId = $this->request->param('cate_id');
      $searchParam = $this->request->param(['name','exc','limit','page']);
      if(empty($cateId)){
        throw new ZException("cate_id参数不能为空");
      }
      $model = new ModelDoc();
      $cateModel = new DocCate();
      $data = $model->getListByCategory($cateId,$cateModel,$searchParam,['category']);
      return show($data);
    }

    public function upload()
    {
      $params = $this->request->param('jsonParams');
      $params = json_decode($params,true);
      if(!isset($params['cate_id']) or empty($params['cate_id'])){
        throw new ZException("cate_id 分类参数不能为空");
      }
      $file = $this->request->file('file');
      $fileSize = config('upload.document.fileSize');
      $fileExt = config('upload.document.fileExt');

      $fileRules = ['file'=>"require|fileSize:{$fileSize}|fileExt:{$fileExt}"];
      validate($fileRules)->check(['file'=>$file]);

      $rs = (new ModelDoc())->upload($params['cate_id'],$file);
      
      return show($rs);
    }

    public function download()
    {
      $id = $this->request->param('id');
      if(empty($id)){
        throw new ZException("id 不能为空");
      }
      $row = ModelDoc::find($id);
      if(!$row){
        throw new ZException("数据不存在");
      }
      $file = config('fileSystem.disks.public.root').D_S.$row->d_url;
      if(!is_file($file)){
          throw new ZException("文件不存在");
      }
      return download($file, $row->d_name);
      
    }

    public function delete()
    {
      $id = $this->request->param('id');
      if(empty($id)){
        throw new ZException("id 不能为空");
      }
      $rs = (new ModelDoc())->deleteFile($id);
      return show($rs,'删除成功');
    }
}
