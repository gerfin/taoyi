<?php

/**保存用户信息
 * @param $phone
 * @param $username
 * @param $password
 */
function saveUser($phone,$username,$password)
{
    $saveUser = sqlAdd('users',['mobile_phone','user_name','password'],["$phone","$username","$password"]);
    if(!$saveUser)
    {
        jsonData('401',[
            'errorCode' => '10006',
            'msg' => 'mo'
        ]);
    }

}

/**存储验证码信息
 * @param $phone
 * @param $code
 */
function saveSmsCode($phone,$code)
{
    $now = time();
    $result = sqlAdd('sms',['tel','code','post_time'],[$phone,$code,$now]);

    if(!$result)
    {
        jsonData('500',[
            'errorCode' => '10010',
            'msg' => '存取验证码出错'
        ]);
    }
}