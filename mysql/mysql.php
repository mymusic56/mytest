<?php
require_once 'mysql.ini.php';
// 创建连接
$conn = new mysqli($servername, $username, $password, $database);
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} else{
// 	mysqli_query($conn, "set ezlife20150818 utf8");
$id = mt_rand(1,6674);

	$sql = "select * from flow_orders where id=$id";
	$result = $conn->query($sql);
	echo $conn->host_info;
// 	var_dump($result->fetch_all());//$result->fetch_assoc()将会被置空
	if ($result->num_rows > 0) {
		// 输出每行数据
		while($row = $result->fetch_assoc()) {//有点像对列， 执行一次弹出一条记录
			echo "<br> id: ". $row["id"]. " - Combo: ". $row["order_no"];
		}
	} else {
		var_dump("0 个结果");
	}
	

}
die;
$conn->prepare("update combos set combo=? where id=?");
$conn->bind_param('1', $id);
die;
$res = $conn->query("select * from combos limit 5");
var_dump($res);
for ($row_no = $res->num_rows - 1; $row_no >= 0; $row_no--) {
	$res->data_seek($row_no);
	$row = $res->fetch_assoc();
	echo " id = " . $row['id'] . "\n";
}
var_dump("--------------------------");
$res->data_seek(0);
while ($row = $res->fetch_assoc()) {
	echo " id = " . $row['id'] . "\n";
}
$conn->close();