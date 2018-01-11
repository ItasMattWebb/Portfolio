<?php
/*Controller to handle all activity not bound for the Request Controller*/
class IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }
    /*Login page action. Displays a form, validates it, and if the user's data is valid he is redirected to the home page.*/
    public function indexAction() {
        $form = new Application_Form_Login();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                if ($this->_process($form->getValues())) {
                    $this->_helper->redirector('home', 'index');
                }
            }
        }
        $this->view->form = $form;
    }
    /*Register page action. Allows a user to register, then immediatly logs them in and redirects them to the home page.*/
    public function registerAction() {
        $form = new Application_Form_Register();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                if ($this->_register($form->getValues())) {
                    $this->_helper->redirector('home', 'index');
                }
            }
        }
        $this->view->form = $form;
    }
    /*Account page. A user can edit his account, and when finished, is redirected to the home page.*/
    public function accountAction() {
        $request = $this->getRequest();
        $form = new Application_Form_Account();

        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                if ($this->_save($form->getValues())) {
                    $this->_helper->redirector('home', 'index');
                }
            } else {
                $form->populate($request->getPost());
            }
        } else {
            $auth = Zend_Auth::getInstance();
            $id = $auth->getIdentity()->id;
            $user = new Application_Model_DbTable_User();
            $form->populate($user->getUser($id));
        }

        $this->view->form = $form;
    }
    /*The home page. It displays all the tickets a user is authorized to view.*/
    public function homeAction() {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $request = new Application_Model_DbTable_Request();

            $this->view->request = $request->fetchAll();
        } else {
            $this->_helper->redirector('index', 'index');
        }
    }
    /*The administrator page to list all user accounts.*/
    public function accountmanageAction() {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity() && $auth->getIdentity()->account_type_id == 1) {
            $users = new Application_Model_DbTable_User();
            $this->view->users = $users->fetchAll();
        } else {
            $this->_helper->redirector('index', 'index');
        }
    }
    /*The administrator page used to edit an account selected from the accountmanage page*/
    public function editaccountAction() {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity() && $auth->getIdentity()->account_type_id == 1) {
            $form = new Application_Form_AdminAccount();
            $this->view->form = $form;
            if ($this->getRequest()->isPost()) {
                $formData = $this->getRequest()->getPost();
                if ($form->isValid($formData)) {
                    $user = new Application_Model_DbTable_User();
                    $user->saveUser($formData);
                    $this->_helper->redirector('accountManage', 'index');
                } else {
                    $form->populate($formData);
                }
            } else {
                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                    $request = new Application_Model_DbTable_User();
                    $form->populate($request->getUser($id));
                }
            }
        } else {
            $this->_helper->redirector('index', 'index');
        }
    }
    /*Admin page to delete an account*/
    public function deleteaccountAction() {
        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if ($del == 'Yes') {
                $id = $this->getRequest()->getPost('id');
                $request = new Application_Model_DbTable_User();
                $request->deleteUser($id);
            }
            $this->_helper->redirector('home', 'index');
        } else {
            $id = $this->_getParam('id', 0);
            $request = new Application_Model_DbTable_User();
            $this->view->request = $request->getUser($id);
        }
    }
    /*Page to view all unassigned tickets*/
    public function unassignedAction() {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            if ($auth->getIdentity()->account_type_id < 3) {
                $request = new Application_Model_DbTable_Request();
                $select = $request->select()->where('assigned_to_id = 1');
                $row = $request->fetchAll($select);
                $this->view->request = $row;
            } else {
                $this->_helper->redirector('accountManage', 'index');
            }
        } else {
            $this->_helper->redirector('index', 'index');
        }
    }
    /*Validates a user's credentials*/
    protected function _process($values) {
        $adapter = $this->_getAuthAdapter();
        $adapter->setIdentity($values['username']);
        $adapter->setCredential($values['password']);

        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($adapter);
        if ($result->isValid()) {
            $user = $adapter->getResultRowObject();
            $auth->getStorage()->write($user);
            return true;
        }
        return false;
    }
    /*Registers a user and logs him in*/
    protected function _register($values) {
        $user = new Application_Model_DbTable_User();
        $user->addUser($values);

        $adapter = $this->_getAuthAdapter();
        $adapter->setIdentity($values['username']);
        $adapter->setCredential($values['password']);

        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($adapter);
        if ($result->isValid()) {
            $user = $adapter->getResultRowObject();
            $auth->getStorage()->write($user);
            return true;
        }
        return false;
    }
    /*saves a user after he has edited his account*/
    protected function _save($values) {
        $auth = Zend_Auth::getInstance();
        $adapter = $this->_getAuthAdapter();
        $user = new Application_Model_DbTable_User();
        $values['id'] = $auth->getIdentity()->id;
        $values['account_type_id'] = $auth->getIdentity()->account_type_id;
        $user->saveUser($values);
        $adapter->setIdentity($values['username']);
        $adapter->setCredential($values['password']);


        $result = $auth->authenticate($adapter);
        if ($result->isValid()) {
            $user = $adapter->getResultRowObject();
            $auth->getStorage()->write($user);
            return true;
        }
        return false;
    }
    /*gets the zend_auth adapter*/
    protected function _getAuthAdapter() {

        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('My_');

        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

        $authAdapter->setTableName('user')
                ->setIdentityColumn('username')
                ->setCredentialColumn('password')
                ->setCredentialTreatment('MD5(?)');

        return $authAdapter;
    }
    /*logs a user out*/
    public function logoutAction() {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('index');
    }
    /*Admin page to edit an account type*/
    public function editaccounttypeAction() {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity() && $auth->getIdentity()->account_type_id == 1) {
            $form = new Application_Form_AdminAccountType();
            $this->view->form = $form;
            if ($this->getRequest()->isPost()) {
                $formData = $this->getRequest()->getPost();
                if ($form->isValid($formData)) {
                    $user = new Application_Model_DbTable_Account();
                    $user->saveAccount($formData);
                    $this->_helper->redirector('accountManage', 'index');
                } else {
                    $form->populate($formData);
                }
            } else {
                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                    $request = new Application_Model_DbTable_Account();
                    $form->populate($request->getAccount($id));
                }
            }
        } else {
            $this->_helper->redirector('index', 'index');
        }
    }
    /*Admin page to add an account type*/
    public function addaccounttypeAction() {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity() && $auth->getIdentity()->account_type_id == 1) {
            $form = new Application_Form_AdminAccountType();
            $this->view->form = $form;
            if ($this->getRequest()->isPost()) {
                $formData = $this->getRequest()->getPost();
                if ($form->isValid($formData)) {
                    $user = new Application_Model_DbTable_Account();
                    $user->addAccount($formData);
                    $this->_helper->redirector('accountManage', 'index');
                } else {
                    $form->populate($formData);
                }
            }
        } else {
            $this->_helper->redirector('index', 'index');
        }
    }
    /*Admin page to edit a status*/
    public function editstatusAction() {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity() && $auth->getIdentity()->account_type_id == 1) {
            $form = new Application_Form_AdminAccountType();
            $this->view->form = $form;
            if ($this->getRequest()->isPost()) {
                $formData = $this->getRequest()->getPost();
                if ($form->isValid($formData)) {
                    $user = new Application_Model_DbTable_Status();
                    $user->saveStatus($formData);
                    $this->_helper->redirector('accountManage', 'index');
                } else {
                    $form->populate($formData);
                }
            } else {
                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                    $request = new Application_Model_DbTable_Status();
                    $form->populate($request->getStatus($id));
                }
            }
        } else {
            $this->_helper->redirector('index', 'index');
        }
    }
    /*Admin page to add a status*/
    public function addstatusAction() {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity() && $auth->getIdentity()->account_type_id == 1) {
            $form = new Application_Form_AdminAccountType();
            $this->view->form = $form;
            if ($this->getRequest()->isPost()) {
                $formData = $this->getRequest()->getPost();
                if ($form->isValid($formData)) {
                    $user = new Application_Model_DbTable_Status();
                    $user->addStatus($formData);
                    $this->_helper->redirector('accountManage', 'index');
                } else {
                    $form->populate($formData);
                }
            }
        } else {
            $this->_helper->redirector('index', 'index');
        }
    }
}

