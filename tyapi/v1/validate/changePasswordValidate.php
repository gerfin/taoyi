<?php

function forgetPasswordCheck($phone,$captcha)
{
    if(!isMobile($phone))
    {
        jsonData('400',[
            'errorCode' => '10012',
            'msg' => '手机号码不符合规则'
        ]);
    }
    $captchaServer = sqlGetOne('sms','code',"tel = '$phone'","post_time",'desc');
    if($captcha != $captchaServer)
    {
        jsonData('401',[
            'errorCode' => '10005',
            'msg' => '手机验证码不正确'
        ]);
    }

    return true;
}

function confirmUserCheck($phone)
{
    $result = sqlGetOne("users","1","mobile_phone = '$phone'");
    if(!$result)
    {
        jsonData("404",[
            "errorCode" => "10002",
            "msg" => "手机号码未注册"
        ]);
    }
}

/**
 * @param $token
 * @param $oldPassword
 * @param $newPassword
 * @return mixed
 * @throws tyapiException
 *
 */
function changePasswordCheck ($token,$oldPassword,$newPassword)
{
    $userId = sqlGetOne('tyapi_cache',"user_id","`key` = '$token'");
    if(empty($userId))
    {
//            jsonData("403",[
//                "errorCode" => "20004",
//                "msg" => "请求的token出错"
//            ]);
        throw new tyapiException("请求的token出错",403,20004);

    }
    $passwordServer = sqlGetOne('users','password',"user_id = $userId");

    if($oldPassword != $passwordServer)
    {
//            jsonData("403",[
//                'errorCode' => "10014",
//                'msg' => "原密码不正确"
//            ]);
        throw new tyapiException("原密码不正确",403,10014);

    }

    if(!isPassword($newPassword))
    {
        throw new tyapiException('新密码不符合规则',403,10014);
    }
    return $userId;
}