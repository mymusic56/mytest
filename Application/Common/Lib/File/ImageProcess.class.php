<?php
namespace Common\Lib\File;
class ImageProcess {
    private static $jpgQuality = 50;
    private static $gifQuality = 50;
    private static $pngQuality = 50;
    public static function downloadImage($srcUrl, $destDir){
        $header = array("Connection: Keep-Alive", "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8", "Pragma: no-cache", "Accept-Language: zh-Hans-CN,zh-Hans;q=0.8,en-US;q=0.5,en;q=0.3", "User-Agent: Mozilla/5.0 (Windows NT 5.1; rv:29.0) Gecko/20100101 Firefox/29.0");
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $srcUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
        
        $content = curl_exec($ch);
        
        $curlinfo = curl_getinfo($ch);
        //关闭连接
        curl_close($ch);
        if ($curlinfo['http_code'] == 200) {
            
            if ($curlinfo['content_type'] == 'image/jpeg') {
                $suffix = '.jpg';
            } else if ($curlinfo['content_type'] == 'image/png') {
                $suffix= '.png';
            } else if ($curlinfo['content_type'] == 'image/gif') {
                $suffix= '.gif';
            }else {
                return false;
            }
            $name = date("YmdHis") . uniqid() . $suffix;
            $filpath = $destDir.DIRECTORY_SEPARATOR.$name;
            $fp2=fopen($filpath,'a');
            $flag = fwrite($fp2,$content);
            fclose($fp2); 
            if($flag === false){
                return false;
            }
            return array('path'=>$filpath, 'name'=>$name);
        }
        return null;
    }
    /**
     * 
     * @param unknown $imgsrc
     * @param unknown $imgdst
     */
    public static function imageCompress($imgsrc,$imgdst){
        list($width,$height,$type)=getimagesize($imgsrc);
        $new_width = 500;
        $new_height = 500;
        // 	    var_dump($width,$height,$type);die;
        switch($type){
            case 1:
                $giftype=self::check_gifcartoon($imgsrc);
                if($giftype){
                    $image_wp=imagecreatetruecolor($new_width, $new_height);
                    $image = imagecreatefromgif($imgsrc);
                    imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                    //75代表的是质量、压缩图片容量大小
                    imagejpeg($image_wp, $imgdst,self::$gifQuality);
                    imagedestroy($image_wp);
                }
                break;
            case 2:
                $image = imagecreatefromjpeg($imgsrc);
                
                $exif = exif_read_data($imgsrc);
                if(!empty($exif['Orientation'])){
                    $angle = self::imageRotateAngle($exif['Orientation']);
                    if($angle != 0){
                        $image = imagerotate($image,$angle,0);
                    }
                }
                
                $image_wp=imagecreatetruecolor($new_width, $new_height);
                imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                //75代表的是质量、压缩图片容量大小
                imagejpeg($image_wp, $imgdst,self::$jpgQuality);
                imagedestroy($image_wp);
                break;
            case 3:
                $image = imagecreatefrompng($imgsrc);
                
                $exif = exif_read_data($imgsrc);
                if(!empty($exif['Orientation'])){
                    $angle = self::imageRotateAngle($exif['Orientation']);
                    if($angle != 0){
                        $image = imagerotate($image,$angle,0);
                    }
                }
                
                $image_wp=imagecreatetruecolor($new_width, $new_height);
                imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                //75代表的是质量、压缩图片容量大小
                imagejpeg($image_wp, $imgdst,self::$pngQuality);
                imagedestroy($image_wp);
                break;
            default:return false;
        }
        return true;
    }
    private static function check_gifcartoon($image_file){
        $fp = fopen($image_file,'rb');
        $image_head = fread($fp,1024);
        fclose($fp);
        return preg_match("/".chr(0x21).chr(0xff).chr(0x0b).'NETSCAPE2.0'."/",$image_head)?false:true;
    }
    private static function imageRotateAngle($exif){
        $angle = 0;
        switch($exif) {
            case 8:
                $angle = 90;
                break;
            case 3:
                $angle = 180;
                break;
            case 6:
                $angle = -90;
                break;
        }
        return $angle;
    }
}