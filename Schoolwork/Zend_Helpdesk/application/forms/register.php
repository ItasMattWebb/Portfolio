<?php
/*Form for a user to register*/
class Application_Form_Register extends Zend_Form {

    public function init() {
        $this->setName("login");
        $this->setMethod('post');

        $this->addElement('text', 'username', array(
            'filters' => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required' => true,
            'label' => 'Username:',
        ));
        $this->addElement('text', 'full_name', array(
            'filters' => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required' => true,
            'label' => 'Full Name:',
        ));


        $this->addElement('password', 'password', array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required' => true,
            'label' => 'Password:',
        ));
        $account = new Application_Model_DbTable_Account();
        $accountTypeList = $account->getUserAccountList();
        
        
        $this->addElement('radio', 'account_type_id', array(
            'label' => 'Account type',
            'required' => true,
            'multiOptions' => $accountTypeList,
        ));

        $this->addElement('submit', 'register', array(
            'required' => false,
            'ignore' => true,
            'label' => 'Register',
        ));
    }

}

?>
