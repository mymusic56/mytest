<?php
namespace Home\Model;
use Think\Model;
use Think\Model\RelationModel;
class DeptModel extends RelationModel {
    protected $trueTableName = 'depts';
    protected $_link = array(
            'Users' => array(
                    'mapping_type'  => self::HAS_MANY,
                    'class_name'    => 'Users',
                    'foreign_key'   => 'dept_id',
            )
    );
}
