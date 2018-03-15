<?php
/**
 * 以二进制方式读取写入文件
 * @param unknown $remote
 * @param unknown $local
 */
function downFile($remote, $local)
{
    header("Content-Type: application/octet-stream");
    header("Accept-Ranges: bytes");
    $fp1 = fopen($remote, 'r');
    $fp2 = fopen($local, 'w+');
    while ($string = fread($fp1, 102400)) {
        fwrite($fp2, $string);
    }
    
    fclose($fp1);
    fclose($fp2);
}
$remote = '';
$local_file = '';
downFile($remote, $local_file);