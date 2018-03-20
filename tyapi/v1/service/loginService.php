<?php
/** 准备返回的简略用户信息
 * @param $phone
 * @param $tokenKey
 * @return mixed
 */
function prepareReturnInfo($phone,$tokenKey)
{
    $info = sqlGetRow('users','user_id,user_name,last_login,last_ip',"mobile_phone = $phone");
    $returnInfo['name'] = 'login information';
    $returnInfo['token'] = $tokenKey;
    $returnInfo['data'] = $info;
    return $returnInfo;
}

/**删除之前的token
 * @param $phone
 * @return bool
 * @throws tyapiException
 */
function deletePreviousToken($phone)
{
    $user_id = sqlGetOne('users',"user_id","`mobile_phone` = '$phone'");
    $result = sqlDelete('tyapi_cache',"user_id = $user_id");
    if(!$result)
    {
//        jsonData(500,[
//            'errorCode' => '20003',
//            'msg' => '缓存出错'
//        ]);
        throw new tyapiException("缓存出错",500,20003);
    }
    return true;
}