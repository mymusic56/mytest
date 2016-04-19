<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 * @property RequestHandlerComponent $RequestHandler
 */
class UsersController extends AppController {
	public function beforeFilter(){
		parent::beforeFilter();
// 		$this->Auth->allow();
	}
/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('Text', 'Js', 'Time');

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'RequestHandler');

/**
 * index method
 * @Auth-Description:用户列表页
 * @Auth-isMenu:1
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

/**
 * view method
 * @Auth-Description:用户详情
 * @Auth-isMenu:0
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 * @Auth-Description:用户添加
 * @Auth-isMenu:1
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				return $this->flash(__('The user has been saved.'), array('action' => 'index'));
			}
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

/**
 * edit method
 * @Auth-Description:用户编辑
 * @Auth-isMenu:0
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				return $this->flash(__('The user has been saved.'), array('action' => 'index'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

/**
 * delete method
 * @Auth-Description:用户删除
 * @Auth-isMenu:0
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete()) {
			return $this->flash(__('The user has been deleted.'), array('action' => 'index'));
		} else {
			return $this->flash(__('The user could not be deleted. Please, try again.'), array('action' => 'index'));
		}
	}
	/**
	  * @Auth-Description:用户登录
      * @Auth-isMenu:0
	 */
	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->Session->setFlash(__('Your username or password was incorrect.'));
		}
	}
	/**
	 * @Auth-Description:用户退出
     * @Auth-isMenu:0
	 */
	public function logout() {
		//Leave empty for now.
		return $this->redirect($this->Auth->logout());
	}
	public function initDB() {
		$group = $this->User->Group;
		// Allow admins to everything
		$group->id = 1;
		$res = $this->Acl->allow($group, 'controllers');
		var_dump($res);
	
		// allow managers to posts and widgets
// 		$group->id = 3;
// 		$this->Acl->deny($group, 'controllers');
// 		$this->Acl->allow($group, 'controllers/Posts');
// // 		$this->Acl->allow($group, 'controllers/Widgets');
	
// 		// allow users to only add and edit on posts and widgets
		$group->id = 2;
		$this->Acl->deny($group, 'controllers');
		$this->Acl->allow($group, 'controllers/Posts/add');
		$this->Acl->allow($group, 'controllers/Posts/edit');
// 		$this->Acl->allow($group, 'controllers/Widgets/add');
// 		$this->Acl->allow($group, 'controllers/Widgets/edit');
	
		// allow basic users to log out
		$this->Acl->allow($group, 'controllers/users/index');
	
		// we add an exit to avoid an ugly "missing views" error message
		echo "all done";
		exit;
	}
}
