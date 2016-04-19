<?php
require_once dirname(__FILE__) .'/Util.php';
class MLog{
	public static function write($log)
	{
		$utime = Util::udate("Y-m-d H:i:s.u");
		$utime = "[".substr($utime,0,23)."]";
		$tim = date('Ymd');
		$file  = dirname(__FILE__)."/log/".$tim.'.log';//要写入文件的文件名（可以是任意文件名），如果文件不存在，将会创建一个
		$content = $utime." ".$log."\n";
		if($f  = file_put_contents($file, $content,FILE_APPEND)){// 这个函数支持版本(PHP 5)
		}
	}
}