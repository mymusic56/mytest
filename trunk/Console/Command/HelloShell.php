<?php
class HelloShell extends AppShell{
	public $uses = ['User'];
	/**
	 * cake hello
	 */
	public function main(){
		$this->out('hello world');
	}
	/**
	 * called from command line like
	 * cake hello testArgs aaa bbb
	 * out put 'the args is:bbb'
	 */
	public function testArgs(){
		$this->out('the args is :'.$this->args[1]);
	}
	/**
	 * input:cake hello getUserInfo admin
	 */
	public function getUserInfo(){
		$user = $this->User->findByUsername($this->args[0]);
		$this->out(print_r($user, true));
		$this->out(getcwd());
		$this->createFile(getcwd().'\webroot\aaa.php', '123');
	}
}