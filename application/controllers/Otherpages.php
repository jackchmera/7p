<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* Articles & Posts */
class Otherpages extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Main_model');
        $this->load->model('Otherpages_model');
    }

    /* Article */
    public function index($id = '', $underid = '') {
        // Common data for all views
        $this->load->library('common_data');
        $this->data = $this->common_data->index();
        $this->data['id'] = $id;                                                // Article ID
        $this->data['content'] = $this->Otherpages_model->get_content($underid);// Content
        $this->data['title'] = $this->data['content']['name'];                  // Page title
        $this->data['nav'] = $this->Otherpages_model->get_nav($id);             // Navigation
        $this->middle = 'otherpages/otherpages_view';                           // View name
        $this->layout();
    }

    /* Post */
    public function posts($id = '', $underid) {
        // Common data for all views
        $this->load->library('common_data');
        $this->data = $this->common_data->index();
//        $this->data['id'] = $id;                                              // Position ID  - currently not necessary
//        $this->data['underid'] = $underid;                                    // Post ID      - currently not necessary
        $this->data['content'] = $this->Otherpages_model->get_post($underid);   // Content
        $this->data['title'] = $this->data['content']['name'];                  // Page title
        $this->data['nav'] = $this->Otherpages_model->get_posts();              // Navigation
        $this->middle = 'otherpages/posts_view';                                // View name
        $this->layout();
    }

}
