<?php
namespace Home\Model;
use Think\Model;
class GroupsModel extends Model {
	protected $connection = 'DB_CONFIG2';
	protected $tablePrefix = 'ac_';
	protected $tableName = 'group_copy';
// 	protected $trueTableName  = 'ac_group_copy';
}