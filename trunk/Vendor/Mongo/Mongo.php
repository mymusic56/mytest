<?php
/**
 * Description of MongoUtil
 * MongoDB 封装类
 * 参考 PHP Manual<br/>
 * use like this:<br/>
 * $mongodb = MongoUtil::init();<br/>
 * $mongodb->find('collection_name');<br/>
 * @link http://www.php.net/manual/zh/book.mongo.php<br/>
 * @link http://docs.mongodb.org/manual/<br/>
 * @author Nomandia
 */
//App::import('Config', 'database');
class MongoDataBase {

    private static $instance;
    public $mongo;
    public $db_name;
    public $coll_name;
    public $cursor;
    public $auto_connect = true;
    public $errors;

    function __construct() {
    	require_once ROOT.'/trunk/Config/database.php';
    	$mongoConfig = new DATABASE_CONFIG();
        try {
	    	$mongoDbConfig = $mongoConfig->mongo;
	    	// 		var_dump($mongoDbConfig->mongo);die;
	    	 $this->mongo = new MongoClient("mongodb://".$mongoDbConfig['login'].":".$mongoDbConfig['password']."@".$mongoDbConfig['host'].":".$mongoDbConfig['port']."/".$mongoDbConfig['database']);
            $this->db_name = $mongoDbConfig['database'];
        } catch (Exception $ex){
            $this->errors= $ex->getMessage();
        }
        $this->connect();
    }

    private function getHost($host)
    {
        foreach ($host as $key => $value) {
            if ($value['is_master']) {
                return $host[$key];
            }
        }
    }

    public static function init() {
        if (!self::$instance) {
            self::$instance = new MongoDataBase();
        }
        return self::$instance;
    }

    public function __destruct() {
        $this->mongo->close(true);
    }

    public function connect() {
        return $this->mongo->connect(true);  //
    }

    public function listDb(){
        try{
            return $this->mongo->listDBs();
        } catch (Exception $ex) {
            $this->errors = $ex->getMessage();
        }
        return null;
    }

    /**
     * 获取一个MongoCollection对象
     * @param string 数据库名
     * @param string 集合名
     * @return MongoCollection MongoDB集合
     */
    public function selectCollection($db_name, $coll_name){
        $this->db_name = $db_name;
        $this->coll_name = $coll_name;
        try {
            return $this->mongo->selectCollection($db_name, $coll_name);
        } catch (Exception $ex) {
            $this->errors = $ex->getMessage();
        }
    }

    /**
     * 删除集合
     * @param string 集合名
     * @return bool 操作结果
     */
    public function drop($coll_name){
        $db_name = $this->db_name;
        return $this->mongo->$db_name->$coll_name->drop();
    }

    /**
     * 创建一个索引
     * @param string 集合名
     * @param array 字段名
     * @param array array(unique=>false), unique=true时创建唯一索引
     * @return bool 操作结果
     */
    public function createIndex($coll_name, $keys, $options=['unique'=>false]) {
        $db_name = $this->db_name;
        try{
            return $this->mongo->$db_name->$coll_name->createIndex($keys, $options);
        } catch (Exception $ex) {
            $this->errors = $ex->getMessage();
        }
        return false;
    }

    /**
     * 执行一条命令
     * @param array 命令
     * @return array 执行结果
     */
    public function command($command){
        $db_name = $this->db_name;
        return $this->mongo->$db_name->command($command);
    }

    /**
     * 删除集合索引
     * @param string 集合名
     * @param array 键
     * @return bool 操作结果
     */
    public function deleteIndex($coll_name, $keys){
        $db_name = $this->db_name;
        return $this->mongo->$db_name->$coll_name->deleteIndex($keys);
    }

    /**
     * 删除集合所有的索引
     * @param string 集合名
     * @return bool 操作结果
     */
    public function deleteAllIndex($coll_name){
        $db_name = $this->db_name;
        return $this->mongo->$db_name->$coll_name->deleteIndexes();
    }

    /**
     * 插入文档到集合（支持批量插入）
     * @param string 集合名
     * @param array 文档
     * @return bool 是否插入成功
     */
    public function insert($coll_name, $docs) {
        $db_name = $this->db_name;
        return $this->mongo->$db_name->$coll_name->insert($docs);
    }

    /**
     * 保存一个结果（如果存在此对象则更新，否则插入）
     * @param string 集合名
     * @param array 文档
     * @return bool 插入结果
     */
    public function save($coll_name, $neo_data){
        $db_name = $this->db_name;
        try{
            return $this->mongo->$db_name->$coll_name->save($neo_data);
        } catch (Exception $ex) {
            $this->errors = $ex->getMessage();
        }
        return false;
    }

    /**
     * 更新一个文档
     * @param string 集合名
     * @param array 条件
     * @param array 更新的文档
     * @param array 选项 array(upsert=>0) upsert=1时，如果不存在符合条件的文档则将新文档插入 multiple=1时表示更新所有符合条件的记录，否则只会更新1条
     * @return bool 是否插入成功
     */
    public function update($coll_name, $condition, $updateData, $options = ['fsync'=>0, 'upsert'=>0, 'multiple'=>0]) {
        $db_name = $this->db_name;
        $options['save'] = 1;
        try {
            return $this->mongo->$db_name->$coll_name->update($condition, $updateData, $options);
        } catch (Exception $ex) {
            $this->errors = $ex->getMessage();
        }
        return false;
    }

    /**
     * 删除集合记录
     * @param string 集合名
     * @param array 删除条件
     * @param array 选项 array(justOne=>0) justOne=1时只删除1条记录
     * @return bool 删除结果
     */
    public function remove($coll_name, $condition, $options = array(justOne=>0, fsync=>0)) {
        $db_name = $this->db_name;
        $options['save'] = 1;
        if ( !isset($options['justOne'])){
            $options['justOne'] = 0;
        }
        try{
            return $this->mongo->$db_name->$coll_name->remove($condition, $options);
        } catch (Exception $ex) {
            $this->errors = $ex->getMessage();
        }
        return false;
    }

    /**
     * 查询MongoDB
     * @param string 集合名
     * @param array 查询的条件array<br/>如<i>array(col_a=>111)</i>
     * @param array 集合过滤器array<br/>完整的样子想这个：<i>array(sort=>array(col_a=>1,col_b=>-1), skip=>100, limit=>10, timeout=>5000, immortal=>true)</i>,这表示：
     * <ol>
     * <li>wrapped 以wrapped为封装为数组的键，默认按数组先后顺序</li>
     * <li>_id，默认不返回数据带有MongoID字段，如果指定了返回列的话也是一样的效果</li>
     * <li>sort 以col_a为ASC,col_b为DESC排序，可以多列组合</li>
     * <li>skip 表示从101条记录开始取数据，即跳过了前100条</li>
     * <li>limit 本次选取的条数</li>
     * <li>timeout 表示等待响应的时间（暂不使用）</li>
     * <li>immortal 表示是否维持链接永久有效，默认true，此时timeout失效（暂不使用）</li>
     * </ol>
     * @param array 需要返回的字段（通常只返回必要的字段可以加快响应速度）
     * @return mixed 查询的结果
     */
    public function find($coll_name, $condition = [], $skip = '', $limit = '', $ret_fields =[], $sort = '', $wrapped = '') {
        $db_name = $this->db_name;
        $cursor = $this->mongo->$db_name->$coll_name->find($condition, $ret_fields);
        if (!empty($skip)) {
            $cursor->skip($skip);
        }
        if (!empty($limit)){
            $cursor->limit($limit);
        }
        if (!empty($sort)) {
            $cursor->sort($sort);
        }
        $result = [];
        $this->cursor = $cursor;
        try {
            if ($wrapped == '_id') {
                while($ret = $cursor->getNext()){
                    $result[$ret['_id']->{'$id'}] = $ret;
                }
            } else if (strlen ($wrapped) ) {
                while($ret = $cursor->getNext()){
                    $result[$ret[$wrapped]] = $ret;
                }
            } else {
                while($ret = $cursor->getNext()){
                    $result[] = $ret;
                }
            }
        } catch (Exception $ex) {
            $this->errors = $ex->getMessage();
        }
        return $result;
    }

    /**
     * 根据ID查询一条记录
     * @param string 集合名
     * @param string MongoId
     * @param mixed 指定返回的列，默认返回所有列
     * @return mixed 结果
     */
    public function findByObjectId($coll_name, $_id, $ret_fields=array()){
        $db_name = $this->db_name;
        return $this->mongo->$db_name->$coll_name->findOne(array('_id'=>( new MongoId($_id))), $ret_fields);
    }

    /**
     * 查询一条记录
     * @param string 集合名
     * @param array 查询条件
     * @param array 需要返回的字段
     * @return array 查询的结果
     */
    public function findOne($coll_name, $condition=array(), $fields = array('_id'=>0)) {
        $db_name = $this->db_name;
        if (is_string($condition['_id'])){
            $condition['_id'] = new MongoId($condition['_id']);
        }
        return $this->mongo->$db_name->$coll_name->findOne($condition, $fields);
    }

    /**
     * 计算集合内指定条件文档的数量
     * @param string 集合名
     * @param array 查询的条件
     * @param int 指定返回结果数量的上限
     * @param int 统计前跳过的结果数量
     * @return int 集合的数量
     */
    public function count($coll_name, $condition=array(), $limit=0, $skip=0){
        $db_name = $this->db_name;
        return $this->mongo->$db_name->$coll_name->count($condition, $limit, $skip);
    }
}