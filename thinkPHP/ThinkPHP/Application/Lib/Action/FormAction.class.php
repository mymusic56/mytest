<?php
class FormAction extends Action{
	public function insert(){
		$Form   =   D('Form');
		if($Form->create()) {
			$result =   $Form->add();
			if($result) {
				var_dump($result);die;
				$this->success('操作成功！');
			}else{
				$this->error('写入错误！');
			}
		}else{
			$this->error($Form->getError());
		}
	}
}