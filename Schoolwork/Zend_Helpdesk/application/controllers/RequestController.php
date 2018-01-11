<?php

/* Controller to handle all requests */

class RequestController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    /* calls the new request form, and the action to add it to the database */

    public function addAction() {
        $form = new Application_Form_User_Create_Request();
        $form->submit->setLabel('Add');
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $date_in = $form->getValue('date_in');
                $originator_id = $form->getValue('originator_id');
                $assigned_to_id = $form->getValue('assigned_to_id');
                $subject = $form->getValue('subject');
                $description = $form->getValue('description');
                $comments = $form->getValue('comments');
                $date_out = $form->getValue('date_out');
                $priority = $form->getValue('priority');
                $status_id = $form->getValue('status_id');
                $category = 0;
                foreach ($form->getValue('category') as $item) {
                    $category += (int) $item;
                }
                $request = new Application_Model_DbTable_Request();
                $request->addRequest($date_in, $originator_id, $assigned_to_id, $subject, $description, $comments, $date_out, $priority, $category, $status_id);
                $this->_helper->redirector('home', 'index');
            } else {
                $form->populate($formData);
            }
        }
    }

    /* calls the new request form, and the action to add it to the database */

    public function searchAction() {
        $auth = Zend_Auth::getInstance();
        if (!($auth->getIdentity()->account_type_id < 3)) {
            $this->_helper->redirector('index', 'index');
        }
        if ($this->getRequest()->isPost()) {
            $search = $this->getRequest()->getPost('id');
            $request = new Application_Model_DbTable_Request();
            $this->view->request = $request->getRequest($search);
        }
    }

    /* calls the edit request form, and the action to edit the database entrry */

    public function editAction() {
        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            $this->_helper->redirector('index', 'index');
        }
        if ($auth->getIdentity()->account_type_id < 3) {
            if ($auth->getIdentity()->account_type_id == 1) {
                $form = new Application_Form_Admin_Edit_Request();
            } else {
                $form = new Application_Form_Tech_Edit_Request();
            }
        } else {
            $form = new Application_Form_User_Edit_Request();
        }
        $form->submit->setLabel('Save');
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $id = (int) $form->getValue('id');
                $date_in = $form->getValue('date_in');
                $originator_id = $form->getValue('originator_id');
                $assigned_to_id = $form->getValue('assigned_to_id');
                $subject = $form->getValue('subject');
                $description = $form->getValue('description');
                $comments = $form->getValue('comments');
                $date_out = $form->getValue('date_out');
                $priority = $form->getValue('priority');
                $confirm = $form->getValue('category');
                $category = 0;
                //calculates the value for the category column
                if(!empty($confirm)) {
                    foreach ($form->getValue('category') as $item) {
                        $category += (int) $item;
                    }
                }
                $status_id = $form->getValue('status_id');
                $request = new Application_Model_DbTable_Request();
                $request->updateRequest($id, $date_in, $originator_id, $assigned_to_id, $subject, $description, $comments, $date_out, $priority, $category, $status_id);
                $this->_helper->redirector('home', 'index');
            } else {
                $form->populate($formData);
            }
        } else {
            $id = $this->_getParam('id', 0);
            if ($id > 0) {
                $request = new Application_Model_DbTable_Request();
                $form->populate($request->getRequest($id));
            }
        }
    }

    /* calls a method in the request model to change the assigned_to field to the user who assigned the ticket to himself. */

    public function assignAction() {

        if ($this->getRequest()->isPost()) {
            $id = $this->getRequest()->getParam('id');
            $assignId = $this->getRequest()->getPost('assignId');
            $request = new Application_Model_DbTable_Request();
            $request->updateAssignRequest($id, $assignId);
            $this->_helper->redirector('home', 'index');
        } else {
            $auth = Zend_Auth::getInstance();
            if ($auth->getIdentity()->account_type_id == 1) {
                $form = new Application_Form_Admin_Assign_Request();
                $this->view->form = $form;
            } else {
                $id = $this->getRequest()->getParam('id', 0);
                $request = new Application_Model_DbTable_Request();
                $request->updateAssignRequest($id, $auth->getIdentity()->id);
                $request->updateStatusRequest($id, 2);
                $this->_helper->redirector('home', 'index');
            }
        }
    }

    /* calls the cancel form, and the cancel function in the request model */

    public function cancelAction() {
        if ($this->getRequest()->isPost()) {
            $can = $this->getRequest()->getPost('can');
            if ($can == 'Yes') {
                $id = $this->getRequest()->getPost('id');
                $request = new Application_Model_DbTable_Request();
                $request->updateStatusRequest($id, 4);
            }
            $this->_helper->redirector('home', 'index');
        } else {
            $id = $this->_getParam('id', 0);
            $request = new Application_Model_DbTable_Request();
            $this->view->request = $request->getRequest($id);
        }
    }

    /* calls the delete form, and the delete function in the request model */

    public function deleteAction() {
        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if ($del == 'Yes') {
                $id = $this->getRequest()->getPost('id');
                $request = new Application_Model_DbTable_Request();
                $request->deleteRequest($id);
            }
            $this->_helper->redirector('home', 'index');
        } else {
            $id = $this->_getParam('id', 0);
            $request = new Application_Model_DbTable_Request();
            $this->view->request = $request->getRequest($id);
        }
    }

}