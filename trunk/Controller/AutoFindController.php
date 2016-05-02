<?php
App::uses('AppController', 'Controller');
class AutoFindController extends AppController{
	public function beforeFilter(){
		parent::beforeFilter();
// 		$this->Auth->allow();
	}
	public $fileContent;
	public function index(){
// 		echo dirname(__FILE__);die;
		$dir = dir(dirname(__FILE__));
		$functions = [];//controller=>[action]
		while ($file = $dir->read()){
			if($file == basename(__FILE__)){//does not affective
				continue;
			}
			//get controller name
			$pos = strpos($file, 'Controller.php');
			if($pos && $pos+14 == strlen(basename($file))){
// 				var_dump($file);
				if($this->checkFile($file)){
					$controllerName = substr(basename($file), 0, $pos);
// 					$functions[] = $controllerName;
					$functions = $this->getFunction($functions, $controllerName);
				}
				
				#get controller function
				
			}
// 			$fileContent = file
		}
		var_dump($functions);
		die;
	}
	public function importPicture(){
		
	}
	private function checkFile($file)
	{
		$content = file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR.$file);
		$this->fileContent = $content;
		$pos = 0;
		while($pos = strpos($content,"@"."Auth-Description:",$pos))
		{
			return true;
		}
		return false;
	}
	private function getFunction($functions, $controllerName){
		$contents = $this->fileContent;
		$pos = 0;
		while($pos = strpos($contents,"@Auth-Description:",$pos))
		{
			
			$end = strpos($contents, "\n", $pos);
			$desc = substr($contents, $pos+18, $end-$pos-18);
			
			$pos = strpos($contents,"@Auth-isMenu:",$pos);
			$end = strpos($contents, "\n", $pos);
			$isMenu = substr($contents, $pos+13, $end-$pos-13);
			
			$noteEnd = strpos($contents, "*/", $end);
			$pos = strpos($contents, "public", $noteEnd);
			$end = strpos($contents, "(", $pos);
			$action = substr($contents, $pos+16, $end-$pos-16);
			
			$functions[$controllerName][$action]['is_menu'] = $isMenu;
			$functions[$controllerName][$action]['desc'] = $desc;
			$functions[$controllerName][$action]['url'] = $controllerName;
			if($isMenu == 0){//不需要在菜单栏显示
				$functions[$controllerName][$action]['url'] .= '/'.$action;
			}
			
				
		}
		return $functions;
	}
}