<?php
/*for for a user to edit their own account*/
class Application_Form_Account extends Zend_Form {

    public function init() {
        $this->setName('account');
        $this->setMethod('post');
        
        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');
        
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

        $this->addElement('submit', 'save', array(
            'required' => false,
            'ignore' => true,
            'label' => 'save changes',
        ));
    }

}

?>
