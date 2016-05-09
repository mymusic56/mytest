<?php
App::uses('AppController', 'Controller');
class DatatablesTestsController extends AppController{
	public $uses = ['Client'];
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow();
	}
	/**
	 * 返回参数
	 * draw:
	 * columns:[{}]
	 * order:[{column:"1", dir:"desc"}]
	 * start:"1"
	 * length:"10"
	 * search:{value:"", regex:""}
	 */
	public function index(){
		if($this->request->is('ajax')){
			$data = $_GET;
// 			$data = $_POST;
			var_dump($data);die;
			$option = ['Client.enabled = 1'];
			$params = [
					'columns' => [
							'Client.id',
							'Client.client',
							'Client.abbr',
					]
			];
			if($data['search']['value']){
				$option[] = [
						'OR' => [
								'client LIKE "%'.$data['search']['value'].'%"',
								'abbr LIKE "%'.$data['search']['value'].'%"',
						]
				];
			}
			$order = [];
			#应该采用遍历的方式获取排序
			if($data['order'][0]['column'] != '' && $data['order'][0]['dir']){
				$order = [$params['columns'][$data['order'][0]['column']]." ".$data['order'][0]['dir']];
			}
// 			var_dump($order);die;
			$output = [];
			$output['recordsTotal'] = $this->Client->find('count', ['conditions' => $option]);
			$output['recordsFiltered'] = $output['recordsTotal'];
			$output['draw'] = $data['draw'];
			
			$clients = $this->Client->find('all', [
					'conditions' => $option,
					'page' => $data['start']/$data['length']+1,
					'limit' => $data['length'],
					'order' => $order
			]);
			foreach ($clients as $item){
				$output['data21'][] = [//aaData,data
						$item['Client']['id'],
						$item['Client']['client'],
						$item['Client']['abbr'],
				];
			}
			exit(json_encode($output));
			// 			var_dump($data);die;
		}
	}
	public function index1(){
		if($this->request->is('ajax')){
			$data = $_GET;
			$clients = $this->Client->find('all', [
					'conditions' => [
							'Client.enabled = 1'
					],
					'page' => 1,
					'limit' => 20
			]);
			$data = [];
// 			foreach ($clients as $item){
// 				$data[] = $item['']
// 			}
			exit(json_encode($clients));
// 			var_dump($data);die;
		}
	}
} 