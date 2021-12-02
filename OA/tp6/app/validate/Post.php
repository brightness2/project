<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;

class Post extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'post_id|职位ID'=>'require',
        'post_name|职位名称'=>'require|unique:post',
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
        'add'  =>  ['post_name'],
        'edit' => ['post_id','post_name'],
    ];   
}
