<?php
class Register_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
  
    function set_user($post){
        $this->db->insert('users', $post);
        // last inserted id
        return $this->db->insert_id();
    }
    
    function set_FTP($inserted_row, $mail){
        $this->db->insert('ftps', array('user_id' => $inserted_row, 'directory' => $mail));
    }
    
}
?>