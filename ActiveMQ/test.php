<?php
require 'vendor/Stomp.php';

class Test{
	private $broker = 'tcp://192.168.11.177:61613';
	private $destination = '/queue/foo/a';
	public function getVersion(){
		return ActiveMQ\vendor\Stomp::version();
	}
	
	public function testSend(){
		$stomp = ActiveMQ\vendor\Stomp::getInstance();
		$msg = date('Y-m-d H:i:s').', this is my test';
		$stomp->connect($this->broker);
		$res = $stomp->send($this->destination, $msg);
		var_dump($res);
	}
	
	public function getMsg(){
		$stomp = ActiveMQ\vendor\Stomp::getInstance();
		$stomp->connect($this->broker);
		$stomp->subscribe($this->destination);
		$frame = $stomp->readFrame();
		var_dump($frame);
// 		$msg = $frame->body;
		if (isset($frame['body'])) {
			echo "{$frame['body']}, Worked\n";
			return $stomp->ack($frame);
		} else {
			echo "Failed\n";
		}
		
		$stomp->disconnect();
	}
}
$testObj = new Test();
var_dump($testObj->getVersion());
$testObj->testSend();
// var_dump($testObj->getMsg());
