<?php

namespace app;

use app\lib\exception\ZException;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\Handle;
use think\exception\HttpException;
use think\exception\HttpResponseException;
use think\exception\ValidateException;
use think\Response;
use Throwable;

/**
 * 应用异常处理类
 */
class ExceptionHandle extends Handle
{
    /**
     * 不需要记录信息（日志）的异常类列表
     * @var array
     */
    protected $ignoreReport = [
        HttpException::class,
        HttpResponseException::class,
        ModelNotFoundException::class,
        DataNotFoundException::class,
        ValidateException::class,
    ];

    /**
     * 记录异常信息（包括日志或者其它方式记录）
     *
     * @access public
     * @param  Throwable $exception
     * @return void
     */
    public function report(Throwable $exception): void
    {
        // 使用内置的方式记录异常日志
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @access public
     * @param \think\Request   $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        // 添加自定义异常处理机制
        //验证错误
        if ($e instanceof ValidateException) {
            return show(null, $e->getMessage(), config('errCode.param'));
        }
        //业务/自定义异常
        if ($e instanceof ZException) {
            return show($e->data, $e->msg, $e->errCode, $e->getCode());
        }
        //没有开启调试时，不抛出异常信息
        if (!env('APP_DEBUG')) {
            return show(null, '服务异常,请联系开发', config('errCode.system'), config('errCode.success'));
        }
        // 其他错误交给系统处理
        return parent::render($request, $e);
    }
}
