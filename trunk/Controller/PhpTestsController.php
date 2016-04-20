<?php
App::uses('AppController', 'Controller');
class PhpTestsController extends AppController{
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
	}
	public function stringTest(){
		$a = ' D , E ， F      ，H';
		$a = str_replace(' ', '', $a);
		$a = str_replace('，', ',', $a);
		$a = explode(',', $a);
		var_dump($a);
		die;
	}
}