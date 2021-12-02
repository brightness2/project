<?php
// 中间件配置
return [
    // 别名或分组
    'alias'    => [
        'checkToken' => \app\middleware\Token::class,
        'checkAuth' => \app\middleware\Auth::class,

    ],
    // 优先级设置，此数组中的中间件会按照数组中的顺序优先执行
    'priority' => [
        'checkToken',
        'checkAuth',
    ],
    //全局中间件排除的操作，注意是路由中间件 或 应用中间件 或 控制器中间件
    'except' => [
        'checkToken' => [
            'Account/login', //注意大小写,控制器大驼峰
        ],
        'checkAuth' => [
            'Account/login',
            'Account/info',
            'Account/logout',
            'Index/index',
        ],
    ],

];
