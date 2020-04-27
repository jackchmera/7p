<?php
class Main_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_voivodeships() {
        return $this->db->get_where('regions', array('level'=>'1'))->result_array();
    }
    
    function get_kinds() {
        $this->db->order_by('priority asc');
        return $this->db->get('kinds')->result_array();
    }
    
    function get_posts_footer() {
        $this->db->order_by('added desc');
        return $this->db->get_where('posts', array('position'=>'112'), '3')->result_array();
    }
    
    function get_posts_tv_footer() {
        $this->db->order_by('added desc');
        return $this->db->get_where('posts', array('position'=>'121'), '3')->result_array();
    }
    
    function get_main_pages(){
        return $this->db->get_where('contents', array('position'=>'49'))->result_array();
    }
    
    function get_services(){
        return $this->db->get_where('contents', array('position'=>'73'))->result_array();
    }
    
    function get_section1(){
        return $this->db->get_where('contents', array('id'=>'123'), '1')->row_array();
    }
    
    function get_section2(){
        return $this->db->get_where('contents', array('id'=>'124'), '1')->row_array();
    }
    
    function get_section3(){
        return $this->db->get_where('contents', array('id'=>'125'), '1')->row_array();
    }
    
    // promo ofers - main page
    function get_promo_offers(){
        $data = $this->db->query("SELECT o.*, (SELECT r.name FROM regions r WHERE r.id = o.voivodeships) as voivodeship_name, (SELECT r.name FROM regions r WHERE r.id = o.district) as district_name FROM `offers` o WHERE (SELECT u.active FROM users u WHERE u.id = o.user) >= CURRENT_TIMESTAMP() ORDER BY RAND() LIMIT 12")->result_array();
        
        foreach($data as $key => $value){
            
            $data[$key]['main_image'] = $this->db->get_where('images', array('offer_no' => $value['no'], 'user'=>$value['user']), 1)->row_array();
            $data[$key]['ftp'] = $this->db->get_where('ftps', array('user_id'=>$value['user']), 1)->row_array();
        }
        
        return $data;
    }
    
    function get_imports(){
        $this->db->select();
        $this->db->order_by('added desc');
        return $this->db->get('imports', 1)->row_array();
    }
    
    function get_regions_by_voivodeship($voivodeship){
        // level - 0 - wojewodztwo - 1 - powiat - 2 - gmina
        return $this->db->get_where('regions', array('voivodeship' => $voivodeship, 'level' => '2'))->result_array();
    }
    
    
    
    
    
    
    
    
    
    function get_content(){
         $query = $this->db->query("SELECT id, name, content, position, priority FROM contents WHERE visibility='1' AND position = 0");
         return $query->result();    
    }
    
    function left_menu (){
         $query = $this->db->query("SELECT id, name FROM categories ORDER BY id");
         return $query->result();    
    }
    
    function get_album($id){
         $query = $this->db->query("SELECT id, title, description, min, max FROM pictures WHERE category= ".$this->db->escape($id)." AND show_picture = 1 ORDER BY id");
         return $query->result();    
    }
    
    function get_default_album(){
         $query = $this->db->query("SELECT id, title, description, min, max FROM pictures WHERE category=(SELECT MIN(category) FROM pictures WHERE show_picture = 1)");
         return $query->result();    
    }
    
    function getCount(){
         $query = $this->db->query("SELECT no FROM count WHERE id=1");
         return $query->row_array();    
    }
    
    function updateCount() {
        $query = $this->db->query("UPDATE count SET no = (no+1) WHERE id=1");
        
        $query = $this->db->query("SELECT no FROM count WHERE id=1");
        
        return $query->row_array();    
    }
}
?>