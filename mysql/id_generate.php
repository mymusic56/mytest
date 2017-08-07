<?php
require_once 'mysql.ini.php';
// 创建连接
$conn = new mysqli($servername, $username, $password, $database);
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} else{
	
	//测试REPLACE INTO
	$sql = "REPLACE INTO sequence(a) values('1');";
	$result = $conn->query($sql);
	var_dump($result);
	
	//$result = $conn->query("SELECT LAST_INSERT_ID()");
	
	//测试插入数据的ID
	$result = mysqli_insert_id($conn);
 	var_dump($result);die;
}

$conn->close();