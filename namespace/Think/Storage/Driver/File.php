<?php
namespace Think\Storage\Driver;
class File {
	public function isFile($filename){
		return is_file($filename);
	}
}