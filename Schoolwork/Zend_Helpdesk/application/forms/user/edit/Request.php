<?php
/*Form for the user to edit a request.*/
class Application_Form_User_Edit_Request extends Zend_Form {

    public function init() {

        $this->setName('request');
        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');


        $date_in = new Zend_Form_Element_Hidden('date_in');

        $originator_id = new Zend_Form_Element_Hidden('originator_id');

        $assigned_to_id = new Zend_Form_Element_Hidden('assigned_to_id');

        $subject = new Zend_Form_Element_Hidden('subject');

        $description = new Zend_Form_Element_Textarea('description');
        $description->setLabel('Description')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty');
        $categoryDB = new Application_Model_DbTable_Category();
        $categoryList = $categoryDB->getCategoryList();
        $count = count($categoryList);
        $countuse = new Zend_Form_Element_Hidden('count');
        $countuse->setValue($count);
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
        $comments = new Zend_Form_Element_Hidden('comments');
        $date_out = new Zend_Form_Element_Hidden('date_out');
        $priority = new Zend_Form_Element_Hidden('priority');
        $status_id = new Zend_Form_Element_Hidden('status_id');
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');
        $this->addElements(array($id, $date_in, $originator_id, $assigned_to_id, $subject, $description, $comments, $date_out, $priority, $category, $status_id, $submit));
    }

}