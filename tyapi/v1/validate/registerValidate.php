<?php
/**
*注册时验证相关信息是否正确
 * @param $phone
 * @param $username
 * @param $captcha
 * @param $captchaServer
 * @throws tyapiException
 */
function registerCheck($phone,$username,$captcha)
{
    registerPhoneCheck($phone);
    usernameCheck($username);
    $captchaServer = sqlGetOne('sms','code',"tel = '$phone'","post_time",'desc');
    if($captcha != $captchaServer)
    {
        throw new tyapiException("手机验证码不正确",400,10005);
    }
}

/**
 * 判断当前手机号是否有效和注册
 * @param $phone
 * @throws tyapiException
 */
function registerPhoneCheck($phone)
{
    if(!isMobile($phone))
    {
        throw new tyapiException("手机号码不符合规则",400,10001);
    }
    $userId = sqlGetOne('users','user_id',"mobile_phone = $phone");
    if($userId)
    {
        throw new tyapiException("该手机号已注册",400,10004);

    }
}

/**
 * @param $username
 * @return bool
 * @throws tyapiException
 */
function usernameCheck($username)
{

    $result = preg_match("/^[A-Za-z\_\d]+$/",$username);
    if (!$result) {
        throw new tyapiException("用户名不符合规则",403,10008);
    }

    $userId = sqlGetOne('users','user_id',"user_name = '$username'");
    if($userId)
    {
        throw new tyapiException("该用户名已存在",401,10004);
    }

    return true;
}

