<?php
/*form for an admin to modiy account types*/
class Application_Form_AdminAccountType extends Zend_Form {

    public function init() {
        $this->setName('account');
        $this->setMethod('post');

        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');

        $this->addElement('hidden', 'id');

        $this->addElement('text', 'description', array(
            'filters' => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required' => true,
            'label' => 'Description:',
        ));
        $this->addElement('text', 'enabled', array(
            'filters' => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array('StringLength', false, 1),
            ),
            'required' => true,
            'label' => 'enabled:',
        ));

        $this->addElement('submit', 'save', array(
            'required' => false,
            'ignore' => true,
            'label' => 'save changes',
        ));
    }

}

?>
