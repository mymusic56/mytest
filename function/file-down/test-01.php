<?php
function downfile($fileName,$filePath){
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.$fileName);
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header('Content-Length: ' . filesize($filePath));
	readfile($filePath);//读取文件并写入到输出缓冲
}

$fileName = '640.jpg';
$filePath = realpath($_SERVER['DOCUMENT_ROOT']).'/Public/img/640.jpg';
downfile($fileName,$filePath);