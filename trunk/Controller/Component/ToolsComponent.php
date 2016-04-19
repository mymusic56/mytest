<?php
App::uses('Component', 'Controller');

/**
 * Created by PhpStorm.
 * User: k
 * Date: 2015/3/19
 * Time: 14:58
 * 常用工具
 * @property Message $Message
 */
class ToolsComponent extends Component{

    public function __construct(){

    }
    /**
     * @param $array
     * @param $keys
     * @param string $type
     * @return array
     * 按照数组键的值排序
     */
    public $uses = ['Message'];
    public function array_sort($array, $keys, $type = 'asc'){

        if(!isset($array) || !is_array($array) || empty($array)){
            return "";
        }
        if(!isset($keys) || trim($keys)==""){
            return "";
        }

        if(!isset($type) || $type=="" || !in_array(strtolower($type),array('asc','desc'))){
            return "";
        }
        $keysvalue = array();
        foreach($array as $key=>$val){
            $val[$keys] = str_replace('-',"",$val[$keys]);
            $val[$keys] = str_replace(' ',"",$val[$keys]);
            $keysvalue[] = $val[$keys];
        }
        asort($keysvalue); //key值排序
        reset($keysvalue); //指针重新指向数组第一个
        foreach($keysvalue as $key=>$vals) {
            $keysort[] = $key;
        }
        $keysvalue = array();
        $count = count($keysort);
        if(strtolower($type) != 'asc'){
            for($i = $count-1; $i >= 0; $i--) {
                $keysvalue[] = $array[$keysort[$i]];
            }
        }else{
            for($i=0; $i<$count; $i++){
                $keysvalue[] = $array[$keysort[$i]];
            }
        }

        return $keysvalue;

    }


    /**
     * @param $mobile
     * @return bool|string
     * 取手机号码运营商类型
     */
    public function getMobileType($mobile){
        $mobileType = [
            'move'=> [134, 135, 136, 137, 138, 139, 147, 150, 151, 152, 157, 158, 159, 178, 182, 183, 184, 187, 188],
            'unicom' => [130, 131, 132, 155, 156, 185, 186],
            'telecom' => [133, 153, 170, 177, 180, 181, 189]
        ];

        if(in_array(substr($mobile, 0, 3), $mobileType['move'])){
            return 'move';
        }elseif(in_array(substr($mobile, 0, 3), $mobileType['unicom'])){
            return 'unicom';
        }elseif(in_array(substr($mobile, 0, 3), $mobileType['telecom'])){
            return 'telecom';
        }
        return false;
    }
    /**
     * 安全过滤数据
     *
     * @param string	$str		需要处理的字符
     * @param string	$type		返回的字符类型，支持，string,int,float,html
     * @param maxid		$default	当出现错误或无数据时默认返回值
     * @return 		mixed		当出现错误或无数据时默认返回值
     */

    public function getStr($str, $type = 'string', $default = '') {
        if ($str === '')//如果为空则为默认值
            return $default;
        $str = trim($str);
        $str = str_replace(' ', '', $str);
        if (!get_magic_quotes_gpc()) //转义
            $str = addslashes($str);
        switch ($type) {
            case 'string': //字符处理
                $_str = strip_tags($str);
                $_str = str_replace("'", '&#39;', $_str);
                $_str = str_replace("\"", '&quot;', $_str);
                $_str = str_replace("\\", '', $_str);
                $_str = str_replace("\/", '', $_str);
                break;
            case 'int': //获取整形数据
                $_str = intval($str);
                break;
            case 'float': //获浮点形数据
                $_str = floatval($str);
                break;
            default: //默认当做字符处理
                $_str = strip_tags($str);
        }
        return $_str;
    }

    /**
     * @param int $type
     * @return bool|int|string
     * 取得今天星期几
     */
    public function getTodayWeek($type = 0){
       $week = date('w');
        switch($type){
            case 0:
                if($week == 0){
                    $week = 7;
                }
                break;
            case 1:
                $chineseWeek = ['七','一', '二', '三', '四', '五', '六'];
                $week = $chineseWeek[$week];
                break;
            default:
                return 'type error';
        }
        return $week;
    }


    /**
     * 发送HTTP请求
     * @param string $url 请求地址
     * @param string $method 请求方式 GET/POST
     * @param string $refererUrl 请求来源地址
     * @param array $data 发送数据
     * @param string $contentType
     * @param string $timeout
     * @param string $proxy
     * @return boolean
     */
    public function sendRequest($url, $data, $refererUrl = '', $method = 'GET', $contentType = 'application/json', $timeout = 30, $proxy = false) {
        $ch = null;
        if('POST' === strtoupper($method)) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HEADER,0 );
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            if ($refererUrl) {
                curl_setopt($ch, CURLOPT_REFERER, $refererUrl);
            }
            if($contentType) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:'.$contentType));
            }
            if(is_string($data)){
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            }
        } else if('GET' === strtoupper($method)) {
            if(is_string($data)) {
                $real_url = $url. (strpos($url, '?') === false ? '?' : ''). $data;
            } else {
                $real_url = $url. (strpos($url, '?') === false ? '?' : ''). http_build_query($data);
            }
            $ch = curl_init($real_url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:'.$contentType));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            if ($refererUrl) {
                curl_setopt($ch, CURLOPT_REFERER, $refererUrl);
            }
        } else {
            $args = func_get_args();
            return false;
        }
        if($proxy) {#设置代理
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
        }
        $ret = curl_exec($ch);
        $info = curl_getinfo($ch);
        $contents = array(
            'httpInfo' => array(
                'send' => $data,
                'url' => $url,
                'ret' => $ret,
                'http' => $info,
            )
        );
        curl_close($ch);
        return $ret;
    }


    /**
     * 静态方式发送HTTP请求，勉得生成对象
     * @param string $url 请求地址
     * @param string $method 请求方式 GET/POST
     * @param string $refererUrl 请求来源地址
     * @param array $data 发送数据
     * @param string $contentType
     * @param string $timeout
     * @param string $proxy
     * @return boolean
     */
    public static function sendHttpRequest($url, $data, $refererUrl = '', $method = 'GET', $contentType = 'application/json', $timeout = 30, $proxy = false,$header=[]) {
        $ch = null;
        if('POST' === strtoupper($method)) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HEADER,1 );
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            if ($refererUrl) {
                curl_setopt($ch, CURLOPT_REFERER, $refererUrl);
            }
            if($contentType) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:'.$contentType));
            }
            if(is_string($data)){
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            }
        } else if('GET' === strtoupper($method)) {
            if(is_string($data)) {
                $real_url = $url. (strpos($url, '?') === false ? '?' : ''). $data;
            } else {
                $real_url = $url. (strpos($url, '?') === false ? '?' : ''). http_build_query($data);
            }
            $ch = curl_init($real_url);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:'.$contentType));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            if ($refererUrl) {
                curl_setopt($ch, CURLOPT_REFERER, $refererUrl);
            }
        } else {
            $args = func_get_args();
            return false;
        }
        if($proxy) {#设置代理
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
        }
        if($header)
        {
            //var_dump($header);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
        }
        $info = curl_getinfo($ch);
        //var_dump($info);
        $ret = curl_exec($ch);
        $contents = array(
            'httpInfo' => array(
                'send' => $data,
                'url' => $url,
                'ret' => $ret,
                'http' => $info,
            )
        );
        $body = null;
        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == '200') {
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $header = substr($ret, 0, $headerSize);
            $body = substr($ret, $headerSize);
        }
        curl_close($ch);
        return $body;
    }

    /** 判断手机号码
     * @param $mobile
     * @return int
     */
    public function isMobile($mobile)
    {
        return preg_match('/^1[3-8][0-9]{9}$/', $mobile);
    }

    /** 订单表order_sn的算法
     * @param $goodsType
     * @return string
     */
    public function createOrderSn($goodsType)
    {
        return date('YmdHis') . intval($goodsType) . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    }

    /**
     * @return string
     */
    public function getClientIp() {

        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }

    /** 获取中文首字母
     * @param $str
     * @return null|string
     */
    public function getFirstLetter($str){

        if(empty($str)){return '';}

        $fchar=ord($str{0});

        if($fchar>=ord('A')&&$fchar<=ord('z')) return strtoupper($str{0});

        $s1=iconv('UTF-8','gb2312',$str);

        $s2=iconv('gb2312','UTF-8',$s1);

        $s=$s2==$str?$s1:$str;

        $asc=ord($s{0})*256+ord($s{1})-65536;

        if($asc>=-20319&&$asc<=-20284) return 'A';

        if($asc>=-20283&&$asc<=-19776) return 'B';

        if($asc>=-19775&&$asc<=-19219) return 'C';

        if($asc>=-19218&&$asc<=-18711) return 'D';

        if($asc>=-18710&&$asc<=-18527) return 'E';

        if($asc>=-18526&&$asc<=-18240) return 'F';

        if($asc>=-18239&&$asc<=-17923) return 'G';

        if($asc>=-17922&&$asc<=-17418) return 'H';

        if($asc>=-17417&&$asc<=-16475) return 'J';

        if($asc>=-16474&&$asc<=-16213) return 'K';

        if($asc>=-16212&&$asc<=-15641) return 'L';

        if($asc>=-15640&&$asc<=-15166) return 'M';

        if($asc>=-15165&&$asc<=-14923) return 'N';

        if($asc>=-14922&&$asc<=-14915) return 'O';

        if($asc>=-14914&&$asc<=-14631) return 'P';

        if($asc>=-14630&&$asc<=-14150) return 'Q';

        if($asc>=-14149&&$asc<=-14091) return 'R';

        if($asc>=-14090&&$asc<=-13319) return 'S';

        if($asc>=-13318&&$asc<=-12839) return 'T';

        if($asc>=-12838&&$asc<=-12557) return 'W';

        if($asc>=-12556&&$asc<=-11848) return 'X';

        if($asc>=-11847&&$asc<=-11056) return 'Y';

        if($asc>=-11055&&$asc<=-10247) return 'Z';

        return null;

    }
    
}