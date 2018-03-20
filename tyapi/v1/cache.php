<?php

/**存储token信息
 * @param $key
 * @param $value
 * @param int $expiry 过期时间，默认0，永不过期
 * @return bool 成功返回true，否则false
 */
function saveToCache($key, $value,$userId,$expiry=0)
{
    $now = time();
    $execResult = sqlAdd('tyapi_cache',
        ['key','value','user_id','expiry','create_date'],
        ["$key","$value","$userId","$expiry","$now"]);

    if($execResult)
        return true;
    else
        return false;
}

/**根据key获取token
 * @param $key
 * @return bool
 */
function getTokenCache($key)
{
    $sql =  "select value from"
        .$GLOBALS['ecs']->table('tyapi_cache')
        ."where `key`='$key'";
    $value = $GLOBALS['db']->getOne($sql);
    return $value?$value:false;
}

/**g根据key删除token
 * @param $key
 * @return bool
 */
function deleteTokenCache($key)
{
    $execResult = sqlDelete('tyapi_cache',"`key` = '$key'");

    if($execResult)
        return true;
    else
        return false;
}