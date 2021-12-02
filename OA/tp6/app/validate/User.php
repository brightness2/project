<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;

class User extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'user_id|账号ID'=>'require',
        'name|账号名称'=>'require|unique:user',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [];

    /**
     * 场景
     */
    protected $scene = [
        'add'  =>  ['name'],
        'edit' => ['user_id','name'],
    ];   
}
