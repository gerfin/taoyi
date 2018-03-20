<?php
/**
 * 用户注销登录状态，从数据库中删除Token信息
 * @throws tyapiException
 */

function logout_api()
{
    $token = $_POST['token'];
    tokenCheck($token);
    $user_id = sqlGetOne('tyapi_cache',"user_id","`key` = '$token'");
    $result = sqlDelete('tyapi_cache',"user_id = '$user_id'");

    if($result)
    {
        jsonData(200,[
            'name' => "logout successfully(user_id:$user_id)",
            'description' => '注销成功'
        ]);
    }
    else
    {
        throw new tyapiException("缓存出错",500,20002);
    }
}