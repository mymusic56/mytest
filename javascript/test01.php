<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title>JavaScript测试</title>

</head>
<body>
<h1>测试Ajax</h1>
<?php 
    if(strtolower($_SERVER['REQUEST_METHOD']) == 'post'){
        exit(json_encode($_POST));
    }
?>
</body>
<script src="js/test01.js"></script>
<script>
ajax_request.data = "pwd=123456", 
ajax_request.url="/javascript/test01.php",
ajax_request.type='POST';
ajax_request.myAajax();
</script>
</html>
