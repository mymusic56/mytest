<?php if (!defined('THINK_PATH')) exit();?><html>
 <head>
   <title>hello <?php echo ($name); ?></title>
 </head>
 <body>
    hello, <?php echo ($name); ?>!
    <?php if(is_array($users)): $i = 0; $__LIST__ = $users;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i; echo ($v["id"]); ?>--<?php echo ($v["username"]); ?>--<?php echo ($v["group_id"]); ?></br><?php endforeach; endif; else: echo "" ;endif; ?>
 </body>
</html>