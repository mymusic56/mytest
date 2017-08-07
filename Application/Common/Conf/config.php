<?php
/**
 * 模型创建时可以重新指定数据库
 * 例如： new \Home\Model\NewModel('blog','think_','mysql://root:1234@localhost/demo');
 */
return array(
		//'配置项'=>'配置值'
		'DB_TYPE'				=>	'mysql',
		'DB_HOST'               =>  'localhost', // 服务器地址
		'DB_NAME'               =>  'mytest',          // 数据库名
		'DB_USER'               =>  'root',      // 用户名
		'DB_PWD'                =>  '',          // 密码
		'DB_PORT'               =>  '3306',        // 端口
		'DB_PREFIX'             =>  '',    // 数据库表前缀
		'DB_FIELDS_CACHE'		=>	true,
		'LOAD_EXT_CONFIG'		=>	'domain',
		'URL_MODEL'             => '2', 	//重写模式
		'DB_CONFIG1' => array(
				'db_type'  => 'mysql',
				'db_user'  => 'root',
				'db_pwd'   => '',
				'db_host'  => 'localhost',
				'db_port'  => '3306',
				'db_name'  => 'mytest2',
				'db_charset'=>    'utf8',
		),
);