<?php
/**
 * 参考地址：http://www.cnblogs.com/wayne173/p/6078205.html
 */

if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST'){
    if(isset($_FILES['upload']['error']) && $_FILES['upload']['error'] == 0){
        $localDir = '/Windows/www/mytest/Public/curl-upload/mp3/';
        if(!is_dir($localDir)){
            mkdir($localDir, 0755, true);
        }
        copy($_FILES['upload']['tmp_name'], $localDir.$_FILES['upload']['name']);
    }
    exit(json_encode($_FILES));
}

$url = "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['SERVER_NAME']}/function/curl/upload.php";
$post_data = array(
    "foo" =>"bar",
    //要上传的本地文件地址
    "upload" => new CURLFile("/Windows/www/mytest/Public/mp3/8-201707241824025297.mp3")
);
$ch = curl_init();
curl_setopt($ch , CURLOPT_URL , $url);
curl_setopt($ch , CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch , CURLOPT_POST, 1);
curl_setopt($ch , CURLOPT_POSTFIELDS, $post_data);
$output = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
var_dump($output,$httpCode);die;
?>