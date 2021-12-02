<?php
// 应用公共文件

//返回结果
function show($data = null, $msg = '', $errCode = 0, $statusCode = 200)
{
    $jsonData = [
        'msg' => $msg,
        'data' => $data,
        'errCode' => $errCode,
    ];
    return json($jsonData, $statusCode);
}

//密码加密
function encryptPwd($pwd)
{
    return md5($pwd);
}
