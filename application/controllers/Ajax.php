<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* AJAX for SEARCHING FORM and POSTING FORM */
class Ajax extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Main_model');
    }

    /* Districts - search form */
    public function districts() {
        
        // VARIABLES
        $result = $regions = $post = '';
        
        $post = $this->input->post(NULL, TRUE); // Post data
        $regions = $this->Main_model->get_regions_by_voivodeship($post['index']);
        $result .= '<option value="0" selected=selected>Wszystkie</option>';
        foreach ($regions as $key) {
            $result .= '<option value="' . $key['id'] . '">' . $key['name'] . '</option>';
        }
        echo $result;
    }

    /* Districts - posting form */
    public function districts_for_posting() {
        
        // VARIABLES
        $result = $regions = $post = '';
        
        // Post data
        $post = $this->input->post(NULL, TRUE);     /* POST DATA */
        $regions = $this->Main_model->get_regions_by_voivodeship($post['index']);
        foreach ($regions as $key) {
            $result .= '<option value="' . $key['id'] . '">' . $key['name'] . '</option>';
        }
        echo $result;
    }

}
