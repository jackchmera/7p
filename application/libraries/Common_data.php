<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* Common data for all views */ 
class Common_data extends CI_Controller {
    
    protected $CI;
    
    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->model('Main_model');
        $this->CI->load->helper('security');
    }    
    
    public function index(){
        $data = array();
        $data['csrf'] = array(
            'name' => $this->CI->security->get_csrf_token_name(),
            'hash' => $this->CI->security->get_csrf_hash()
        );
        // counter
        $this->CI->load->library('counters');
        $data['count'] = $this->CI->counters->counter();
        // voivodeships 
        $data['voivodeships'] = $this->CI->Main_model->get_voivodeships(); 
        $data['kinds'] = $this->CI->Main_model->get_kinds(); 
        // posty do stopki
        $data['posts_footer'] = $this->CI->Main_model->get_posts_footer();
        // posty do stopki TV
        $data['tv_footer'] = $this->CI->Main_model->get_posts_tv_footer();
        // podstrony do stopki
        $data['pgneu'] = $this->CI->Main_model->get_main_pages();
        $data['services'] = $this->CI->Main_model->get_services();
        return $data;
    }
}
