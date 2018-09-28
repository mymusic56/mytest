<?php
//http://tool.oschina.net/commons
/**
 *
 * @param $path
 * @throws Exception
 */
function getMimeType($file)
{
    if (!file_exists($file)) {
        throw new Exception('文件不存在');
    }

    if (function_exists('mime_content_type')) {
        return mime_content_type($file);
    } else {
        if (class_exists('finfo')) {//fileinfo函数的对象接口
            $finfo    = finfo_open(FILEINFO_MIME_TYPE);
            $mimetype = strtolower(finfo_file($finfo, $file));
            finfo_close($finfo);
            return $mimetype;
        } elseif (function_exists('exec')) {
            return exec('file -ib '.$file);
        } else {
            throw new Exception('无法判断');
        }
    }
}
$path = 'a.txx.sql';
$path = 'pathinfo.php';
$path = 'a';
var_dump(getMimeType($path));
