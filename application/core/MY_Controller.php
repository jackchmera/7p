<?php 
if ( ! defined('BASEPATH')) 
    exit('No direct script access allowed');

    class MY_Controller extends CI_Controller 
    { 
        //set the class variable.
        public $template  = array();
        public $data      = array();
		
        /*Loading the default libraries, helper, language */
        public function __construct(){
            parent::__construct();
            $this->load->helper(array('form','language','url'));
//            $this->lang->load('polish');
        }
		
        /*Front Page Layout*/
        public function layout() {
            // making template and send data to view.
            $this->template['middle'] = $this->load->view($this->middle, $this->data, true);
            $this->load->view('layout/mainLayout', $this->template);
        }
    }