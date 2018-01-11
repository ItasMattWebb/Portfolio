<?php
/*Status table to handle statuses*/
class Application_Model_DbTable_Status extends Zend_Db_Table_Abstract {

    protected $_name = 'status';
    /*gets a list of all enabled statuses*/
    public function getStatusList() {
        $select = $this->_db->select()
                        ->from($this->_name, array('key' => 'id', 'value' => 'description'))->where("enabled = 0");
        $result = $this->getAdapter()->fetchAll($select);
        return $result;
    }
    /*gets status description by id*/
    function getStatusId($id) {
        $row = $this->fetchRow('id =' . $id);
        return $row->description;
    }
    /*gets status by id*/
    public function getStatus($id) {
        $id = (int) $id;
        $row = $this->fetchRow('id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }
    /*updates an existing status*/
    public function saveStatus($formData) {
        if ($formData['enabled'] > 1) {
            $formData['enabled'] = 1;
        }
        $data = array(
            'description' => $formData['description'],
            'enabled' => $formData['enabled'],
        );
        $this->update($data, 'id = ' . (int) $formData['id']);
    }
    /*adds a status to the database*/
    public function addStatus($formData) {
        if ($formData['enabled'] > 1) {
            $formData['enabled'] = 1;
        }
        $data = array(
            'description' => $formData['description'],
            'enabled' => $formData['enabled'],
        );
        $this->insert($data);
    }

}