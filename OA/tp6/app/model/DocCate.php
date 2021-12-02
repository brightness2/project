<?php
namespace app\model;

use app\lib\exception\ZException;
use app\lib\model\Zmodel;

class DocCate extends Zmodel{

    protected $SeqName = 'doc_cate'; //计数序列
    protected $SeqPkPrefix = 'DC'; //计数主键前缀
    protected $pk = 'dc_id';
    protected $temp = [];//临时存储
    protected $count = 1;//计数
    /***操作* */
   public function edit($cateId,$data)
   {
       $row = $this->find($cateId);
       if(!$row){
           throw new ZException('数据不存在');
       }
       return $row->save($data);
    
   }

   public function remove($cateId)
   {
       $row = $this->find($cateId);
       if(!$row){
            throw new ZException('数据不存在');
       }
       return $row->delete();
   }

   /**
    * 递归获取分类的子分类
    * 包括自己
    * @param string $categoryId
    * @return array
    */ 
   public function getChildren($categoryId)
   {
      $row = $this->find($categoryId);
      if(!$row){
          return [];
      }
      $children = $this->where('dc_pid',$row->dc_id)->select();
      $children = $children->toArray();
      if(count($children)>0){
        $this->count++; 
        foreach($children as $child){
            $this->temp[] = $child;
            $this->getChildren($child['dc_id']);
        }
      }
      $this->count--; 
      if($this->count <= 0){//递归达到第一层
        $this->temp[] = $row;
        return $this->temp;
      }

   }

   /***********关联******* */
   public function parent()
   {
        return $this->belongsTo(DocCate::class,'dc_pid');
   }

   /************搜索器********** */
   /**
    * 根据名称模糊查询
    */
   public function searchNameAttr($query, $value, $data)
   {
       $query->where('dc_name','like', '%'.$value . '%');
   }

   /**
    * 根据id获取自己以外的数据
    */
   public function searchExcAttr($query, $value, $data)
   {
       $query->where('dc_id','<>' ,$value);
   }
  


   
} 
 