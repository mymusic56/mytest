<?php
App::uses('AppController', 'Controller');
class ZhangTestsController extends AppController{
	public $uses = ['User'];
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow();
	}
	public function index(){
		$this->Session->write('user1', 111);
// 		call_user_func(['ZhangTestsController', 'passwordEncrypt']);die;
		var_dump($this->Session->read('user1'));die;
	}
	
	public function importPicture(){
		
	}
	public function passwordEncrypt($username=null){
		if($username == null){
			$username = 'www';
		}
		$data = [
				'User' =>[
					'username' =>  $username ,
					'password' =>  '123456' ,
					'group_id' =>  '2'
				]
		];
		$this->User->save($data);die;
	}
}