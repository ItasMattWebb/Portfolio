<?php
/*Form for the user to create a request.*/
class Application_Form_User_Create_Request extends Zend_Form {

    public function init() {
        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            $this->_helper->redirector('index', 'index');
        }

        $this->setName('request');
        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');


        $date_in = new Zend_Form_Element_Hidden('date_in');
        $date_in->setValue(date("Y-m-d H:i:s"));

        $originator_id = new Zend_Form_Element_Hidden('originator_id');
        $originator_id->setValue($auth->getIdentity()->id);

        $assigned_to_id = new Zend_Form_Element_Hidden('assigned_to_id');
        $assigned_to_id->setValue(1);

        $subject = new Zend_Form_Element_Text('subject');
        $subject->setLabel('Subject')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty');

        $description = new Zend_Form_Element_Text('description');
        $description->setLabel('Description')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty');
        $comments = new Zend_Form_Element_Hidden('comments');
        $comments->setValue(NULL);

        $categoryDB = new Application_Model_DbTable_Category();
        $categoryList = $categoryDB->getCategoryList();
        $count = count($categoryList);
        foreach ($categoryList as $item) {
            if ($item['key'] == $count) {
                unset($categoryList[$item['key']]);
            } else {
                $pow = pow(2, $item['key']);
                $categoryList[$item['key']]['key'] = $pow;
            }
        }
        //var_dump($categoryList);
        $category = new Zend_Form_Element_MultiCheckbox('category');
        $category->setMultiOptions($categoryList);
        $category->setLabel('Category');

        $date_out = new Zend_Form_Element_Hidden('date_out');
        $date_out->setValue(NULL);
        $priority = new Zend_Form_Element_Hidden('priority');
        $priority->setValue(3);
        $status_id = new Zend_Form_Element_Hidden('status_id');
        $status_id->setValue(1);
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');
        $this->addElements(array($id, $date_in, $originator_id, $assigned_to_id, $subject, $description, $comments, $date_out, $priority, $category, $status_id, $submit));
    }

}