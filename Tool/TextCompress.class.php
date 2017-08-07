<?php
class TextCompress {
    public static function compress_html($string) {
        return ltrim(rtrim(preg_replace(array(
                "/> *([^ ]*) *</",
                "//",
                "'/\*[^*]*\*/'",
                "/\r\n/",
                "/\n/",
                "/\t/",
                '/>[ ]+</',
                '/<strong>|<\/strong>/',
        ),
                array(
                        ">\\1<",
                        '',
                        '',
                        '',
                        '',
                        '',
                        '><',
                        ''
                ), $string)));
    }
    
    public static function converToUtf8($string){
        $charset = mb_detect_encoding($string, array('UTF-8','GBK','GB2312'));
        
        if('CP936' == $charset){
            $charset='GBK';
        }
        
        if("UTF-8" != $charset){
            $string = iconv($charset,"UTF-8//IGNORE", $string);
        }
        return $string;
    }
}