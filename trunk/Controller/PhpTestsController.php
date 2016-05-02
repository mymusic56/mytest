<?php
App::uses('AppController', 'Controller');
class PhpTestsController extends AppController{
	public $uses = ['User'];
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
	}
	public function index(){
		$this->arrayAdd();die;
	}
	public function stringTest(){
		$a = ' D , E ， F      ，H';
		$a = str_replace(' ', '', $a);
		$a = str_replace('，', ',', $a);
		$a = explode(',', $a);
		var_dump($a);
		die;
	}
	public function arrayAdd(){
		$c = 'c';
		$d = 'd';
		$aaa = ['a' => 'a', 'b' => 'b', 'ef'=>['e','fg'=>'fg']];
		$arry = compact('c', 'd')+$aaa;
		var_dump($arry);
		var_dump(array_keys($arry));
		die;
	}
	public function testUpdate(){
		$this->User->updateAll($fields);
	}
}