<?php
/**
 * 产生token
 * @return string
 */
function generateToken()
{
    //32个字符组成一组随机字符串
    $randChars = getRandChar(32);
    //用三组字符串，进行md5加密
    $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
    //salt
    $salt = TOKEN_SALT;

    return md5($randChars.$timestamp.$salt);
}