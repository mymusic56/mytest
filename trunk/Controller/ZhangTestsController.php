<?php
App::uses('AppController', 'Controller');
class ZhangTestsController extends AppController{
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow();
	}
	public function index(){
		
	}
	
	public function importPicture(){
		
	}
}