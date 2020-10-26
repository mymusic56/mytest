<?php
class Server{
    
    public $checkLogin = null;

    public $userName = "zhangsan";
    
    public function start()
    {
        echo "server start...</br>";
        $data = ['name' => 'zhangsan', 'time' => date('Y-m-d H:i:s')];
        $data2 = 'mmmmmmmmmmmmmmmm';
        if ($this->checkLogin) {
            $return = call_user_func($this->checkLogin, $data, $data2, $this->userName);
            echo 'checkLogin return'.json_encode($return).'</br>';
        }
        echo 'server end.</br>'.PHP_EOL;
    }
}