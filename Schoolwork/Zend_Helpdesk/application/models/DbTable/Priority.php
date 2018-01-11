<?php
/*Priority table to handle priorities*/
class Application_Model_DbTable_Priority extends Zend_Db_Table_Abstract {

    protected $_name = 'priority';
    /*returns a list of all the priority items*/
    public function getPriorityList() {
        $select = $this->_db->select()
                ->from($this->_name, array('key' => 'id', 'value' => 'description'));
        $result = $this->getAdapter()->fetchAll($select);
        return $result;
    }
    /*find a priority's description from an id*/
    function getPriorityId($id) {
        $select = $this->select()->where('id =' . $id);
        $row = $this->fetchRow($select);
        return $row->description;
    }

}