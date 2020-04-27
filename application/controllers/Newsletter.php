<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Newsletter extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Main_model');
    }

    public function index() {
        // Common data for all views
        $this->load->library('common_data');
        $this->data = $this->common_data->index();
        $this->data['title'] = 'Biuletyn PGN';                  // Page title
        $this->middle = 'newsletter/newsletter_success_view';   // View name
        $this->layout();
    }
}
