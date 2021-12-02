<?php

declare(strict_types=1);

namespace app\middleware;

use app\lib\exception\ZException;
use think\wenhainan\Auth as WenhainanAuth;

class Auth
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        //前置，校验权限
        $action = $request->controller() . '/' . $request->action();
        $except = config('middleware.except.checkAuth'); //排除的操作
        if (!in_array($action, $except)) {
            $uid = $GLOBALS['USER']->uid;

            $auth = WenhainanAuth::instance();
            if (!$auth->check($action, $uid)) {
                throw new ZException('你没有该权限',null,401);
            }
        }

        //执行响应
        return $next($request);
    }
}
