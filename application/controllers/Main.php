<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* Main */
class Main extends MY_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('Main_model');
    }    

    /* Main view */
    public function index() {
       // Common data for all views
       $this->load->library('common_data');
       $this->data = $this->common_data->index();
       
       $this->data['section1'] = $this->Main_model->get_section1();             // Text for section1
       $this->data['section2'] = $this->Main_model->get_section2();             // Text for section2
       $this->data['section3'] = $this->Main_model->get_section3();             // Text for section3
       $this->data['promo_offers'] = $this->Main_model->get_promo_offers();     // Promoted offers 
       $this->data['title'] = 'Polska Giełda Nieruchomości';                    // Page title
        
        //Check that import is necessary
        $this->check_import();
        
        $this->middle = 'main/main_view';                                       // View name
        $this->layout();
    }
    
    /* Retrive offers from xml */
    private function check_import() {
        
        // VARIABLES
        $import = $hour = $minute = $second = $month = $day = $year = $time = $hourLater = $CI = '';
        
        // Last import
        $import = $this->Main_model->get_imports();

        $hour = date('H', strtotime($import['added']));
        $minute = date('i', strtotime($import['added']));
        $second = date('s', strtotime($import['added']));
        $month = date('m', strtotime($import['added']));
        $day = date('d', strtotime($import['added']));
        $year = date('Y', strtotime($import['added']));
        
        $time = mktime($hour, $minute, $second, $month, $day, $year);
        $hourLater = $time + 3600;
        
        // If last import was later than 1 hour
        if(time() >= $hourLater){
            $CI =& get_instance();
            $CI->load->library("session");
            $autoload['libraries'] = array('session');
            $this->load->library('exports');
            $this->exports->index();
        }
    }    
}
