<?php
namespace Home\Model;
use Think\Model;
use Think\Model\RelationModel;
class UsersModel extends RelationModel {
	public function test() {
		return 'users model.';
	}
	
	protected $_link = array(
	        'Dept' => array(
	                'mapping_type'  => self::BELONGS_TO,
	                'class_name'    => 'Dept',
	                'foreign_key'   => 'dept_id',
	        )
	);
}
