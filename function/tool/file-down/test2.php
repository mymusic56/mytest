<?php
/**
 * 以二进制方式读取写入文件
 * @param unknown $remote
 * @param unknown $local
 */
function downFile($remote, $local)
{
    try {
        $fp1 = fopen($remote, 'r');
        $fp2 = fopen($local, 'w+');
        while ($string = fread($fp1, 102400)) {
            fwrite($fp2, $string);
        }
        
        fclose($fp1);
        fclose($fp2);
    }catch (Exception $e){
        
    }
}
$remote = 'http://record-tool.oss-cn-hangzhou.aliyuncs.com/file%2Fa11f41c5a52138.aac?OSSAccessKeyId=oyfHUwaWeSdrYv4m&Expires=1527676954&Signature=z4QlTRltwqPuhaBzDuqsR8I2wFc%3D';
$local_file = 'test.aac';
downFile($remote, $local_file);