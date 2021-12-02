<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;

class DocCate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'dc_id|分类ID'=>'require',
        'dc_name|分类名称'=>'require|unique:docCate',
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
        'add'  =>  ['dc_name'],
        'edit' => ['dc_id','dc_name'],
    ];   
}
