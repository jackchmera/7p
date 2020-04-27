<?php

class Panel_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
    
    // do logowania
    function get_user($login, $password)
    {
          $salt='';
       
          // hasło które musi wpisać użytkownik to md z czasu + 1
          $query = $this->db->query("SELECT salt FROM users WHERE mail=? LIMIT 1;", array($login));
                  
          if ($query->num_rows() > 0)
          {
             $row = $query->row();
             $salt = $row->salt;
          }
          
          $pass32 = $password; // hasło które musi wpisać użytkownik
          $password= md5($salt.$pass32.md5('Lolek'));   // to hasło po zahashowaniu
          $query = $this->db->query("SELECT id, mail, password, logo FROM users WHERE mail=? AND password=? LIMIT 1;", array($login, $password));
          return $query->row_array();  
    }   
   
    function get_userdata($id){
        return $this->db->get_where('users', array('id' => $id), 1)->row_array();
    }
    
    function update_logo($logo, $user){
        $this->db->update('users', array('logo' => $logo), array('id' => $user));
    }
    
    function update_password($pass, $salt, $user){
        $this->db->update('users', array('password' => $pass, 'salt' => $salt), array('id' => $user));
    }
    
    function count_all_rows($user) {
        $result = $this->db->query("SELECT COUNT(*) as number FROM `offers` WHERE user=?", array($user))->row_array();
        return $result['number'];
    }
    
    function get_offers($offset, $user){       
        $this->db->select('o.*, (SELECT r.name FROM regions r WHERE r.id = o.voivodeships) as voivodeship_name, (SELECT r.name FROM regions r WHERE r.id = o.district) as district_name');
        $this->db->from('offers o');
        $this->db->where('o.user', $user);
        $this->db->limit('10', $offset);
        $this->db->order_by('id desc');
        return $this->db->get()->result_array();
    }
    
    function setNewOffer($post){
        
        $this->db->insert('offers', $post);
        
    }
    
    function get_districts(){
        return $this->db->get_where('regions', array('voivodeship' => '1', 'level !=' => '1'))->result_array();
    }
    
    function set_new_password($array){
         $this->db->update('users', $array);
    }

}

?>