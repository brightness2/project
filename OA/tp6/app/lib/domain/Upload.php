<?php
namespace app\lib\domain;

use think\exception\ValidateException;
use think\Validate;

class Upload{

    protected $file;#上传的文件
    protected $imageMaxWH = [2048,2048];#图片最大的宽高
    protected $imageType; #图片类型
    protected $fileExt;#文件后缀
    protected $fileSize;#文件最大字节

    public function checkFile($file)
    {
        
        $rule = [
            'file|文件'=>'require|file',
        ];
        $validate = new Validate();
        $res =   $validate->check(['file'=>$file],$rule);
        if(!$res){
            throw new ValidateException($validate->getError());
        }
        return $res;
    }

    public function save()
    {
       
        return 'dfd';
    }

    public function uploadImage($imageFile,$allowType=[],$maxWidth=0,$maxHeight=0)
    {
        # code...
    }
}