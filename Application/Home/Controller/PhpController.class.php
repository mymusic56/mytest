<?php
namespace Home\Controller;
use Think\Controller;
use Common\Lib\Tool\HttpRequest;
use Home\Service\ParseNameHtmlService;
use Common\Lib\Tool\DateTool2;
class PhpController extends Controller{
    private $index = 5;
    public function envParams(){
        putenv('MY_SET_ENV=EEEE');
        
        /**
		8
		eee
		
		
		
		ddddd
		
		
		*/
        /**
		
		eeeeeeeeeeeeeeeeeeee
		*/
        
        var_dump(PHP_SAPI, $_SERVER['MY_SET_ENV'], getenv('MY_SET_ENV'));
    }
    public function arrayTest1(){
        $a = array(
                'aa' => 22,
                'b' => [
                        'ee' => 'eee',
                        'eeee' => 'eeff'
                ]
        );
        $array = array("a", "b", "c", "d", "e");
//      array_slice ( array $array , int $offset [, int $length = NULL [, bool $preserve_keys = false ]] )
        $res1 = array_slice($array, 1);
        $res2 = array_slice($array, 1, 3);
        $res2_1 = array_slice($array, 1, -3);//查询
        $res3 = array_slice($array, -3);
        $res4 = array_slice($array, -3, 2);//查询
        var_dump($res1, $res2, $res2_1, $res3, $res4);
        var_dump(end($a));
    }
    public function testRandom(){
        $t1 = microtime(true);
        $pageLimit = 10;
        $config= array(
                '1' => array(0, 50),//第一页距离显示 0 - 50m
                '2' => array(50, 100),//第一页距离显示 50 - 100m
                '3' => array(100, 500),
                '4' => array(500, 1000),
                '5' => array(1000, 3000),
                '6' => array(3000, 5000),
                '7' => array('5km'),//大于5km
                '8' => array('10km'),//大于10km
        );
        $strategyList = [];
        for($i = 1; $i <= 10; $i++)
        {
            $temp = [];
            foreach ($config as $key => $item)
            {
                $pageDistanceList = [];
                if(isset($item[1]))
                {
                    $randStart = $item[0]*100;
                    $randEnd = $item[1]*100;
                    for($j = 1 ; $j <= $pageLimit; $j ++){
                        $pageDistanceList[] = round(mt_rand($randStart, $randEnd)/100, 2);
                    }
                    sort($pageDistanceList);
                    $temp[$key] = implode(',', $pageDistanceList);
                }else{
                    $temp[$key] = ">$item[0]";
                }
            }
            $strategyList[$i] = $temp;
        }
        $t2 = microtime(true);
        var_dump($t2- $t1, $strategyList);die;
        $pages  =2;
        var_dump(mt_rand(1, $pages-1));
    }
    public function test(){
        $kp['goodstitle'] = '张三风3';
        $offset = mb_strripos($kp['goodstitle'], 'x');
        $goodsTitle = mb_substr($kp['goodstitle'],0, $offset, 'utf-8');
        $goodsTitleTimes = mb_substr($kp['goodstitle'],$offset, 2, 'utf-8');
        var_dump($offset, $goodsTitle.'<span style="color:red;">'.$goodsTitleTimes.'</span>');
        $a = -1;
        $c = 9;
        $b = $a > 1 ? $this->index : $c;
        var_dump($b);
    }
    public function strTest(){
        $text = "你好";
        echo 'utf8:'.mb_strlen($text,'utf8')."<br/>";
        echo 'gbk:'.mb_strlen($text,'gbk')."<br/>";
        echo 'gb2312:'.mb_strlen($text,'gb2312')."<br/>";
        echo 'strlen:'.strlen($text);
        var_dump(mb_internal_encoding());
    }
    public function arrayTest(){
    	$a = array('a' => 123, 'b'=>'4444');
    	$a = $a + array('a' => 'aaa', 'c' => 'eeeeee');
    	var_dump($a);
    	$b = array();
    	$b = $b + array('b' => 'eee');
    	var_dump($b);
    }
    public function arrayDiff(){
    	$array = ['a', 'b', 'name'];
    	$value1= ['name', 'what'];
    	//返回在$array中，not in $value1中值,因此，$array是需要被整合的数组
    	$diff = array_diff($array, $value1);
    	$merge = array_merge($value1, $diff);
    	var_dump($diff, $merge);
    }
    /**
     * Uppercase the first character of each word in the string.
     */
    public function stringTest(){
    	$a = 'this is my first computer!';
    	var_dump(ucwords($a));
    }
    public function jsonpTest(){
        $res = array_slice(explode('.', $_SERVER['HTTP_HOST']), 0, -2);
        var_dump($res);
        $this->dataList = array(
                array('name' => 'zhangsan', 'age' => 10),
                array('name' => 'lisi', 'age' => 50)
        );
        $this->display();
    }
    public function str(){
        preg_replace('/[a-z]/', '', hash('md5', 'EEF2609F-2A31-4AFF-95D9-6D234DF8B15C'));
        var_dump(hash('md5', '123456'), preg_replace('/[a-z]/', '', hash('md5', '123456')), preg_replace('/[a-z|A-Z|-]/', '', 'EEF260dddd9ddF-2A3aew1-eee4AFF-95D9-6D234DF8B15C'));
        $ft_str = '這是繁體中文';
        $jt_str = '这是简体中文';
        var_dump(@iconv('utf-8', 'gb2312', $ft_str));
        var_dump(@iconv('utf-8', 'gb2312', $jt_str));
    }
    /**
     *   'scheme' => string 'https' (length=5)
         'host' => string 'book.douban.com' (length=15)
         'path' => string '/tag/%E5%B0%8F%E8%AF%B4' (length=23)
     */
    public function testParseUrl(){
        $url = 'https://book.douban.com/tag/小说';
        $res = parse_url($url);
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        var_dump($res);
    }
    public function testReg(){
        
        $useMoney = 0.12;
        $userId= 1;
        try {
            
        }catch (\Exception $e){
            echo $e->getMessage();
        }
        
        $str = 'aAbcdefGHefwfewgh';
        preg_match_all('#GH#i', $str, $match,PREG_OFFSET_CAPTURE, 15);//加上字符串的偏移量后就会职匹配最后一个gh
        var_dump($match);
    }
    
    public function insertInto(){
        set_time_limit(0);
        $pages = 30000000 / 200;
        $n = 1;
        $a = ['A','B','C','D','E','F','G','H'];
        $partion = ['P0','P1','P2','P3','P4','P5'];
        for ($i =0; $i < $pages; $i++){
            $data = [];
            for ($j = 0; $j < 200; $j++){
//                 (PARTITION p0 VALUES LESS THAN (5000000) ENGINE = InnoDB,
//                 PARTITION p1 VALUES LESS THAN (10000000) ENGINE = InnoDB,
//                 PARTITION p2 VALUES LESS THAN (15000000) ENGINE = InnoDB,
//                 PARTITION p3 VALUES LESS THAN (20000000) ENGINE = InnoDB,
//                 PARTITION p4 VALUES LESS THAN (25000000) ENGINE = InnoDB,
//                 PARTITION p5 VALUES LESS THAN (30000000) ENGINE = InnoDB)
                $p = '';
                if($n <= 5000000){
                    $p = $partion[0];
                }elseif ($n > 5000000 && $n <= 10000000){
                    $p = $partion[1];
                }elseif ($n > 10000000 && $n <= 15000000){
                    $p = $partion[2];
                }elseif ($n > 15000000 && $n <= 20000000){
                    $p = $partion[3];
                }elseif ($n > 20000000 && $n <= 25000000){
                    $p = $partion[4];
                }elseif ($n > 25000000 && $n <= 30000000){
                    $p = $partion[5];
                }
                
                $tmp = array(
                        'id' => $n,
                        'order_no' => $p.$a[rand(0,8)].date('His').uniqid().mt_rand(100000, 999999),
                        'trade_no' => $p.$a[rand(0,8)].date('His').uniqid().mt_rand(100000, 999999),
                        'mobile' => $this->randomPhone(),
                        'total_price' => rand(10,30),
                        'pay_status' => rand(1,2),
                        'distributor_id' => rand(1,10),
                        'goods_id' => rand(1,10),
                        'source_goods_id' => 'A'.floor(rand(1,10)),
                        'source_id' => rand(1,10)
                );
                $data[]=$tmp;
                $n++;
            }
            //var_dump(count($data),$data);die;
            $res = M('flow_orders')->addAll($data);
            // var_dump($res);die;
            usleep(500);
        }
    }
    
    private function randomPhone(){
        $want = 'unicon';
        $prefix = array(
                'mobile' => array(134,135,136,137,138,139,147,150,151,152,157,158,159,178,182,183,184,187,188),
                'telecon' => array(133,153,177,180,181,189),
                'unicon' => array(130,131,132,145,155,156,176,185,186),
        );
        $number = mt_rand(10000000, 99999999);
        $m = strval($prefix[$want][rand(0, count($prefix[$want])-1)]).$number;
        return $m;
    }
 
    public function getFileTree(){
        $path = 'D:\wamp\dsp_all';
        var_dump(glob($path.'/*'));
    }
}