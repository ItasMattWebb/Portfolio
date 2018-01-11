<?php
/*Request table to handle requests*/
class Application_Model_DbTable_Request extends Zend_Db_Table_Abstract {

    protected $_name = 'request';
    /*gets a request based on the id given*/
    public function getRequest($id) {
        $id = (int) $id;
        $row = $this->fetchRow('id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }
    /*Adds a request to the database*/
    public function addRequest($date_in, $originator_id, $assigned_to_id, $subject, $description, $comments, $date_out, $priority, $category, $status_id) {
        $data = array(
            'date_in' => $date_in,
            'originator_id' => $originator_id,
            'assigned_to_id' => $assigned_to_id,
            'comments' => $comments,
            'date_out' => $date_out,
            'subject' => $subject,
            'description' => $description,
            'priority' => $priority,
            'category' => $category,
            'status_id' => $status_id,
        );
        $this->insert($data);
    }
    /*Updates a request in the database*/
    public function updateRequest($id, $date_in, $originator_id, $assigned_to_id, $subject, $description, $comments, $date_out, $priority, $category, $status_id) {

        $data = array(
            'date_in' => $date_in,
            'originator_id' => $originator_id,
            'assigned_to_id' => $assigned_to_id,
            'comments' => $comments,
            'date_out' => $date_out,
            'subject' => $subject,
            'description' => $description,
            'priority' => $priority,
            'status_id' => $status_id,
        );
        if($category != 0){
        $data['category'] = $category;    
        }
        $this->update($data, 'id = ' . (int) $id);
        $this->updateStatusRequest($id, $status_id);
    }
    /*Updates the status of a request, and sets the date_out if the request is finished or cancelled*/
    public function updateStatusRequest($id, $status_id) {
        $data = array(
            'status_id' => $status_id,
        );
        if($status_id == 3 || $status_id == 4){
            $data['date_out'] = date("Y-m-d H:i:s");
        }
        $this->update($data, 'id = ' . (int) $id);
    }
    /*Assigns a request to a user*/
    public function updateAssignRequest($id, $assignId) {
        $data = array(
            'assigned_to_id' => $assignId,
        );
        $this->update($data, 'id = ' . (int) $id);
    }
    /*deletes a request*/
    public function deleteRequest($id) {
        $this->delete('id =' . (int) $id);
    }

}