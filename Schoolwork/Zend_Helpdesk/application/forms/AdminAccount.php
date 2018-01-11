<?php
/*form for an admin to modify accounts*/
class Application_Form_AdminAccount extends Zend_Form {

    public function init() {
        $this->setName('account');
        $this->setMethod('post');
        $account1 = new Application_Model_DbTable_Account();
        $accountTypeList = $account1->getAccountList();

        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');
        
        $this->addElement('hidden', 'id', array(
            'required' => true,
        ));
        
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
        $this->addElement('select', 'account_type_id', array(
            'label' => 'account type',
            'MultiOptions' => $accountTypeList,
        ));

        $this->addElement('submit', 'save', array(
            'required' => false,
            'ignore' => true,
            'label' => 'save changes',
        ));
    }

}

?>
