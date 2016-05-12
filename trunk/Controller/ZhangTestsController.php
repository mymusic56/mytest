<?php
App::uses('AppController', 'Controller');
class ZhangTestsController extends AppController{
	public $uses = ['User'];
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow();
	}
	public function index(){
		call_user_func(['ZhangTestsController', 'passwordEncrypt']);die;
		var_dump(session_id());die;
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