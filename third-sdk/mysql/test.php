<?php
/**
 * DateTime: 2020/10/7 13:37
 * @author: zhangshengji
 */

require 'mysql.php';
$pdo = createPDOBy();
while (true) {
    $result = $pdo->getAttribute(PDO::ATTR_SERVER_INFO);
    var_dump($result);
    sleep(5);
}

//$var = $pdo->query("select * from test");

//$statement = $pdo->prepare("select * from users where id=2");
//$statement->execute();
//$result = $statement->fetch(PDO::FETCH_OBJ);
//var_dump($result);
//var_dump($result->name);