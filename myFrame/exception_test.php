<?php
class MyException{
    public static function register()
    {
        //注册异常处理
        error_reporting(E_ALL);
        set_error_handler([__CLASS__, 'appError']);
        set_exception_handler([__CLASS__, 'appException']);
        register_shutdown_function([__CLASS__, 'appShutdown']);
        var_dump('register error execption handler.');
    }
    
    public static function appException(){
        var_dump(__CLASS__.':appException');
    }
    public static function appError(){
        var_dump(__CLASS__.':appError');
    }
    public static function appShutdown(){
        var_dump(__CLASS__.':appShutdown');
    }
}

class A{
    public function __construct()
    {
        MyException::register();
    }
    
    
    public function aaa()
    {
        try {
            $a = 1/0;
            var_dump('==============================');
            $this->b();
        } catch (Exception $e) {
            var_dump('捕获异常：'.$e->getMessage());
        }
    }
    
    private function b()
    {
        throw new Exception('异常抛出-----------');
    }
}

(new A())->aaa();