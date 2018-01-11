<?php
/*Form for an admin or tech to search for a request*/
class Application_Form_SearchRequest extends Zend_Form {

    public function init() {
        $this->setName('request');
        $id = new Zend_Form_Element_Text('id');
        $id->setLabel('Id')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty');
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');
        $this->addElements(array($id, $submit));
    }

}

?>
