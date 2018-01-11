<?php
/*Category table to handle categories*/
class Application_Model_DbTable_Category extends Zend_Db_Table_Abstract {

    protected $_name = 'category';
    /*returns a category based on a given id*/
    public function getCategory($id) {
        $id = (int) $id;
        $row = $this->fetchRow('id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }
    /*returns a list of all categories*/
    public function getCategoryList() {
        $select = $this->_db->select()
                ->from($this->_name, array('key' => 'id', 'value' => 'description'));
        $result = $this->getAdapter()->fetchAll($select);
        return $result;
    }
    /*returns the description of a category for a given id*/
    public function getCategoryDescription($id){
        $id = (int) $id;
        $row = $this->fetchRow('id = ' . $id);
        return $row->description;
    }
    /*determines which category(ies) a ticket belongs to based on a given number*/
    public function calcCategory($total) {
        $array = array();
        $string = ""; 
        while ($total > 0) {
            if ($total < 16) {
                if ($total < 8) {
                    if ($total < 4) {
                        if ($total < 2) {
                            $total -= 1;
                            $array[] = $this->getCategoryDescription(1);
                        } else {
                            $total -=2;
                            $array[] = $this->getCategoryDescription(2);
                        }
                    } else {
                        $total -=4;
                        $array[] = $this->getCategoryDescription(3);
                    }
                } else {
                    $total -=8;
                    $array[] = $this->getCategoryDescription(4);
                }
            } else {
                $total -= 16;
                $array[] = $this->getCategoryDescription(5);
            }
        }
        foreach ($array as $item) {
            $string = $string . $item . ", ";
        }
        $stringfinal = substr($string , 0, -2);
        return $stringfinal;
    }

}

