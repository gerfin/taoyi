<?php
require_once dirname(dirname(__FILE__))."/validate/changePasswordValidate.php";
/**
 * @throws tyapiException
 */
function forgotPassword_api()
{
    /**
     * 新密码直接替换旧密码
     */
    if(!empty($token = $_POST["token"]))
    {
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        // 验证前端输入
        $userId = changePasswordCheck($token,$oldPassword,$newPassword);
        // 更改密码
        directUpdatePassword($newPassword,$userId);
        // 返回信息
        jsonData("200",[
            "success"=>"更改密码成功",
            "user_id"=>"$userId"
        ]);

    }
    /**
     * 忘记密码（发送短信验证码）
     */
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $phone = trim($_GET['phone']);
        // 验证前端输入
        phoneCheck($phone);
        confirmUserCheck($phone);
        // 发送短信验证码
        $code = sendSms($phone);
        // 缓存短信验证码
        saveSmsCode($phone,$code);
        // 返回信息
        jsonData('200',[
            'name' => 'sms code',
            'code' => $code
        ]);
    }

    /**
     * 忘记密码（请求更改密码）
     */
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $captcha = $_POST['captcha'];
        // 前端输入验证
        forgetPasswordCheck($phone,$captcha);
        // 更改密码
        updatePassword_forgot($phone,$password);
        // 删除该手机号之前的短信缓存
        deleteSmsCache($phone);
        // 返回信息
        jsonData("200",[
            "success"=>"更改密码成功",
            "phone"=>"$phone"
        ]);
    }

}

