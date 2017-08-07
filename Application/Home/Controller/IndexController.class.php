<?php
namespace Home\Controller;
use Think\Controller;
use Common\Lib\Tool\HttpRequest;
use Think\Log;
use Home\Service\UsersService;
class IndexController extends Controller {
    public function _before_testFunctionBefore(){
        var_dump('this is before filter');
    }
    public function index(){
    	Log::write(C('LOG_RECORD').'--'.C('LOG_LEVEL').'--'.C('SHOW_ERROR_MSG'));
    	D::aaa();
//         $a/0;
        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>Home Module, <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }
    /**
     * 模型实例化
     * 		D: D方法实例化模型类的时候通常是实例化某个具体的模型类，如果你仅仅是对数据表进行基本的CURD操作的话，
     * 		M: 使用M方法实例化的话，由于不需要加载具体的模型类，所以性能会更高。
     * 		空模型：如果你仅仅是使用原生SQL查询的话，不需要使用额外的模型类，实例化一个空模型类即可进行操作了
     * 
     * 字段定义
     * 	1）
     * 		字段缓存保存在Runtime/Data/_fields/ 目录下面，
     * 		缓存机制是每个模型对应一个字段缓存文件（注意：并非每个数据表对应一个字段缓存文件），
     * 		命名格式是：数据库名.数据表前缀+模型名（小写）.php
     *     // 关闭字段缓存 'DB_FIELDS_CACHE'=>false
     *  2）如果不希望依赖字段缓存或者想提高性能，也可以在模型类里面手动定义数据表字段的名称，    
     * //  	问题：
     *     		没找到， 开启缓存没有起作用
     *  数据库连接
     *  	//在模型里单独设置数据库连接信息
     *     
     */
    public function test(){
        $a = ceil(32/30);
        var_dump($a);
        
        $str = '\"str"';
        var_dump(ini_get('magic_quotes_gpc'), addslashes($str), stripslashes(addslashes($str)));
        $a = 1;
        $a > 2? $b = 1: '';
    	$arr = [1,2,4,6,9];
    	
//     	var_dump($_SERVER,in_array(6, $arr));die;
//     	$obj = new stdClass();
//     	$obj->name = 'ThinkPHP';

    	
    	
    	
//     	$obj->email = 'ThinkPHP@gmail.com';
    	$data['name'] = 'ThinkPHP';
    	$data['email'] = 'ThinkPHP@gmail.com';
    	$data['xxxxxx'] = 'ThinkPHP@gmail.com';
    	$User= M("users");
    	$sql = $User->fetchSql(true)->data($data)->add();
    	var_dump($sql);die;
    	
    	$res = $User->cache('user',60)->find();
    	var_dump($res);
    	
    	$fields = $User->getDbFields();
    	var_dump($fields);
    	//不插入只查看SQL语句
    	$sql = $User->fetchSql(true)->data($data)->add();
    	var_dump($sql);die;
    	
    	//Create方法创建的数据对象是保存在内存中，并没有实际写入到数据库中，直到使用add或者save方法才会真正写入数据库。
//     	$data = $User->create($data);
    	$data = $User->data($data)->add();
    	
    	$User->create();
    	$User->name = 'zhangsan';
    	$User->email = '333@qq.com';
    	$User->gender = '1';
    	$res = $User->add();
    	var_dump($data, $res);die;
    	
    	
    	// 指定更新数据操作状态
    	$res = $User->create($data);
    	var_dump($res);
    	die;
    }
    public function testQuery(){
    	$User = M('users');
    	$where['name'] = 'ThinkPHP2';
    	$where['email'] = 'ThinkPHP1@gmail.com';
    	$where['_logic'] = 'OR';
    	$map['_complex'] = $where;
    	$map['gender'] = '1';
    	$res = $User->where($map) -> select();
    	//SELECT * FROM `users` WHERE ( `name` = 'ThinkPHP2' OR `email` = 'ThinkPHP1@gmail.com' ) AND `gender` = 1
    	var_dump($res);die;
    }
    public function testC(){
    	//http://home.mytest.cn/index.php/Index/testC/name/zhang
    	echo '111';
    	$tmp = C('DB_TYPE');
    	$param[] = I('get.name');
    	$param[] = I('get.gender', '未知', 'trim');
    	$paramArr = I();
    	$paramArr = json_decode($paramArr);
    	var_dump($tmp, $param, $this->getPlatform(), $paramArr);die;
    }
    public function testCurl(){
    	$data = array(
    			'a' => "45 ",
    			'b' => 2
    	);
    	$data = json_encode($data);
    	$url = 'http://home.mytest.cn/index.php/Index/testCurlReceive';
    	$res = HttpRequest::sendCurl($url, $data);
    	var_dump($res);die;
    }
    public function testCurlReceive(){
    	$paramArr = I();
    	exit(json_encode($paramArr));
    }
    public function testDate(){
    	$BeginDate= '2017-02-01';
    	echo date('Y-m-d', strtotime("$BeginDate +1 month -1 day"));
    }
    public function testEncode(){
    	var_dump(base64_encode('签名样式介绍'));
    	var_dump(urlencode('签名样式介绍'));
    	die;
    }
    public function testOtherDB(){
    	$Group = D('Group');
    	//当 \Home\Model\GroupModel 类不存在的时候，D函数会尝试实例化公共模块下面的 \Common\Model\GroupModel 类。
    	$res = $Group -> select();
    	var_dump($res);die;
    }
    public function testModel(){
    	new A();
    	#test model attribute
    	$Groups = D('Groups');
    	$res = $Groups->select();
    	
    	#test D function when class not found in current module's Model floder.
    	$defaultModel = D('Defaultmodel');//found the class in Common/Model
    	$res2 = $defaultModel -> test();
    	# test multi model, 
    	# test failed;
    	$User = D('Users');
    	$User = new \Home\Model\UsersModel();
//     	$UserLogic = D('Users', 'Logic');
//     	$UserService = D('Users', 'Service');
    	$model = $User->test();
//     	$logic = $UserLogic->test();
//     	$service = $UserService->test();
    	var_dump($res, $res2, $model, $logic, $service);
    }
    public function testConstant() {
    	$array = array(
    			'MODULE_NAME' 			=> MODULE_NAME,
    			'CONTROLLER_NAME' 		=> CONTROLLER_NAME,
    	        'ACTION'                => ACTION_NAME
    	);
    	var_dump($array);
    }
    
    public function testCrud(){
    	$phone = '18502355693';
    	$res = $this->hidtel($phone);
//     	$res = M('users') -> where('id=1') -> setField('gender', 3);
    	var_dump($res);
    }
    public function getClientIP(){
        var_dump(get_client_ip());
    }
    public function testLog(){
    	var_dump(C('LOG_PATH'));
    	Log::write('dddswfrawrfewatf', 'NOTICE', '', C('LOG_PATH') . date('y-m-d') . 'test.log');
    }
    public function testFunctionBefore(){
        var_dump('Function testFunctionBefore');
    }
    public function testCache(){
//         S('asece', '1ldp');
        
        $User= M("users");
        $res = $User->cache('user',60)->find();
        var_dump($res);
    }
    public function testSwitchDB(){
        Log::write(json_encode(I()), 'NOTICE', '', C('LOG_PATH') . date('y-m-d') . 'test.log');
        $res = M('ac_signclass', '', 'DB_CONFIG3')->where("signclass=108")->setInc('buycounts');
    }
    public function testException(){
        try {
            var_dump(UsersService::error(), 'eeeeeeeeeeeee');
        }catch (Exception $e){
            var_dump($e->getMessage(), 'ddddddddd');
        }
    }
    public function testCacheEngine(){
        S('ssssss', array('a' => 11, 'b' => '333'), array('type' => 'file', 'expire' => 60));
        var_dump(S('ssssss'));
    }
    private function hidtel($phone)
    {
    	$IsWhat = preg_match('/(0[0-9]{2,3}[-]?[2-9][0-9]{6,7}[-]?[0-9]?)/i',$phone); //固定电话
    	if($IsWhat == 1){
    		return preg_replace('/(0[0-9]{2,3}[-]?[2-9])[0-9]{3,4}([0-9]{3}[-]?[0-9]?)/i','$1****$2',$phone);
    	}else{
    		return  preg_replace('/(1[3578]{1}[0-9])[0-9]{4}([0-9]{4})/i','$1****$2',$phone);
    	}
    }
    private function getPlatform(){
    	$platform = '';
    	if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
    		$platform = 'ios';
    	}else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
    		$platform = 'android';
    	}
    	return $platform;
    }
}