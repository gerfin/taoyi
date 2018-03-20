<?php
require_once "validate.php";

/**登录时手机号和密码验证
 * @param $phone
 * @param $password
 * @return mixed
 * @throws tyapiException
 */
function loginCheck($phone,$password)
{
    if(!isMobile($phone))
    {
        throw new tyapiException("手机号码不符合规则",401,10011);
    }

    $passwordServer = sqlGetOne('users','password',"mobile_phone = $phone");
    if(empty($passwordServer))
    {
        throw new tyapiException("手机号码不存在",401,10002);

    }
    $password = encryptPassword($password);
    if($password != $passwordServer)
    {
        throw new tyapiException("密码不正确",403,10003);

    }
    
    return true;
}