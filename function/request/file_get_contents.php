<?php
function sendPostRequest($url, $data){
	$postdata = http_build_query ( $data );
	$opts = array (
			'http' => array (
					'method' => 'POST',
					'header' => 'Content-type: application/x-www-form-urlencoded',
					'content' => $postdata
			)
	);
	
	
	$context = stream_context_create ( $opts );
	
	return file_get_contents ( $url, false, $context );
}
$url = 'http://www.qm.com/test/bbb';
$data = array(
		'name' => 'zhangsan',
		'pwd' => '123456',
);
var_dump(sendPostRequest($url, $data));