<?php
/*User table to handle users*/
class Application_Model_DbTable_User extends Zend_Db_Table_Abstract {

    protected $_name = 'user';
    /*gets a user by id*/
    public function getUser($id) {
        $id = (int) $id;
        $row = $this->fetchRow('id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }
    /*gets a user's username by id*/
    function getId($id) {
        $row = $this->fetchRow('id = ' . $id);
        return $row->username;
    }
    /*adds a user to the database*/
    public function addUser($values) {
        $data = array(
            'full_name' => $values['full_name'],
            'username' => $values['username'],
            'password' => md5($values['password']),
            'account_type_id' => $values['account_type_id'],
        );
        $this->insert($data);
    }
    /*saves an existing user who's values have changed*/
    public function saveUser($values) {
        $data = array(
            'full_name' => $values['full_name'],
            'username' => $values['username'],
            'password' => md5($values['password']),
            'account_type_id' => $values['account_type_id'],
        );
        $this->update($data, 'id = ' . (int) $values['id']);
    }
    /*gets a list of all students and instructors*/
    public function getUserList() {
        $select = $this->_db->select()
                        ->from($this->_name, array('key' => 'id', 'value' => 'username'))->where('account_type_id > 2');
        $result = $this->getAdapter()->fetchAll($select);
        return $result;
    }
    /*gets a list of all technicians and administrators*/
    public function getTechList() {
        $select = $this->_db->select()
                        ->from($this->_name, array('key' => 'id', 'value' => 'username'))->where('account_type_id < 3');
        $result = $this->getAdapter()->fetchAll($select);
        return $result;
    }
    /*disables a user's account*/
    public function deleteUser($id) {
        $data = array('password' => 'disabled');
        $this->update($data, 'id =' . (int) $id);
    }

}

