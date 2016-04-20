<?php
App::uses('AppController', 'Controller');
class LoadImageController extends AppController{
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow();
	}
	public function import(){
		
	}
	public function ossUpload(){
		
	}
}