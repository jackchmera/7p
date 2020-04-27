<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* Register */
class Register extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Main_model');
        $this->load->model('Register_model');
    }

    /* Main view */
    public function index() {
        // Common data for all views
        $this->load->library('common_data');
        $this->data = $this->common_data->index();
        $this->data['title'] = 'Rejestracja';                                   // Page title
        $this->middle = 'register/register_view';                               // View name
        $this->layout();
    }

    // Registration form - $type - user type;
    // type: 1 - individual, 2 - agency, 3 - developer
    public function form($type = '1') {

        // LIBRARIES
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // VARIABLES
        $post = $inserted_row = $r = $prefix = $suffix = '';
        
        // Common data for all views
        $this->load->library('common_data');
        $this->data = $this->common_data->index();
        $this->data['title'] = 'Rejestracja';                                   // Page title
        $this->data['type'] = $type;                                            // User type

        // FORM - validation rules
        $this->form_validation->set_rules('type', 'Ukryta', '');
        $this->form_validation->set_rules('mail', 'E-mail', 'required|valid_email|max_length[128]');
        $this->form_validation->set_rules('password', 'Hasło', 'required|min_length[7]|max_length[255]');
        $this->form_validation->set_rules('confirm_password', 'Powtórz hasło', 'required|matches[password]');
        $this->form_validation->set_rules('street', 'Ulica i numer', 'required|max_length[255]');
        $this->form_validation->set_rules('town', 'Miejscowość', 'required|max_length[255]');
        $this->form_validation->set_rules('postal', 'Kod pocztowy', 'required|max_length[6]');
        $this->form_validation->set_rules('name', 'Imię i nazwisko', 'required|max_length[255]');
        $this->form_validation->set_rules('phone', 'Numer telefonu', 'required|max_length[22]');
        $this->form_validation->set_rules('check1', 'Akceptacja', 'required');
        $this->form_validation->set_rules('check2', 'Akceptacja', 'required');

        // Fields only for agency and developer
        if ($type != '1') {
            $this->form_validation->set_rules('company', 'Nazwa firmy', 'required|max_length[255]');
            $this->form_validation->set_rules('license', 'Numer licencji', 'max_length[45]');
            $this->form_validation->set_rules('nip', 'NIP', 'required|max_length[13]');
        }

        $this->form_validation->set_error_delimiters($prefix = '<div class="col-md-12 error">', $suffix = '</div>');

        if ($this->form_validation->run() == FALSE) {
            $this->middle = 'register/register_form_view';                      // View name
            $this->layout();
        } else {
            $post = $this->input->post(NULL, TRUE);
            unset($post['confirm_password']);

            $r = $this->set_password($post['password']);

            $post['password'] = $r['password'];
            $post['salt'] = $r['salt'];

            // Insert new user
            $inserted_row = $this->Register_model->set_user($post);

            // Inserting e-mail to `ftps` table - imports
            $this->Register_model->set_FTP($inserted_row, $post['mail']);

            $this->middle = 'register/register_form_success_view';              // View name
            $this->layout();
        }
    }

    /* Generate password for new user */
    private function set_password($pass32) {
        $return['salt'] = $salt = time();
        $return['password'] = $password = md5($salt . $pass32 . md5('Lolek'));
        return $return;
    }

}
