<?php

namespace app\controller;

use app\BaseController;
use app\lib\domain\JWT;
use app\lib\exception\ZException;
use app\model\AuthRule;
use app\model\User;
use think\wenhainan\Auth as WenhainanAuth;
class Account extends BaseController
{
    
    public function login()
    {
      $name = $this->request->param('username');
      $password = $this->request->param('password');
      if(empty($name) or empty($password)){
        throw new ZException('账号和密码不能为空');
      }
      $password = encryptPwd($password);
      $row = User::where('name',$name)->where('password',$password)->find();
      if(!$row){
        throw new ZException('账号或密码错误');
      }
      $data = [
        'user'=>$row->hidden(['password']),
        'token'=>JWT::signToken($row->user_id),
      ];
      return show($data,'登录成功');
    }


    public function logout()
    {
      return show(true);
    }

    public function info()
    {
      $uid = $GLOBALS['USER']->uid;
      $row = User::find($uid);
      if(!$row){
        throw new ZException("账号不存在，请重新登录",403);
      }
      $list = [];
      if($uid === 'PM0001'){
        $rows = AuthRule::column(['name']);
        foreach($rows as $item){
          $list[] =strtolower($item);
        }
      }else{
        $auth = WenhainanAuth::instance();
        $list = $auth->getAuthList($uid,1);
      }
     
      $row['roles'] = $list;
      return show($row->hidden(['password']));
    }
}
