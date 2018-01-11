<?php
/*Form for an admin to edit a request*/
class Application_Form_Admin_Edit_Request extends Zend_Form {

    public function init() {

        $this->setName('request');
        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');

        $date_in = new Zend_Form_Element_Text('date_in');
        $date_in->setLabel('Date in')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty');
        
        $user = new Application_Model_DbTable_User();
        $userList = $user->getUserList();
        
        $techList = $user->getTechList();
        
        $priority1 = new Application_Model_DbTable_Priority();
        $priorityList = $priority1->getPriorityList();
        
        $status1 = new Application_Model_DbTable_Status();
        $statusList = $status1->getStatusList();
        
        $originator_id = new Zend_Form_Element_Select('originator_id');
        $originator_id->setLabel('Originator')
        ->addMultiOptions($userList);

        $assigned_to_id = new Zend_Form_Element_Select('assigned_to_id');
        $assigned_to_id->setLabel('Assigned to')
        ->addMultiOptions($techList);

        $subject = new Zend_Form_Element_Text('subject');
        $subject->setLabel('Subject')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty');

        $description = new Zend_Form_Element_Textarea('description');
        $description->setLabel('Description')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty');

        $comments = new Zend_Form_Element_Textarea('comments');
        $comments->setLabel('Comments')
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty');

        $date_out = new Zend_Form_Element_Text('date_out');
        $date_out->setLabel('Date out')
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty');
        
        $priority = new Zend_Form_Element_Select('priority');
        $priority->setLabel('priority')
        ->addMultiOptions($priorityList);

        $status_id = new Zend_Form_Element_Select('status_id');
        $status_id->setLabel('Status')
        ->addMultiOptions($statusList);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');
        $this->addElements(array($id, $date_in, $originator_id, $assigned_to_id, $subject, $description, $comments, $date_out, $priority, $status_id, $submit));
    }

}

?>