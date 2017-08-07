<?php
require_once 'mysql.cluster.ini.php';
// 创建连接
$conn = new mysqli($servername, $username, $password, $database);
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} else{
	$sql = "select * from City";
	$result = $conn->query($sql);
	echo $conn->host_info;
// 	var_dump($result->fetch_all());//$result->fetch_assoc()将会被置空
	if ($result->num_rows > 0) {
		// 输出每行数据
		while($row = $result->fetch_assoc()) {//有点像对列， 执行一次弹出一条记录
			echo "<br> id: ". $row["ID"]. " - City: ". $row["Name"];
		}
	} else {
		var_dump("0 个结果");
	}
	

}