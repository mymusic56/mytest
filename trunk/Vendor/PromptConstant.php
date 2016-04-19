<?php
class PromptConstant{
	public static function needLogin(){
		exit(json_encode(['code' => '0', 'message' => '请登录后再操作']));
	}
	public static function success($data=null){
		exit(json_encode(['code' => '1', 'message' => '操作成功', 'data' => $data]));
	}
	public static function failed(){
		exit(json_encode(['code' => '0', 'message' => '操作失败']));
	}
	public static function idNull($prefix){
		exit(json_encode(['code' => '0', 'message' => '操作失败,'.$prefix.'Id 为空']));
	}
	public static function message($message){
		exit(json_encode(['code' => '0', 'message' => $message]));
	}
}