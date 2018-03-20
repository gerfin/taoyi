<?php

/**注册时发送短信验证码
 * @param $phone
 * @return int
 */
function sendSms($phone)
{
    $now = time();
    $post_time = sqlGetOne('sms', 'post_time', "tel = '$phone'", "post_time", "desc");
    if(($now - $post_time)<60)
    {
        throw new tyapiException("短信请求频繁",400,40001);
    }
    $code = rand(100000,999999);
    $res= sendCode($phone,'【淘艺商城】官人，您的验证码是：'.$code.'请勿告诉他人 ');
    if(!$res)
    {
        throw new tyapiException("短信发送失败",500,10009);

    }
    return $code;
}

/**设置短信发送参数
 * @param $tel
 * @param $content
 * @return bool
 */
function sendCode($tel,$content){
    $sms_type = 10;//投资成功短信
    $fields = array();
    $fields['Epid'] = '70057';
    $fields['User_Name'] = 'cjwy';
    $fields['password'] = substr(md5('cjhy1389'), 8, 16);//md5('cjhy1389');
    $fields['phone'] = $tel;
    $fields['content'] = $content;
    $url = 'http://61.191.26.181:8888/SmsPort.asmx/SendSms?';
    $o='';
    foreach ($fields as $k=>$v)
    {
        $o.="$k=".urlencode($v).'&';
    }
    $fields=substr($o,0,-1);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //如果需要将结果直接返回到变量里，那加上这句。
    $result = curl_exec($ch);
    if(preg_match("/00/",$result)){
        return true;
    }else{
        return false;
    }
}

/**
 * @param $phone
 * @throws tyapiException
 */
function deleteSmsCache($phone)
{
    $result = sqlDelete('sms',"tel = '$phone'");
    if(!$result)
    {
        throw new tyapiException("缓存出错",500,20004);
    }
}
