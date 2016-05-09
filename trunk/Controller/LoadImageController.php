<?php
App::uses('AppController', 'Controller');
class LoadImageController extends AppController{
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow();
	}
	public function import(){
		App::import('Vendor', 'Weixin/jssdk');
		$jssdk = new JSSDK("wxcf910e653dbc232d", "");
		$signPackage = $jssdk->GetSignPackage();
	$this->set('signPackage', $signPackage);
	}
	public function ossUpload(){
		
	}
	public function jsUploat(){
		
	}
}