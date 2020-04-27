<?php
class Counter_model extends CI_Model {
    
    function get_count(){
         $query = $this->db->query("SELECT no FROM count WHERE id=1");
         return $query->row_array();    
    }
    
    function update_count() {
        $query = $this->db->query("UPDATE count SET no = (no+1) WHERE id=1");
        $query = $this->db->query("SELECT no FROM count WHERE id=1");
        return $query->row_array();    
    }
    
    function update_count_offer($id){
        $query = $this->db->query("UPDATE `offers` SET count = (count+1) WHERE id=?", $id);
    }
}