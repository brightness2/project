<?php

namespace app\controller;

use app\BaseController;


class Index extends BaseController
{
    public function index()
    {
        
       return 'hello Brightness';
    }

    public function test()
    {
       $arr = config('mailer');
       $mailer = new \app\lib\domain\Mailer($arr['host'],$arr['from'],$arr['fromName'],$arr['password']);
       $mailer->setContent('测试标题','<h1>测试内容</h1>');
       $mailer->addAddress('2390408895@qq.com','jh.zeng');
       //$mailer->send();//发送
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }

}
