<?php
class Otherpages_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
  
    function get_post($underid){
        return $this->db->get_where('posts', array('id'=>$underid), 1)->row_array();
    }
    
    function get_posts(){
        $this->db->order_by('added desc');
        return $this->db->get('posts')->result_array();
    }
    
    function get_content ($underid){
        $query = $this->db->query("SELECT name, content, type FROM contents WHERE id = ? LIMIT 1", array($underid));
        return $query->row_array();    
    }
    
    function get_nav($id){
        return $this->db->get_where('contents', array('position' => $id, 'visibility' => '1'))->result_array();
    }
}
?>