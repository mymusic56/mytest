<?php
class FileDeal {
	private $filename;
	private $mode;
	private $content;
	private $fp;
	private function fopen(){
		$this->fp = fopen($this->filename, $this->mode);
	}
	public function __construct($filename, $mode, $content){
		$this->filename = $filename;
		$this->mode = $mode;
		$this->content = $content;
	}
	public function writeSafe(){
		$this->fopen();
		$tryTimes = 0;
		while ($tryTimes < 1000){
			if(flock($this->fp, LOCK_EX)){
				fwrite($this->fp, $this->content);
				flock($this->fp, LOCK_UN);
				break;
			}else{
				usleep(1000);//1ms
				$tryTimes ++;
				return false;
			}
		}
		return fclose($this->fp);
	}
}

$filename = 'F:\test\a.txt';
$mode = 'a';
$date = date('Y-m-d H:i:s');
$content = "[{$date}] file write test\n";

function writeSafe($filename, $content){
	$fp = fopen($filename, 'a');
	if(flock($fp, LOCK_EX)){
		fwrite($fp, $content);
		flock($fp, LOCK_UN);
	}
	return fclose($fp);
}
$t1 = microtime(true);
// $fileHandler = new FileDeal($filename, $mode, $content);
// $res = $fileHandler->writeSafe();

$res = writeSafe($filename, $content);
$t2 = microtime(true);

#This function is identical to calling fopen(), fwrite() and fclose() 
#successively to write data to a file. 
$res2 = file_put_contents($filename, $content, FILE_APPEND);

$t3 = microtime(true);
var_dump($res, $res2, $t2- $t1, $t3- $t2);die;
