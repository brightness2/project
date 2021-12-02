<?php
namespace app\model;

use app\lib\exception\ZException;
use app\lib\model\Zmodel;

class Doc extends Zmodel{

    protected $SeqName = 'doc'; //计数序列
    protected $SeqPkPrefix = 'D'; //计数主键前缀
    protected $pk='d_id';


    /*******操作****** */
    public function getListByCategory($categoryId,DocCate $docCate,$search=[],$with=[])
    {
        //获取分类包括子分类
        $cateList = $docCate->getChildren($categoryId);
        //处理成分类id数组
        $cateIds = [];
        foreach($cateList as $cate){
            $cateIds[] = $cate['dc_id'];
        }
        $arr = [];
        if (is_array($search)) {
            foreach ($search as $key => $value) {
                if ($value !== null and $value !== '') {
                    $arr[$key] = $value;
                }
            }
        }
        $keys = array_keys($arr);
        return $this->whereIn('dc_id',$cateIds)->withSearch($keys, $arr)->with($with)->select();
    }

   

    public function getTotalByCategory($categoryId,DocCate $docCate)
    {
       $rows = $this->getListByCategory($categoryId,$docCate);
       return $rows->count();
    }

    public function upload($categoryId,$file)
    {
        //保存文件
      $savename = \think\facade\Filesystem::disk('public')->putFile( config('upload.document.dir'), $file);

      $data = [
        'd_name'=>$file->getOriginalName(),//获取原始名称
        'dc_id'=>$categoryId,
        'd_url'=>$savename,
        'd_type'=>$file->getMime(),
        'd_ext'=>$file->extension(),
        'd_create_time'=>date("Y-m-d H:i:s"),
      ];
      return  $this->save($data);
     
    }

    public function deleteFile($id)
    {
        $row = $this->find($id);
        if(!$row){
            throw new ZException("数据不存在");
        }
        $rs = $row->delete();
        $file = config('fileSystem.disks.public.root').D_S.$row->d_url;
        if(is_file($file)){
            unlink($file);
        }
        return $rs;
    }

    /***********搜索器******************* */
    public function searchNameAttr($query,$value)
    {
        $query->where('d_name','like','%'.$value.'%');
    }

    /******************关联********************* */
    public function category()
    {
        return $this->belongsTo(DocCate::class,'dc_id','dc_id');
    }
    
} 

