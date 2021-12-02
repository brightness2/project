<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;

class Group extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'id|分组ID'=>'require',
        'title|分组名称'=>'require|unique:authGroup',
        'rules|规则'=>'require|array',
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
        'add'  =>  ['title'],
        'edit' => ['id','title'],
        'setRules'=>['id','rules'],
    ];   
}
