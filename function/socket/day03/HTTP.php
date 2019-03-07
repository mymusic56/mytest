<?php


class HTTP
{
    public static function encode($data)
    {
        $header = "HTTP/1.1 200 OK\r\n";
        $header .= "Content-Type: text/html;charset=utf-8\r\n";
        $header .= "Connection: Keep-Alive\r\n";
        $header .= "Server: MyServer\r\n\r\n";
        return $header.$data;
    }
}