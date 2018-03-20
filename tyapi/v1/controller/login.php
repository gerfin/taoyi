<?php
require_once dirname(dirname(__FILE__))."/service/loginService.php";
require_once dirname(dirname(__FILE__))."/validate/loginValidate.php";


/**
 *登录成功返回Token
 *不成功返回错误信息
 * @param $phoneIn
 * @param $passwordIn
 * @return bool
 * @throws tyapiException
 */
function login($phoneIn,$passwordIn)
{
    $phone = empty($phoneIn)?$_POST['phone']:$phoneIn;
    $password = empty($passwordIn)?$_POST['password']:$passwordIn;
    // 输入验证
    loginCheck($phone,$password);
    // 删除该手机号对应的之前的Token
    deletePreviousToken($phone);
    // 产生新的Token
    $tokenKey = generateToken();
    // 处理返回给客户端的信息
    $returnInfo = prepareReturnInfo($phone,$tokenKey);
    // 将token和用户信息已键值对的方式存下来
    $userId = $returnInfo['data']['user_id'];
    if(!saveToCache($tokenKey,json_encode($returnInfo),$userId))
    {
        throw new tyapiException("缓存出错",500,20001);
    }

    // 返回数据
    jsonData(200,$returnInfo);

    return true;
}