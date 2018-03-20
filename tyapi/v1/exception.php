<?php



set_exception_handler('myException');

class tyapiException extends Exception
{
    protected $message;
    protected $code;
    protected $errorCode;
    public function __construct($message = "", $code = 200,$errorCode=0, Throwable $previous = null)
    {
        $code = 200 ; //每次异常都给200状态码
        parent::__construct($message, $code, $previous);
        $this->errorCode = $errorCode;
    }
    public function getErrorCode()
    {
        return $this->errorCode;
    }
}


function myException($exception)
{
    //echo "<b>Exception:</b> " , $exception->getMessage();


    https($exception->getCode());
    $result["head"]["errorCode"] = $exception->getErrorCode();
    $result["head"]["msg"] = $exception->getMessage();
    echo json_encode($result);
}

set_exception_handler('myException');




