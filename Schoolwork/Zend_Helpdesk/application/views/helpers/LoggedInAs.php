<?php
/*Helper to get the currently logged in user*/
class Zend_View_Helper_LoggedInAs extends Zend_View_Helper_Abstract {

    public function loggedInAs() {
        $auth = Zend_Auth::getInstance();
        $username = $auth->getIdentity()->username;
        $logoutUrl = $this->view->url(array('controller' => 'index',
            'action' => 'logout'), null, true);
        return 'Welcome ' . $username .
                '. <br><a href="' .
                $this->view->url(array('controller' => 'index',
                    'action' => 'logout')) .
                '">Logout</a>';
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        if ($controller == 'index' && $action == 'index') {
            return '';
        }
        $loginUrl = $this->view->url(array('controller' => 'index', 'action' => 'index'));
        return 'Login';
    }

}

?>
