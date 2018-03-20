<?php
/**
 * @param $newPassword
 * @param $userId
 * @return bool
 * @throws tyapiException
 */
function directUpdatePassword($newPassword,$userId)
{
    $result = sqlUpdate('users',["password = '$newPassword'"],"user_id = $userId");
    if(!$result)
    {
        throw new tyapiException("更改密码时出错",500,10013);

    }
    return true;
}

function updatePassword_forgot($phone,$password){
    $result = sqlUpdate('users',["password = '$password'"],"mobile_phone = '$phone'");
    if(!$result)
    {
        throw new tyapiException("更改密码时出错",500,10013);
    }
    return true;

}