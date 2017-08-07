<?php
namespace Home\Controller;
use Think\Controller;
use Common\Lib\Tool\HttpRequest;
use Think\Log;
use Common\Lib\File\ImageProcess;
use Home\Service\NameCrawler;
class TestController extends Controller {
    public function index(){
		
        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>Home Module, <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }
	
	
	
	
	
	public function testArray() {
		# array_push()
		$array= [];
		$a = array('a1' => 1, 'a2' => 2);
		$b = array('b1' => 1, 'b2' => 2);
		$b += $a;
		$b = array_change_key_case($b,CASE_UPPER);
		var_dump($b);die;
		array_push($array, $a);
		array_push($array, $b);
		
		var_dump($array);
		# end()
		$toStr = implode(array(1,2,5,6), '.');
		$toArr = explode('.', $toStr);
		$end = end($toArr);
		var_dump($end, $toStr, $toArr);
	}
	public function designShowAdd(){
		var_dump(json_decode('{"idfa":"1234","imei":"3333", "designId": 29}'));die;
		$key = md5($number.'1234LPMDEM');
		var_dump($key);die;
		$data = array(
				'number' => 'design_show_add',
				'key' => $key,
				'data' => array(
						'designId' => 29
				)
		);
		$data = json_encode($data);
		$url = 'http://www.qm.com/Api/apiaccess';
		$res = HttpRequest::sendCurl($url, $data);
		var_dump($res);die;
	}
	public function test(){
	    var_dump('服务端应用程序编程接口：',PHP_SAPI,php_sapi_name());die;
	    $this->randomPhone();
	    echo sha1('agcedfawgcxddra');die;
		$page = 1;
		$limit = 3;
		$sort = 'id';
		$DesignShow = M('ac_design_show', '', 'DB_CONFIG3');
		$filed = 'ac_design_show.id show_id, ac_design_show.msg msg, ac_design_show.gives gives, ac_pay_order.goodstitle name, ac_design_list.uri uri';
		$dataList = $DesignShow
// 		->fetchSql()
		->join('ac_pay_order on ac_pay_order.ordercode = ac_design_show.ordercode')
		->join('ac_design_list on ac_design_list.id = ac_design_show.design_id')
// 		->cache('design_show_list', 300)
		->field($filed)
		->page("$page, $limit")->order("ac_design_show.$sort desc")->select();
		var_dump($dataList);
	}
	public function imageTest(){
// 	    $file_url = 'http://nineton.oss-cn-hangzhou.aliyuncs.com/signature/img/homepage3/videoimg2x.png';
// 	    $content = file_get_contents($file_url);
// 	    file_put_contents('D:\work\a.png', $content);
	    
	    $t1 = microtime(true);
	    $a = [];
	    for ($i=1; $i < 2; $i++){
    	    $a[] = getimagesize('C:\Users\Administrator\Desktop\videoimg2x.png');
	    }
	    $t2 = microtime(true);
// 	    var_dump($a, $t2 - $t1);
	    $this->url = 'http://nineton.oss-cn-hangzhou.aliyuncs.com/signature/img/homepage3/videoimg2x.png';
	    $this->display();
	}
	public function directoryTest(){
// 	    var_dump(urldecode('%E9%BB%84%E6%98%BE%E6%98%8E'));
// 	    $res = urldecode('%E9%BB%84%E6%98%BE%E6%98%8E');
// 	    var_dump($res);
// 	    $res2 = urlencode($res);
// 	    var_dump($res);
	    
// 	    die;
	    $dir = 'D:\work\sign';
	    $filename = 'D:\work\sign\name.csv';
	    $url= 'http://nineton.oss-cn-hangzhou.aliyuncs.com/signature/img/designshow/';
	    var_dump(is_dir($dir));
	    if(is_dir($dir)){
	        if($ds = opendir($dir)){
	            while(($file = readdir($ds)) !== false){
	                $file= iconv('gbk', 'utf-8', $file);
	                $nameArr = explode('.', $file);
	                $name = urlencode($file);
	                $nameArr[0] = iconv('utf-8', 'gbk', $nameArr[0]);
	                $data = "$nameArr[0], $url".$name.PHP_EOL;
	                file_put_contents($filename, $data, FILE_APPEND);
	                var_dump($nameArr[0]);
	            }
	        }
	        closedir($dir);
	    }
	    die;
	}
	/**
	 * 处理没有压缩的签名秀图片
	 */
	public function designShow(){
	    set_time_limit(1000);
	    var_dump(designShow);die;
	    $contents = file_get_contents('D:\work\sign\design-show-list-2.csv');
	    $file = 'D:\work\sign\design-show-list-2.sql';
	    $destDir = 'D:\work\sign\download';
	    $show = explode(PHP_EOL, $contents);
	    foreach ($show as $item){
	        $data = explode(',', $item);
	        $fileInfo = ImageProcess::downloadImage($data[1], $destDir);
	        $urlA = explode('/', $data[1]);
	        $name = array_pop($urlA);
	        $name = '170605123659-'.$name;
	        $imgdst = 'D:\\work\\sign\\compress\\'.$name;
	        $flag = ImageProcess::imageCompress($fileInfo['path'], $imgdst);
	        $url = '__URL__'.$name;
	        $sql = "UPDATE ac_design_show SET url='$url' WHERE id={$data[0]};".PHP_EOL;
	        var_dump($data[0].'--'.$data[2].'--'.$url);
	        file_put_contents($file, $sql, FILE_APPEND);
// 	        die;
	    }
	}
	public function randomPhone(){
	    $filename = 'D:\work\sign\mobile.csv';
	    $want = 'unicon';
	    $num = 5;
	    $prefix = array(
	            'mobile' => array(134,135,136,137,138,139,147,150,151,152,157,158,159,178,182,183,184,187,188),
	            'telecon' => array(133,153,177,180,181,189),
	            'unicon' => array(130,131,132,145,155,156,176,185,186),
	    );
	    $mobiles= array();
	    for($i = 0; $i < $num; $i ++){
    	    $number = mt_rand(10000000, 99999999);
    	    $m = strval($prefix[$want][rand(0, count($prefix[$want])-1)]).$number;
    	    $mobiles[] = $m;
    	    file_put_contents($filename, $m.PHP_EOL, FILE_APPEND);
	    }
	    var_dump($mobiles);
	}
	public function testImageCompress(){
	    $imgdst = 'D:\work\sign\compress';
	    $destDir = 'D:\work\sign\download';
	    set_time_limit(600);
	    $content = file_get_contents('D:\work\sign\name.csv');
	    $content = explode(PHP_EOL, $content);
        $res = [];
	    foreach ($content as $key => $string){
	        $p = explode(',', $string);
	        $name = iconv('gbk', 'utf-8', $p[0]);
	        $srcUrl = trim($p[1]);
	        $imgInfo = ImageProcess::downloadImage($srcUrl, $destDir);
	        //保存到本地还是使用gbk
	        $res[] = ImageProcess::imageCompress($srcUrl, $imgdst.DIRECTORY_SEPARATOR.$p[0].'.JPG');
// 	        var_dump($res, $imgdst.DIRECTORY_SEPARATOR.$name.'.JPG');die;
            
	    }
	    var_dump($content, $res);
	}
	public function imageDownloadAndCompress(){
	    $t1 = microtime(true);
	    $destDir = 'D:\work\sign\download';
	    $srcUrl = 'http://nineton.oss-cn-hangzhou.aliyuncs.com/signature/ds/1706/12/IMG_6993.JPG';
	    
	    $srcA = explode('/', $srcUrl);
	    $name = array_pop($srcA);
	    $imgInfo = ImageProcess::downloadImage($srcUrl, $destDir);
	    $image = new \Think\Image();
	    $image->open($imgInfo['path']);
	    $destUrl = $destDir.'/'.$name;
	    $res = $image->thumb(500, 500,\Think\Image::IMAGE_THUMB_FILLED)->save($destUrl);
	    $t2 = microtime(true);
	    $exif = exif_read_data($imgInfo['path']);//获取exif信息
	    if (isset($exif['Orientation']) && $exif['Orientation'] == 6) {
	        $source = imagecreatefromjpeg($destUrl);
	        //旋转
	        imagealphablending($image, true);
	        $rotateSource = imagerotate($source,-90, 255);
	        imagejpeg($rotateSource, $destUrl);
	        imagedestroy($source);
	        imagedestroy($rotateSource);
	        var_dump('ee');
	    }
	    $t3 = microtime(true);
	    var_dump($t2-$t1, $t3-$t2, $res);die;
	    
	    return $destUrl;
	    
	    
// 	    $size = getimagesize($imgsrc);
// 	    var_dump($size);
	    $imgdst = 'D:\\work\\sign\\compress\\com-IMG_9873.jpg';
	    ImageProcess::imageCompress($imgsrc, $imgdst);
	}
	
	public function imageProcess(){
// 		$path = 'd:\work\301.jpg';
		$path = 'D:\work\named\pic_master@2x.jpg';
		
		$imgdst = 'D:\work\named\pic_master@2x-1.jpg';
		$this->imageCompress($path, $imgdst);die;
		$image = new \Think\Image();
		$image->open($path);
		$width = $image->width(); // 返回图片的宽度
		$height = $image->height(); // 返回图片的高度
		$type = $image->type(); // 返回图片的类型
		$mime = $image->mime(); // 返回图片的mime类型
		$size = $image->size(); // 返回图片的尺寸数组 0 图片宽度 1 图片高度
		var_dump(array($width,$height,$type,$mime,$size));
// 		$image->crop(400, 400)->save('d:\work\301-crop.jpg');
		//等比缩放
// 		$image->thumb(150, 150,\Think\Image::IMAGE_THUMB_SCALE)->save('d:\work\301-thumb.jpg');
		//固定大小
		$image->thumb($size[0], $size[1],\Think\Image::IMAGE_THUMB_FIXED)->save('D:\work\named\pic_master@3x-2.png');
	}
	private function imageCompress($imgsrc,$imgdst){
	    list($width,$height,$type)=getimagesize($imgsrc);
	    $new_width = $width;
	    $new_height = $height;
// 	    var_dump($width,$height,$type);die;
	    switch($type){
	        case 1:
	            $giftype=check_gifcartoon($imgsrc);
	            if($giftype){
	                header('Content-Type:image/gif');
	                $image_wp=imagecreatetruecolor($new_width, $new_height);
	                $image = imagecreatefromgif($imgsrc);
	                imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	                //75代表的是质量、压缩图片容量大小
	                imagejpeg($image_wp, $imgdst,75);
	                imagedestroy($image_wp);
	            }
	            break;
	        case 2:
	            header('Content-Type:image/jpeg');
	            $image_wp=imagecreatetruecolor($new_width, $new_height);
	            $image = imagecreatefromjpeg($imgsrc);
	            imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	            //75代表的是质量、压缩图片容量大小
	            imagejpeg($image_wp, $imgdst,50);
	            imagedestroy($image_wp);
	            break;
	        case 3:
	            header('Content-Type:image/png');
	            $image_wp=imagecreatetruecolor($new_width, $new_height);
	            $image = imagecreatefrompng($imgsrc);
	            imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	            //75代表的是质量、压缩图片容量大小
	            imagejpeg($image_wp, $imgdst,60);
	            imagedestroy($image_wp);
	            break;
	    }
	}
	public function rotateImage(){
	    $str = 'http://oss-cn-hangzhou.aliyuncs.com/nineton/signature/img/designshow/compress/com-201706021146185930df8abc91c.jpg';
	    $targetName= 'D:\work\aa-com.JPG';
	    $image = imagecreatefromstring(file_get_contents($str));
	    $exif = exif_read_data($str);
// 	    imagealphablending($image, true);
// 	    $transparent = imagecolortransparent($image, 255);
	    if(!empty($exif['Orientation'])) {
	        switch($exif['Orientation']) {
	            case 8:
	                $image = imagerotate($image,90, 255);
	                break;
	            case 3:
	                $image = imagerotate($image,180, 255);
	                break;
	            case 6:
	                $image = imagerotate($image,-90, 255);
	                break;
	        }
	    }
	    
	    imagejpeg($image,$targetName);
	}
	public function createImage(){
	    // 创键空白图像并添加一些文本
	    $im = imagecreatetruecolor(500, 500);
	    //为图片指定背景色
	    $text_color = imagecolorallocate($im, 255, 255, 255);
	    
	    //写入文字
	    imagestring($im, 1, 5, 5,  'A Simple Text String', $text_color);
	    
	    // 设置内容类型标头 —— 这个例子里是 image/jpeg
	    header('Content-Type: image/jpeg');
	    
	    // 输出图像
	    imagejpeg($im, 'd:\a.jpg');
	    
	    // 释放内存
	    imagedestroy($im);
	}
	public function testCurl(){
	    $url = 'http://xmcs.buyiju.com/dafen.php';
	    $data= array('xs' => '邓', 'mz' => '辉');
	    $header = array("Connection: Keep-Alive", "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8", "Pragma: no-cache", "Accept-Language: zh-Hans-CN,zh-Hans;q=0.8,en-US;q=0.5,en;q=0.3", "User-Agent: Mozilla/5.0 (Windows NT 5.1; rv:29.0) Gecko/20100101 Firefox/29.0");
	    $res = \Common\Lib\Tool\HttpRequest::sendHttpRequest($url, $data, '', 'POST', '', 30, false, $header);
	    var_dump($res);die;
	}
	public function testA(){
	    
	    $money = 0.3*0.12;
	    var_dump(floatval($money));
	    $str = '中午吃饭';
	    var_dump( preg_match('/中午/', $str),'3333');
	    $srcUrl = 'http://nineton.oss-cn-hangzhou.aliyuncs.com/signature/ds/1706/12/IMG_6993.JPG';
// 	    $info = getimagesize($srcUrl);
	    $scale = min(500/3024, 500/3024);
	    var_dump($info, $scale);
	}
	public function testCrawlerName(){
	    set_time_limit(0);
// 	    NameCrawler::getFirtName4();die;
//         NameCrawler::getFirstName1();die;
//         NameCrawler::crawlerName3();die;
//         NameCrawler::getFirstNameOut();die;
	    NameCrawler::crawlerName4();
	    die;
	    
	    die;
	    
	    set_time_limit(0);
//         NameCrawler::getFirstName();
        NameCrawler::crawlerName();
        
	}
	public function testCrawlerName2(){
	    $url = 'http://xmcs.buyiju.com/dafen.php';
	    $data= array('xs' => '邓', 'mz' => '辉');
	    $header = array("Connection: Keep-Alive", "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8", "Pragma: no-cache", "Accept-Language: zh-Hans-CN,zh-Hans;q=0.8,en-US;q=0.5,en;q=0.3", "User-Agent: Mozilla/5.0 (Windows NT 5.1; rv:29.0) Gecko/20100101 Firefox/29.0");
	    $data= \Common\Lib\Tool\HttpRequest::sendHttpRequest($url, $data, '', 'POST', '', 30, false, $header);
	    $filename = 'D:/work/named/'.date('Y-m-d').mt_rand(10000, 99999);
	    file_put_contents($filename.'.html', $data);
	    $string = NameCrawler::compressHtml($data);
	    file_put_contents($filename.'.txt', $string);
	}
	
	public function checkFirstName(){
	    set_time_limit(0);
	    $firstNames = M('my_firstname')->select();
	    $errorName = [];
	    foreach ($firstNames as $firstname){
	        \Think\Log::write($firstname['firstname'], 'Notice', '', C('LOG_PATH').date('Y-m-d').'name.list.log');
	        $where['firstname'] = $firstname['firstname'];
	        $res = M('my_name_list')->where($where)->find();
	        if($res['firstname'] != mb_substr($res['name'], 0, 1)){
	            $errorName[] = array(
	                    'firstname' => $res['firstname'],
	                    'name' => $res['name'],
	                    'gender' => $res['sex'],
	            );
	        }
	    }
	    \Think\Log::write(json_encode($errorName, JSON_UNESCAPED_UNICODE), 'Notice', '', C('LOG_PATH').date('Y-m-d').'name.test.log');
	    var_dump(count($errorName), $errorName);
	}
	
	public function checkNameCount(){
	    set_time_limit(0);
	    $firstNames = M('my_firstname')->select();
	    $errorName = [];
	    foreach ($firstNames as $firstname){
	        $where['firstname'] = $firstname['firstname'];
	        $res = M('my_name_list')->where($where)->count();
	        if($res == 0){
	            $errorName[] = $firstname['firstname'];
	        }
	    }
	    \Think\Log::write(json_encode($errorName, JSON_UNESCAPED_UNICODE), 'Notice', '', C('LOG_PATH').date('Y-m-d').'name.test.log');
	    
	    var_dump($errorName);
	}
	public function checkOutName(){
	    $res = M('')->query("SELECT * FROM
            aaa_copy_out WHERE firstname 
            NOT IN(SELECT firstname c FROM my_name_list_out GROUP BY firstname ORDER BY c ASC)");
	    $nameList = "";
	    foreach ($res as $item){
	        $nameList .= "'{$item['firstname']}',";
	    }
	    var_dump($res, $nameList);die;
	}
	
	public function addNameList(){
	    if(PHP_SAPI != 'cli'){
	        die('非法请求');
	    }
	    $t1 = microtime(true);
	    set_time_limit(0);
	    #找出待插入的的记录
	    $sql = "SELECT * FROM (SELECT firstname, COUNT(*) cc, sex FROM aaa_name_list GROUP BY firstname,sex) tmp WHERE tmp.cc < 1000";
	    $needAdd = M('') -> query($sql);
	    if($needAdd)
	    {
	        \Think\Log::write(json_encode($needAdd, JSON_UNESCAPED_UNICODE), 'Notice', '', C('LOG_PATH').date('Y-m-d').'name.insert.list.log');
	        foreach ($needAdd as $key => $item) {
	            $createCount = 1200 - $item['cc'];//避免有重复的， 多插入几条
	            if($createCount)
	            {
	                $sql = "SELECT * FROM aaa_name_list 
                            WHERE sex='{$item['sex']}' 
                            AND firstname <> '{$item['firstname']}' 
                            ORDER BY RAND() LIMIT $createCount";
	                
	                $randRes = M('')->query($sql);
	                $dataList = [];
	                foreach ($randRes as $k => $v){
	                    $offset = mb_strlen($v['firstname'], 'utf-8');
	                    $temp = array(
	                            'firstname' => $item['firstname'],
	                            'sex' => $item['sex'],
	                            'name' => $item['firstname'].mb_substr($v['name'], $offset, mb_strlen($v['name'], 'utf-8'), 'utf-8'),
	                    );
	                    $dataList[] = $temp;
	                    unset($randRes[$k]);
	                }
	                $resFlag = M('tmp_name_list')->addAll($dataList);
	                if($resFlag){
	                    $info = array('firstname'=>$item['firstname'], 'insert_count:'=> $createCount);
	                    \Think\Log::write(json_encode($info, JSON_UNESCAPED_UNICODE), 'Notice', '', C('LOG_PATH').date('Y-m-d').'name.insert.list.log');
	                    unset($needAdd[$key]);
	                }
	            }
	            sleep(1);
	        }
	    }
	    $t2 = microtime(true);
	    var_dump($t2 - $t1, $needAdd);
	}
}