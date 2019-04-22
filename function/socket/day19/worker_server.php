<?php

class HttpServer
{
    public $onRequest;
    private $host = '';
    private $port;

    private $server;

    public function __construct($host, $port)
    {
        $this->host = $host;
        $this->port = $port;
        $this->server = new swoole_http_server($this->host, $this->port);
    }

    public function set($option)
    {
        $this->server->set($option);
    }

    private function addEvent()
    {
        $this->server->on('request', $this->onRequest);
    }

    public function start()
    {
        $this->addEvent();
        $this->server->start();
    }
}