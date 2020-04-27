<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* Offers */

class Offer extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Main_model');
        $this->load->model('Offer_model');
    }

    // Single offer view
    public function index($id) {

        // Is correct id
        if (is_numeric($id)) {
            
        } else {
            redirect('main');
        }
        
        //LIBRARIES
        $this->load->helper('form');
        $this->load->library('form_validation');

        // VARIABLES
        $post = $to = $from = $phone = $content = ''; 
        
        // Common data for all views
        $this->load->library('common_data');
        $this->data = $this->common_data->index();

        // Offer data
        $this->data['offer'] = $this->Offer_model->get_offer($id);

        // Logo img & user data
        $this->data['logo'] = $this->data['user'] = $this->Offer_model->get_user($this->data['offer']['user']);
        
        // Images
        $this->data['offer']['images'] = $this->Offer_model->get_images($this->data['offer']['no'], $this->data['offer']['user']);
        
        // Directory
        $this->data['offer']['ftp'] = $this->Offer_model->get_FTP($this->data['offer']['user']);

        // Convert int to string
        $this->data['offer']['type_name'] = $this->set_type_name($this->data['offer']['type']);

        //If offer hasn't defined phone and e-mail - set default data of contractor
        $this->data['offer'] = $this->alternate_contact_data($this->data['offer']);

        // Page title
        $this->data['title'] = $this->data['offer']['town'] . ' - ' . $this->data['offer']['type_name'] . ' - ' . $this->data['offer']['area'] . ' m2 ';

        // Update offer counter
        $this->counter_offer($this->data['offer']['id']);

        //CONTACT FORM - validation rules
        $this->form_validation->set_rules('mail', 'E-mail', 'required|valid_email|max_length[128]');
        $this->form_validation->set_rules('phone', 'Numer telefonu', 'requiredmax_length[22]');
        $this->form_validation->set_rules('message', 'Wiadomość', 'required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() == FALSE) {} 
        else {
            // Against spambots - instead captcha
            if ($this->input->post('forbots') != '' || $this->input->post('noobsaibot') != 'ążść') {} 
            else {
                $post = $this->input->post(NULL, TRUE);
                $to = $this->data['offer']['mail'];
                $from = $this->post['mail'];
                $phone = $this->post['phone'];
                $content = $this->post['message'] . '<br/>Ogłoszenie: ' . site_url('offer/index/' . $this->data['offer']['id']) . '<br/>Tel.' . @$phone;
//                $this->sendForm($to, $from, $content);
                $this->send_form_nazwa($to, $from, $content);
            }
            $this->data['message_send'] = 'Wiadomość została wysłana';
        }
        $this->middle = 'offer/offer_view';                                     // View name
        $this->layout();
    }

    /* All offers */
    public function offers_all($sort_type = '2', $offset = '0') {

        // VARIABLES
        $rows = '';

        // Common data - all views
        $this->load->library('common_data');
        $this->data = $this->common_data->index();

        // Page title
        $this->data['title'] = 'Oferty nieruchomości';

        // Banners
        $this->data['banners'] = $this->Offer_model->get_banners();

        // Number of pages - pagination
        $rows = $this->Offer_model->count_all_rows();

        // All offers - pagination - this page
        $this->data['offers'] = $this->Offer_model->get_offers_order_by($sort_type, $offset);

        // Other data - offers
        $this->data['offers'] = $this->data_offers($this->data['offers']);

        // Other data - pagination
        $this->data['offset'] = $offset;
        $this->data['method'] = 'wszystkie_oferty';
        $this->data['sort'] = $sort_type;

        // Pagination
        $this->init_pagination($rows, $sort_type, $this->data['method']);
        
        

        $this->middle = 'offer/offers_all_view';                                // View name
        $this->layout();
    }

    /* Offers for search form */
    public function offers_search($sort_type = '2', $offset = '0') {

        // VARIABLES
        $post = $rows = '';
        
        // Common data - all views
        $this->load->library('common_data');
        $this->data = $this->common_data->index();
        
        // Page title
        $this->data['title'] = 'Oferty nieruchomości';

        // Banners
        $this->data['banners'] = $this->Offer_model->get_banners();

        // Post data
        $post = $this->input->post(NULL, TRUE);

        if ($this->input->post('type')) {
            $post = $this->input->post(NULL, TRUE);
            $this->session->set_userdata('search_type', $post['type']);
            $this->session->set_userdata('search_rent_sold', $post['rent_sold']);
            $this->session->set_userdata('search_area_from', $post['area_from']);
            $this->session->set_userdata('seach_area_to', $post['area_to']);
            $this->session->set_userdata('search_voivodeships', $post['voivodeships']);
            $this->session->set_userdata('search_district', $post['district']);
            $this->session->set_userdata('search_price_from', $post['price_from']);
            $this->session->set_userdata('search_price_to', $post['price_to']);
            $this->session->set_userdata('search_no', $post['no']);
            $this->session->set_userdata('search_town', $post['town']);
            redirect('wyszukiwanie');
        } else {
            $post['type'] = $this->session->userdata('search_type');
            $post['rent_sold'] = $this->session->userdata('search_rent_sold');
            $post['area_from'] = $this->session->userdata('search_area_from');
            $post['area_to'] = $this->session->userdata('seach_area_to');
            $post['voivodeships'] = $this->session->userdata('search_voivodeships');
            $post['district'] = $this->session->userdata('search_district');
            $post['price_from'] = $this->session->userdata('search_price_from');
            $post['price_to'] = $this->session->userdata('search_price_to');
            $post['no'] = $this->session->userdata('search_no');
            $post['town'] = $this->session->userdata('search_town');
        }

        // Number of pages - pagination
        $rows = $this->Offer_model->count_pagination($post);

        // All offers - pagination - this page
        $this->data['offers'] = $this->Offer_model->get_offers_pagination($post, $offset, $sort_type);

        // Other data - offers
        $this->data['offers'] = $this->data_offers($this->data['offers']);

        // Other data - pagination
        $this->data['offset'] = $offset;
        $this->data['method'] = 'wyszukiwanie';
        $this->data['sort'] = $sort_type;

        // Pagination
        $this->init_pagination($rows, $sort_type, $this->data['method']);

        $this->middle = 'offer/offers_all_view';                                // View name
        $this->layout();
    }

    /* Generate PDF - offer */
    public function pdf($id) {

        // Is correct id
        if (is_numeric($id)) {
            
        } else {
            redirect('main');
        }
        
        // VARIABLES
        $offer = $content = '';

        // Common data for all views
        $this->load->library('common_data');
        $this->data = $this->common_data->index();
        $offer = array();

        // Page title
        $data['title'] = 'Oferta nieruchomości';

        // Get offer
        $offer = $this->Offer_model->get_offer($id);

        // Images - offer
        $offer['image'] = $this->Offer_model->get_image($offer['no'], $offer['user']);
        
        // Directory
        $offer['ftp'] = $this->Offer_model->get_FTP($offer['user']);

        // Convert int to string
        $offer['type_name'] = $this->set_type_name($offer['type']);

        //If offer hasn't defined phone and e-mail - set default data of contractor
        $offer = $this->alternate_contact_data($offer);

        ob_start();
        // PDF template
        require_once('application/views/offer/offer_view_pdf.php');
        $content = ob_get_clean();

        require_once('application/plugins/MPDF/mpdf.php');
        $mpdf = new MPDF('utf-8', 'A4', 9);
        $mpdf->WriteHTML($content);
        $mpdf->Output('oferta-' . $offer['no'] . '.pdf', 'D');
    }

    /* If offer hasn't defined phone and e-mail - set default data of contractor */
    private function alternate_contact_data($offer) {
        if (empty($offer['agent_tel_kom']) || empty($offer['agent_email'])) {
            $user = $this->Offer_model->get_user($offer['user']);
            if (empty($offer['agent_tel_kom'])) {
                $offer['agent_tel_kom'] = $user['phone'];
            }
            if (empty($offer['agent_email'])) {
                $offer['agent_email'] = $user['mail'];
            }
        }
        return $offer;
    }

    /* Other data - offers */
    private function data_offers($offers) {
        foreach ($offers as $key => $value) {
            $offers[$key]['main_image'] = $this->Offer_model->get_image($value['no'], $value['user']);
            $offers[$key]['ftp'] = $this->Offer_model->get_FTP($value['user']);

            // type oferty slownie
            $offers[$key]['type_name'] = $this->set_type_name($this->data['offers'][$key]['type']);
        }
        return $offers;
    }

    /* Pagination */
    private function init_pagination($rows, $sort_type, $method) {
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'index.php/' . $method . '/' . $sort_type . '/';
        $config['total_rows'] = $rows;
        $config['per_page'] = 10;
        $config['num_links'] = 20;
        $config['uri_segment'] = 3;
        $config['first_link'] = '<button> |< </button> ';
        $config['last_link'] = '<button> >| </button> ';
        $config['next_link'] = '<button> > </button> ';
        $config['prev_link'] = '<button> < </button> ';
        $config['full_tag_open'] = '<div id="pagination">';
        $config['full_tag_close'] = "</div>";
        $config['num_tag_open'] = '<div class="digit">';
        $config['num_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<div class="current">';
        $config['cur_tag_close'] = '</div>';
        return $this->pagination->initialize($config);
    }

    // TYPES - convert word to int
    private function set_type_name($type) {
//        1 - obiekt, 2 - dom, 3 - mieszkanie, 4 - lokal, 5 - dzialka itp
        switch ($type) {
            case '1': {
                    return 'Obiekt komercyjny';
                    break;
                }
            case '2': {
                    return 'Dom';
                    break;
                }
            case '3': {
                    return 'Mieszkanie';
                    break;
                }
            case '4': {
                    return 'Lokal';
                    break;
                }
            case '5': {
                    return 'Działka';
                    break;
                }
            case '6': {
                    return 'Biura';
                    break;
                }
            case '7': {
                    return 'Handel i usługi';
                    break;
                }
            case '8': {
                    return 'Hotele i pensjonaty';
                    break;
                }
            case '9': {
                    return 'Magazyny i hale';
                    break;
                }
            case '10': {
                    return 'Obiekty';
                    break;
                }
            default : {
                    return 'Obiekty';
                    break;
                }
        }
    }

    private function counter_offer($id) {
        $this->load->model('Counter_model');
        $this->Counter_model->update_count_offer($id);
    }

    // Send e-mail - standard
    private function send_form($to, $from, $content) {
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject('Wiadomość dotycząca ogłoszenia nieruchomości.');
        $this->email->message($content);
        $this->email->send();
    }

    // Send e-mail - from nazwa.pl
    private function send_form_nazwa($to, $from, $content) {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <' . $from . '>' . "\r\n";
//        $headers .= 'Cc: myboss@example.com' . "\r\n";
        $subject = "=?UTF-8?B?" . base64_encode("Wiadomość dotycząca ogłoszenia nieruchomości.") . "?=";
//        $subject = 'Wiadomość dotycząca ogłoszenia nieruchomości.';
        mail($to, $subject, $content, $headers);
    }

}
