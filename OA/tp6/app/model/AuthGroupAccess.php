<?php
namespace app\model;

use app\lib\exception\ZException;
use app\lib\model\Zmodel;

class AuthGroupAccess extends Zmodel{

    /*******操作************* */

    public function getGroupByUser($userId)
    {
      return  $this->where('uid',$userId)->column(['group_id']);
    }
    /**
     * 保存一个用户的多个分组
     *
     * @param string $userId
     * @param array $groupIds 非重复
     * @return void
     */
    public function saveGroups($userId,$groupIds = [])
    {
       
       if(!is_array($groupIds) or count($groupIds) == 0 ){
           return false;
       }
       //开启事务
       $this->startTrans();
       $rs = false;
       try {
           //先删除当前用户原有的分组
            $this->where('uid',$userId)->delete();
            $data = [];
            foreach($groupIds as $groupId){
            $data[] = [
                'uid'=>$userId,
                'group_id'=>$groupId,
            ];   
            }
            $rs =  $this->saveAll($data);
            $this->commit();//提交
       } catch (\Exception $e) {
           $this->rollback();//回滚
       }
        
      return $rs;
    }

    /**
     * 删除用户一个分组
     *
     * @param string $userId
     * @param int $groupId
     * @return void
     */
    public function remove($userId,$groupId)
    {
        $row = $this->where('uid',$userId)->where('group_id',$groupId)->find();
        if(!$row){
            throw new ZException("数据不存在");
        }
        return $row->delete();
    }

} 
