<?php
define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(dirname(__FILE__) . '/tyapi/v1/main.php');
require (dirname(__FILE__)).'/vendor/autoload.php';


if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

date_default_timezone_set('PRC');


$act = $_GET["act"];

switch ($act){
    case 'login':
        login();
        break;

    case 'register':
        register_api();
        break;

    case 'logout':
        logout_api();
        break;

    case 'forgot':
        forgotPassword_api();
        break;
    case 'banner':
        banner_api();
        break;
    default:
        /*jsonData('404',[
            'errorCode' => '00000',
            'msg' => '提供的act方式不正确'
        ]);*/
     throw new tyapiException("提供的act方式不正确",401,00000);
}