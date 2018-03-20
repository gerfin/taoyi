<?php
require_once dirname(dirname(__FILE__))."/validate/registerValidate.php";
require_once dirname(dirname(__FILE__))."/service/registerService.php";

/**用户注册
 * GET请求用于发送验证码
 * POST请求用于存储用户信息，并返回用户token
 * @throws tyapiException
 */
function register_api()
{
    /**
     * 注册时发送短信验证码
     */
    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {

        $phone = $_GET['phone'];
        // 手机号检验
        registerPhoneCheck($phone);
        // 生成验证码并发送
        $code = sendSms($phone);
        // 存入短信验证码
        saveSmsCode($phone,$code);
        // 同步推送给前端[上线时需删除]
        jsonData('200',[
            'name' => 'sms code',
            'code' => $code
        ]);
    }

    /**
     * 注册过程
     */
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $captcha = $_POST['captcha'];
        $username = empty($_POST['username'])?"tyuser".time().getRandChar(2):$_POST['username'];
        // 注册时检测
        registerCheck($phone,$username,$captcha);
        // 用户密码加密
        $encryptPassword = encryptPassword($password);
        // 存储用户信息
        saveUser($phone,$username,$encryptPassword);
        // 删除该手机号之前的短信验证码
        deleteSmsCache($phone);
        // 注册后登录，返回token
        login($phone,$password);exit;

    }
}