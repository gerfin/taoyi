<?php
/**判断手机号是否有效
 * @param $value
 * @return bool
 */
function isMobile($value)
{
    $rule = '^1(3|4|5|7|8|9)[0-9]\d{8}$^';
    $result = preg_match($rule, $value);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

function phoneCheck($phone)
{
    if(!isMobile($phone))
    {
        jsonData('400',[
            'errorCode' => '10012',
            'msg' => '手机号码不符合规则'
        ]);
    }
    return true;
}

function isToken($token)
{
    $result = preg_match("/^[A-Za-z\d]{32}$/",$token);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

/**token字符串验证
 * @param $token
 * @return bool
 */
function tokenCheck($token)
{
    if(!isToken($token))
    {
//        jsonData(404,[
//            'errorCode' => 30001,
//            'msg' => 'token字符串不符合规则'
//        ]);
        throw new tyapiException("token字符串不符合规则",403,30001);
    }
    return true;
}

function isPassword($password)
{

    if (!empty($password)) {
        return true;
    } else {
        return false;
    }
}


