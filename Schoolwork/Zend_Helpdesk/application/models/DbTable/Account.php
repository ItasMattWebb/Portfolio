<?php
/*Account table to handle account types*/
class Application_Model_DbTable_Account extends Zend_Db_Table_Abstract {

    protected $_name = 'account_type';
    /*returns an account type based on a given id*/
    public function getAccount($id) {
        $id = (int) $id;
        $row = $this->fetchRow('id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }
    /*returns a list of all enabled accounts*/
    public function getAccountList() {
        $select = $this->_db->select()
                        ->from($this->_name, array('key' => 'id', 'value' => 'description'))->where('enabled =0');
        $result = $this->getAdapter()->fetchAll($select);
        return $result;
    }
    /*returns a list of all enabled user account types*/
    public function getUserAccountList() {
        $select = $this->_db->select()
                        ->from($this->_name, array('key' => 'id', 'value' => 'description'))->where('enabled =0')->where('id >2')->where('id < 5');
        $result = $this->getAdapter()->fetchAll($select);
        return $result;
    }
    /*updates an account type*/
    public function saveAccount($formData) {
        if($formData['enabled'] > 1){
            $formData['enabled'] = 1;
        }
        $data = array(
            'description' => $formData['description'],
            'enabled' => $formData['enabled'],
        );
        $this->update($data, 'id = ' . (int) $formData['id']);
    }
    /*adds a new account type to the database*/
    public function addAccount($formData) {
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

