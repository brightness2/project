<?php
namespace app\model;

use app\lib\exception\ZException;
use app\lib\model\Zmodel;

class Dept extends Zmodel{

    protected $SeqName = 'dept'; //计数序列
    protected $SeqPkPrefix = 'DT'; //计数主键前缀
    protected $pk = 'dt_id';

    /***操作* */
   public function edit($Id,$data)
   {
       $row = $this->find($Id);
       if(!$row){
           throw new ZException('数据不存在');
       }
       return $row->save($data);
    
   }

   public function remove($Id)
   {
       $row = $this->find($Id);
       if(!$row){
            throw new ZException('数据不存在');
       }
       return $row->delete();
   }

   /***********关联******* */
   public function parent()
   {
        return $this->belongsTo(Dept::class,'dt_pid');
   }

   /************搜索器********** */
   /**
    * 根据名称模糊查询
    */
   public function searchNameAttr($query, $value, $data)
   {
       $query->where('dt_name','like', '%'.$value . '%');
   }

   /**
    * 根据id获取自己以外的数据
    */
   public function searchExcAttr($query, $value, $data)
   {
       $query->where('dt_id','<>' ,$value);
   }
  


   
} 
 