<?php
if(!class_exists('Util'))
{
	require_once dirname(__FILE__) .'/Util.php';
}
class MLoger{
	public static function write($childDir="",$log, $time = true)
	{
		$dir = dirname(__FILE__)."/log/".$childDir."/";
		if (!file_exists($dir))
			mkdir($dir);
		$utime = Util::udate("Y-m-d H:i:s.u");
		$utime = "[".substr($utime,0,23)."]";
		$tim = date('Ymd');
		$file  = $dir.$tim.'.log';//要写入文件的文件名（可以是任意文件名），如果文件不存在，将会创建一个
        if ($time) {
            $content = $utime." ".$log."\n";
        } else {
            $content = $log."\n";
        }
		if($f  = file_put_contents($file, $content,FILE_APPEND)){// 这个函数支持版本(PHP 5)
		}
	}
}