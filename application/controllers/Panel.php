<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Panel extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Main_model');
        $this->load->model('Panel_model');
    }

    /* Login form */
    public function index() {
        // Only if you are not logged
        if ($this->is_login()) {
            redirect('panel/panel');
        } else {}

        // LIBRARIES
        $this->load->helper('form');
        $this->load->library('form_validation');

        // VARIABLES
        $log = $pass = $login = $post = ''; 
        
        // Common data for all views
        $this->load->library('common_data');
        $this->data = $this->common_data->index();
        $this->data['title'] = 'Zaloguj się';

        //FORM - validation rules
        $this->form_validation->set_rules('pass_login', 'Hasło', 'trim|required|min_length[7]|max_length[64]');
        $this->form_validation->set_rules('mail_login', 'E-mail', 'required|trim|valid_email|max_length[64]');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // VALIDATION
        if ($this->form_validation->run() == FALSE) {
            $this->middle = 'panel/login_view';                                 // View name
            $this->layout();
        } else {
            $post = $this->input->post(NULL, TRUE);
            $log = $post['mail_login'];
            $pass = $post['pass_login'];

            // Login & password
            $login = $this->Panel_model->get_user($log, $pass);
            // Does user exist
            $this->login($login);
        }
    }

    /* Add offer - main view*/
    public function add_offer_main() {
        // Common data for all views
        $this->load->library('common_data');
        $this->data = $this->common_data->index();
        $this->data['title'] = 'Dodaj ofertę';                                  // Page title
        $this->middle = 'panel/add_offer_view';                                 // View name
        $this->layout();
    }
    
    /* Add offer manualy - form */
    public function add_offer($type = '1') {

        if ($this->is_login()) {
            
        } else {
            redirect('panel');
        }

        // LIBRARIES
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // Common data for all views
        $this->load->library('common_data');
        $this->data = $this->common_data->index();
        $this->data['title'] = 'Dodaj ofertę';
        $this->data['type'] = $type;
        
        // Default districts
        $this->data['districts'] = $this->Panel_model->get_districts();


        // FORM - validation rules
        $this->form_validation->set_rules('title', 'Tytuł', 'required|max_length[255]');
        $this->form_validation->set_rules('price', 'Cena', 'required|max_length[9]');
        $this->form_validation->set_rules('area', 'Powierzchnia', 'numeric|max_length[9]');
        $this->form_validation->set_rules('full_area', 'Powierzchnia działki', 'max_length[9]');
        $this->form_validation->set_rules('market', 'Rynek', '');
        $this->form_validation->set_rules('town', 'Miasto', 'required|max_length[255]');
        $this->form_validation->set_rules('street', 'Ulica', 'max_length[255]');
        $this->form_validation->set_rules('voivodeship', 'Województwo', '');
        $this->form_validation->set_rules('district', 'Powiat', '');
        $this->form_validation->set_rules('community', 'Gmina', 'max_length[255]');
        $this->form_validation->set_rules('description', 'Opis', 'required');
        $this->form_validation->set_rules('status', 'Stan wykończenia', '');
        $this->form_validation->set_rules('area_type', 'Typ działki', '');
        $this->form_validation->set_rules('construction_kind', 'Rodzaj działki', '');
        $this->form_validation->set_rules('construction_type', 'Typ działki', '');
        $this->form_validation->set_rules('rooms', 'Pokoje', '');
        $this->form_validation->set_rules('floors', 'Piętra', '');
        $this->form_validation->set_rules('floor', 'Piętro', '');
        $this->form_validation->set_rules('water', 'Woda', '');
        $this->form_validation->set_rules('gas', 'Gaz', '');
        $this->form_validation->set_rules('electric', 'Prąd', '');
        $this->form_validation->set_rules('sewers', 'Kanalizacja', '');
        $this->form_validation->set_rules('hard', 'Dojazd utwardzony', '');
        $this->form_validation->set_rules('soft', 'Dojazd nieutwardzony', '');
        $this->form_validation->set_rules('asfalt', 'Dojazd asfaltowy', '');
        $this->form_validation->set_rules('year', 'Rok budowy', 'numeric|max_length[9]');
//        $this->form_validation->set_rules('person', 'Imię i nazwisko', 'required|max_length[255]');
//        $this->form_validation->set_rules('phone', 'Telefon', 'numeric|max_length[22]');
//        $this->form_validation->set_rules('mail', 'E-mail', 'required|valid_email|max_length[128]');
        $this->form_validation->set_error_delimiters($prefix = '<div class="col-md-12 error">', $suffix = '</div>');

        if ($this->form_validation->run() == FALSE) {
            $this->middle = 'panel/add_offer_form_view'; // its your view name.
            $this->layout();
        } else {

            $post = $this->input->post(NULL, TRUE);
            $post['user'] = $this->session->userdata('login_id');
            
            $this->Panel_model->setNewOffer($post);
            
            redirect('panel/panel');
            
            // przekierowanie do dotpay
        }
    }

    /* Customer panel - main view */
    public function panel($offset = '0') {

        // Only for logged users
        $this->auth();

        //LIBRARIES
        $this->load->library('pagination');

        // VARIABLES
        $rows = $config = $offset = '';
        // Common data for all views
        $this->load->library('common_data');
        $this->data = $this->common_data->index();
        $this->data['title'] = 'Panel klienta';

        // Pages for pagination
        $rows = $this->Panel_model->count_all_rows($this->session->userdata('login_id'));

        // Offers for this page
        $this->data['offers'] = $this->Panel_model->get_offers($offset, $this->session->userdata('login_id'));

        // Other data for offers
        $this->data['offers'] = $this->data_offers($this->data['offers']);

        $config['base_url'] = base_url() . 'index.php/panel/panel/';
        $config['total_rows'] = $rows;
        $config['per_page'] = 10;
        $config['num_links'] = 20;
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

        $this->pagination->initialize($config);

        $this->middle = 'panel/panel_view'; // View name
        $this->layout();
    }

    // Edit userdata
    public function userdata() {

        // Only for logged users
        $this->auth();

        //LIBRARIES
        $this->load->helper('form');
        $this->load->library('form_validation');

        // VARIABLES
        // Common data for all views
        $this->load->library('common_data');
        $this->data = $this->common_data->index();
        $logo = $post = $password = $logoPath = '';
        $this->data['title'] = 'Dane użytkownika';

        $this->data['userdata'] = $this->Panel_model->get_userdata($this->session->userdata('login_id'));

        //FORM - validation rules
        $this->form_validation->set_rules('company', 'Nazwa', 'required|max_length[255]');
        $this->form_validation->set_rules('street', 'Ulica', 'required|max_length[255]');
        $this->form_validation->set_rules('postal', 'Kod pocztowy', 'required|max_length[6]');
        $this->form_validation->set_rules('town', 'Miejscowość', 'required|max_length[255]');
        $this->form_validation->set_rules('phone', 'Tel.', 'required|max_length[22]');
        $this->form_validation->set_rules('nip', 'NIP', 'min_length[10]|max_length[13]');
        $this->form_validation->set_rules('password', 'Hasło', 'max_length[255]');
        $this->form_validation->set_rules('repeat', 'Powtórz hasło', 'max_length[255]|matches[password]');
        $this->form_validation->set_rules('img1', 'Logo', '');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() == FALSE) {
            $this->middle = 'panel/userdata_view'; // View name
            $this->layout();
        } else {

            if (!file_exists($_FILES['img1']['tmp_name']) || !is_uploaded_file($_FILES['img1']['tmp_name'])) {
//                echo 'No upload';
            } else {
                $logo = $this->add_picture('img1');
                $logoPath = base_url() . 'photos/' . $logo;
                $this->Panel_model->update_logo($logoPath, $this->session->userdata('login_id'));
                // Get new logo for session var
                $this->session->set_userdata('logo', $logoPath);
            }

            // Change password
            $post = $this->input->post(NULL, TRUE);
            if (!empty($post['password'])) {
                $password = $this->set_password(trim($post['password']));
                $this->Panel_model->update_password($password['password'], $password['salt'], $this->session->userdata('login_id'));
            } else {
                
            }

            $this->middle = 'panel/userdata_view'; // View name
            $this->layout();
        }
    }

    // E-mail to admin - user would like create imports and need ftp
    public function ftp() {

        // Only for logged users
        $this->auth();

        // Common data for all views
        $this->load->library('common_data');
        $this->data = $this->common_data->index();

        // tutaj moglby sprawdzac czy juz bylo wyslane zadanie utworzenia konta wymiany danych, ale moze ktos bedzie chcial kilka razy
        // wiec w tej chwili pozostaje to bez zastosowania
        // wyslanie wiadomosci do pgn, ze zadanie zostalo zgloszone - istnieje ryzyko, ze na nazwie ta funkcja nie dziala
        // 
        // tresc wiadomosci

        $content = "Witam,<br/>Proszę o utworzenie konta wymiany danych dla:" . $this->session->userdata('login');

        $this->send_email($this->session->userdata('login'), 'andrzej@kgn.pl', $content);

        $this->middle = 'panel/ftp_view';                                       // View name
        $this->layout();
    }

    // Payment
    public function payment() {

        // Only for logged users
        $this->auth();

        $this->load->model('Panel_model');

        // Common data for all views
        $this->load->library('common_data');
        $this->data = $this->common_data->index();
        $this->data['title'] = 'Płatność';

        // data waznosci konta
        $this->data['user'] = $this->Panel_model->get_userdata($this->session->userdata('login_id'));

        //sprawdza czy konto jest oplacone - aktywne
        if (new DateTime() < new DateTime($this->data['user']['active'])) {
            $this->data['user']['notActive'] = FALSE;
        } else {
            $this->data['user']['notActive'] = TRUE;

//              generuje linki do platnosci
//              $link = 'https://ssl.dotpay.pl/?id=341343&kwota=';
//              $other = $cart['amount'] + $this->data['delivery_cost'].'&opis=Le Manuell - chemia z Niemiec&control='.$this->session->userdata('login').'&email='.$this->session->userdata('login').'&urlc=http://www.lemanuell.pl/index.php/delivery/thx';
        }

        $this->middle = 'panel/payment_view'; // View name
        $this->layout();
    }

    /* Login form - captcha */
    public function captcha() {

        // LIBRARIES
        $this->load->library('form_validation');
        $this->load->helper(array('captcha', 'form'));
        
        // VARIABLES
        $post = $userCaptcha = $word = $log = $pass = '';
        
        // Common data for all views
        $this->load->library('common_data');
        $this->data = $this->common_data->index();

        // Page title
        $this->data['title'] = 'Logowanie';                             

        // FORM - validation rules
        $this->form_validation->set_rules('pass_login', 'Hasło', 'trim|required|min_length[9]|max_length[64]');
        $this->form_validation->set_rules('mail_login', 'E-mail', 'required|trim|valid_email|min_length[5]|max_length[64]');
        $this->form_validation->set_rules('captcha', "Captcha", 'required');

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $post = $this->input->post(NULL, TRUE);
        $userCaptcha = $post['captcha'];

        // Get the actual captcha value that we stored in the session
        $word = $this->session->userdata('captchaWord');

        // Check if form passed validation 
        if ($this->form_validation->run() == TRUE && strcmp(strtoupper($userCaptcha), strtoupper($word)) == 0) {

            $this->load->model('Panel_model');

            $log = $post['mail_login'];
            $pass = $post['pass_login'];

            // Login & password
            $logowanie = $this->Panel_model->get_user($log, $pass);
            // Does user exist
            $this->login($logowanie);
        } else {

            /* Validation was not successful - Generate a captcha 
               Setup vals to pass into the create_captcha function */
            $captcha = array(
                'word' => rand(10000, 999999),
                'img_path' => './captcha/',
                'img_url' => base_url() . 'captcha/',
                'expiration' => '3600',
//                'font_path' => './fonts/impact.ttf',
                'img_width' => '100%',
                'img_height' => '80px',
            );

            // Generate the captcha 
            $img = create_captcha($captcha);
            $this->data['image'] = $img['image'];

            // Store the captcha value in a session to retrieve later 
            $this->session->set_userdata('captchaWord', $img['word']);

            $this->data['error'] = '<div class="error">Niepoprawny login lub hasło</div>';

            $this->middle = 'panel/login_captcha_view';                         // View name
            $this->layout();
        }
    }

    public function remember() {

        // Common data for all views
        $this->load->library('common_data');
        $this->data = $this->common_data->index();

        $this->data['title'] = 'Przypomnienie hasła';

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('mail', 'E-mail', 'required|valid_email|min_length[5]|max_length[128]');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() == FALSE) {
            $this->middle = 'panel/remember_view';                         // View name
            $this->layout();
        } else {
            $post = $this->input->post(NULL, TRUE);

            // sprawdza czy mail jest w bazie
            $mail = $this->db->get_where('users', array('mail' => $post['mail']), '1')->row_array();

            // jezeli nie ma takiego maila
            if (empty($mail)) {
                $this->data['error'] = '<div class="error">Podanego adresu e-mail nie ma w naszej bazie danych.</div>';

//                $this->load->view('panel/remember_failed_view', $this->data);
                
                $this->middle = 'panel/remember_failed_view';                         // View name
                $this->layout();
            
                return 0;
            } else {

                $this->load->helper('string');
                
                // Set pasword
                $random = random_string('alnum', 9);

                // Generate hash & salt
                $r = $this->set_password($random);

                $post['pass'] = $r['password'];
                $post['salt'] = $r['salt'];

                $title = 'Przypomnienie hasła - DOM PGN';
                $from = 'kgn@kgn.pl';
                $to = $mail['mail'];
                $content = 'Witaj,<br/><br/>Zostało wygenerowane nowe hasło dla twojego konta.<br/><br/>Hasło: ' . $random;
                
                // Send e-mail
                $this->send_mail($from, $to, $title, $content);

                // Update user data
                $this->Panel_model->set_new_password(array('password' => $post['pass'], 'salt' => $post['salt']), array('mail' => $post['mail']));

                $this->middle = 'panel/remember_success_view'; // its your view name.
                $this->layout();
            }
        }
    }
    
    // If isn't logged, go back to main page
    private function auth(){
        
        if ($this->is_login()) {} 
        else {
            redirect('main/index');
        }
        
    }

    // Other data - offers
    private function data_offers($offers) {
        $this->load->model('Offer_model');
        foreach ($offers as $key => $value) {
            $offers[$key]['main_image'] = $this->Offer_model->get_image($value['no'], $value['user']);
            $offers[$key]['ftp'] = $this->Offer_model->get_FTP($value['user']);

            // type oferty slownie
            $offers[$key]['type_name'] = $this->set_type_name($this->data['offers'][$key]['type']);
        }
        return $offers;
    }

    // ustawienie hasla, ta funkcja dziala
    private function set_password($pass32) {
        $return['salt'] = $salt = time();
        $return['password'] = $password = md5($salt . $pass32 . md5('Lolek'));
        return $return;
    }

    private function generate_new_pass($mail) {
        $salt = time();
        $pass32 = md5(time() . 'Lolek'); // hasło które musi wpisać użytkownik
        $password = md5($salt . $pass32 . md5($salt));   // to hasło po zahashowaniu
        // nowe hasło do db
        $this->Main_model->set_new_mail($mail, $password, $salt);

        ////////// USTAWIENIA //////////
        $email = $mail; // Adres e-mail adresata  dtp@hot.pl
        $subject = 'Strona internetowa dla firmy - nowe hasło'; // Temat listu
        $message = ''; // Komunikat
        $error = 'Wystąpił błąd podczas wysyłania formularza'; // Komunikat błędu
        $charset = 'UTF-8'; // Strona kodowa
        //////////////////////////////

        $head = "Reply-to: biuro@helloworld.com.pl <biuro@helloworld.com.pl>" . PHP_EOL .
                "From: biuro@helloworld.com.pl <biuro@helloworld.com.pl>" . PHP_EOL .
                "MIME-Version: 1.0\r\n" .
                "Content-Type: text/html; charset=$charset\r\n" .
                "Content-Transfer-Encoding: 8bit";

        $body = "Na proźbę użtytkownika zostało wygenerowane nowe hasło dla systemu zarządzania treścią. <br />
                 <br /> <b>HASŁO:</b>" . $pass32 . "<br /><br /> Przypominamy, że hasło można zmienić, po zalogowaniu się do systemu
                 (zalecane)<br /><br /> Jeżeli nie prosiłeś/aś o wygenerowanie nowego hasła, poinformuj o fakcie otrzymania tego
                 maila administratora systemu.<br /><br />
                 Z uszanowanie,<br /> <b>zespół PGN</b>";

        echo mail($email, "=?$charset?B?" . base64_encode($subject) . "?=", $body, $head) ? $message : $error;
    }

    private function is_login() {
        if ($this->session->userdata('login')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function is_loged() {
        if (@$this->session->userdata('login')) {
            return TRUE;
        } else {
            redirect(site_url('panel/index'));
        }
    }

    private function login($logowanie) {
        
         // Common data for all views
//        $this->load->library('common_data');
//        $this->data = $this->common_data->index();
//        $this->data['title'] = 'Logowanie';

        // If user doesn't exist
        if (empty($logowanie)) {

            if ($_POST || $this->session->userdata('captchaWord')) {

                $this->load->helper('captcha');

                /** Validation was not successful - Generate a captcha * */
                $captcha = array(
                    'word' => rand(10000, 999999),
                    'img_path' => './captcha/',
                    'img_url' => base_url() . 'captcha/',
                    'expiration' => '3600',
//                'font_path' => './fonts/impact.ttf',
                    'img_width' => '100%',
                    'img_height' => '80px',
                );

                /* Generate the captcha */
                $img = create_captcha($captcha);
                $this->data['image'] = $img['image'];

                $this->session->set_userdata('captchaWord', $img['word']);

                $this->data['error'] = '<div class="error">Niepoprawny login lub hasło</div>';

                $this->middle = 'panel/login_captcha_view';                     // View name
                $this->layout();
            } else {
                $this->middle = 'panel/login_view';                     // View name
                $this->layout();                
            }
        } else {

            // User exist - successfull
            $this->session->set_userdata('login', $this->input->post('mail_login'));
            $this->session->set_userdata('login_id', $logowanie['id']);
            $this->session->set_userdata('logo', $logowanie['logo']);

            redirect(site_url('panel/panel'));
        }
    }

    /* Logout */
    public function logout() {
        $this->session->unset_userdata('login');
        $this->session->unset_userdata('login_id');
        $this->session->sess_destroy();
        header('Location: ' . site_url('main'));
    }

    // Convert int to string
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
        }
    }

    // Send e-mail
    public function send_email($from, $to, $content) {
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->from($from, 'PGN.PL');
        $this->email->to($to);
        $this->email->subject('PGN.PL - konto wymiany danych');
        $this->email->message($content);
        $this->email->send();
    }

    /* Add one picture */
    private function add_picture($img) {

        $img_min = '';

        $max_width = 100;
        $max_height = 100;
        $max_widthbig = 600;
        $max_heightbig = 600;

        $img_path = $_FILES[$img]['tmp_name'];

        if (!file_exists($img_path)) {
            return false;
        }

        $ext = pathinfo($_FILES[$img]['name']);

        $los = rand(0, 99999);

        $ext['extension'] = strtolower($ext['extension']);

        $thumb_path = $img_min . "s" . md5(time()) . $los . '.' . $ext['extension'];       // w products i w images ta sama wartosc  
        $thumb_pathbig = $img_min . md5(time()) . $los . '.' . $ext['extension'];

        $img_attr = getimagesize($img_path);

        if ($img_attr[0] > $img_attr[1]) {
            $scale = $img_attr[0] / $max_width;
            $scalebig = $img_attr[0] / $max_widthbig;
        } else {
            $scale = $img_attr[1] / $max_height;
            $scalebig = $img_attr[1] / $max_heightbig;
        }

        $w = floor($img_attr[0] / $scale);
        $h = floor($img_attr[1] / $scale);
        $wbig = floor($img_attr[0] / $scalebig);
        $hbig = floor($img_attr[1] / $scalebig);
        $thumb = imagecreatetruecolor($w, $h);
        $thumbbig = imagecreatetruecolor($wbig, $hbig);

        if ($ext['extension'] == 'jpg' || $ext['extension'] == 'jpeg') {

            imagecopyresampled($thumb, imagecreatefromjpeg($img_path), 0, 0, 0, 0, $w, $h, $img_attr[0], $img_attr[1]);
            imagecopyresampled($thumbbig, imagecreatefromjpeg($img_path), 0, 0, 0, 0, $wbig, $hbig, $img_attr[0], $img_attr[1]);

            try {
                if (!imagejpeg($thumb, './photos/' . $thumb_path, 80)) {
                    throw new Exception('DODANIE obrazu nie powiodło się.');
                };
                if (!imagejpeg($thumbbig, './photos/' . $thumb_pathbig, 80)) {
                    throw new Exception('DODANIE obrazu nie powiodło się.');
                }
            } catch (Exception $e) {
                
            }
        } elseif ($ext['extension'] == 'png') {

            imagecopyresampled($thumb, imagecreatefrompng($img_path), 0, 0, 0, 0, $w, $h, $img_attr[0], $img_attr[1]);

            // remove black background and make transparency
            imagealphablending($thumbbig, FALSE);
            imagesavealpha($thumbbig, TRUE);
            imagecopyresampled($thumbbig, imagecreatefrompng($img_path), 0, 0, 0, 0, $wbig, $hbig, $img_attr[0], $img_attr[1]);

            try {
                if (!imagepng($thumb, './photos/' . $thumb_path, 9)) {
                    throw new Exception('DODANIE obrazu nie powiodło się.');
                };
                if (!imagepng($thumbbig, './photos/' . $thumb_pathbig, 9)) {
                    throw new Exception('DODANIE obrazu nie powiodło się.');
                }
            } catch (Exception $e) {
                
            }
        } elseif ($ext['extension'] == 'gif') {

            imagecopyresampled($thumb, imagecreatefromgif($img_path), 0, 0, 0, 0, $w, $h, $img_attr[0], $img_attr[1]);
            imagecopyresampled($thumbbig, imagecreatefromgif($img_path), 0, 0, 0, 0, $wbig, $hbig, $img_attr[0], $img_attr[1]);

            try {
                if (!imagegif($thumb, './photos/' . $thumb_path, 80)) {
                    throw new Exception('DODANIE obrazu nie powiodło się.');
                };
                if (!imagegif($thumbbig, './photos/' . $thumb_pathbig, 80)) {
                    throw new Exception('DODANIE obrazu nie powiodło się.');
                }
            } catch (Exception $e) {
                
            }
        } else {
            return false;
        }
        return $thumb_pathbig;
    }
    
    // Send new password
    private function send_mail($from, $to, $title, $content){
        
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <' . $from . '>' . "\r\n";
//        $headers .= 'Cc: myboss@example.com' . "\r\n";
        $subject = "=?UTF-8?B?" . base64_encode($title) . "?=";
//        $subject = 'Wiadomość dotycząca ogłoszenia nieruchomości.';
        mail($to, $subject, $content, $headers);
        
    }

    // Response - electronical payment - DotPay
    public function confirmDotpay() {

        $PIN = "RUDLy92JjvhBvRQJxs9tU7xBNGGvwDHm";
        $sign = $PIN
                . $_POST['id']
                . $_POST['operation_number']
                . $_POST['operation_type']
                . $_POST['operation_status']
                . $_POST['operation_amount']
                . $_POST['operation_currency']
                . $_POST['operation_withdrawal_amount']
                . $_POST['operation_commission_amount']
                . $_POST['operation_original_amount']
                . $_POST['operation_original_currency']
                . $_POST['operation_datetime']
                . $_POST['operation_related_number']
                . $_POST['control']
                . $_POST['description']
                . $_POST['email']
                . $_POST['p_info']
                . $_POST['p_email']
                . $_POST['credit_card_issuer_identification_number']
                . $_POST['credit_card_masked_number']
                . $_POST['credit_card_brand_codename']
                . $_POST['credit_card_brand_code']
                . $_POST['credit_card_id']
                . $_POST['channel']
                . $_POST['channel_country']
                . $_POST['geoip_country'];

        $signature = hash('sha256', $sign);

        if ($signature == $_POST['signature']) {
            echo 'OK';
//            $this->load->database('default');
//            $post = $this->input->post(NULL, TRUE);
            $data = array(
                'id' => $_POST['id'],
                'status' => $_POST['operation_status'],
                'control' => $_POST['control'],
                't_id' => $_POST['operation_number'],
                'amount' => $_POST['operation_amount'],
                //'oryginal_amount' => $post['oryginal_amount'],
                'email' => $_POST['email']
            );

            // zapis danych o transakcji
            $this->db->insert('transactions', $data);

            //aktywowanie konta
            $effectiveDate = date('Y-m-d h:i:s', strtotime("+3 months", strtotime($effectiveDate)));
            $this->db->update('users', array('active' => $effectiveDate), array('id' => $_POST['control'], 'mail' => $_POST['email']));
        }
    }

}
