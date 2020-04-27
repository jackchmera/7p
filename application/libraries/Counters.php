<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* Page counter & offer counter*/
class Counters extends CI_Controller {
    
    protected $CI;
    
    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->model('Counter_model');
    }    
    
    public function counter(){
        if (isset($_COOKIE['cookiecookie']))
        {
              $count = $this->CI->Counter_model->get_count();
        }
        else
        {             
              setcookie('cookiecookie','tresc',time()+900) or die('blad');
              $this->CI->Counter_model->update_count();
              $count = $this->CI->Counter_model->get_count();
        }

        return $count['no'];
    }
}
