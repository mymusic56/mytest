<?php
namespace Home\Controller;
use Think\Controller;
class UsersController extends Controller {
	public function test() {
		var_dump('eee');
	}
	
	public function testModelRelation(){
// 	    $User = D('Dept');
// 	    $res = $User->relation(true)->select();
// 	    var_dump($res);die;
	    
	    $User = D('Users');
	    $res = $User->relation(true)->select();
	    var_dump($res);die;
	}
	        
}