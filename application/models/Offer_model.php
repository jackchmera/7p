<?php

class Offer_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function get_offer($id) {
        return $this->db->query("SELECT o.*, (SELECT r.name FROM regions r WHERE r.id = o.voivodeships) as voivodeship_name, (SELECT r.name FROM regions r WHERE r.id = o.district) as district_name FROM `offers` o WHERE o.id = ? LIMIT 1", array($id))->row_array();
    }

    function get_user($id) {
        return $this->db->get_where('users', array('id' => $id), 1)->row_array();
    }

    function get_images($offer, $user) {
        return $this->db->get_where('images', array('offer_no' => $offer, 'user' => $user))->result_array();
    }

    function get_image($offer, $user) {
        return $this->db->get_where('images', array('offer_no' => $offer, 'user' => $user), 1)->row_array();
    }

    function get_FTP($user) {
        return $this->db->get_where('ftps', array('user_id' => $user), 1)->row_array();
    }

    function get_banners() {
        return $this->db->get_where('contents', array('name' => 'Banery'), 1)->row_array();
    }

    function count_all_rows() {
        $result = $this->db->query("SELECT COUNT(*) as number FROM `offers`")->row_array();
        return $result['number'];
    }

    function count_pagination($post) {
        
        $this->db->select('COUNT(o.id) as number');
        $this->db->from('offers o');

        // jezeli nie wpisano numeru ogloszenia
        if ($post['no'] == '') {

            $this->db->where('type', $post['type']);
            $this->db->where('rent_sold', $post['rent_sold']);

            if ($post['area_from'] != '') {
                $this->db->where('area >=', $post['area_from']);
                $this->db->or_where('full_area >=', $post['area_from']);
            }

            if ($post['area_to'] != '') {
                $this->db->where('area <=', $post['area_to']);
                $this->db->or_where('full_area <=', $post['area_to']);
            }

            if ($post['voivodeships'] == '0') {
                
            } else {
                $this->db->where('voivodeships', $post['voivodeships']);
            }

            if ($post['district'] == '0') {
                
            } else {
                $this->db->where('district', $post['district']);
            }

            if ($post['price_from'] != '') {
                $this->db->where('price >=', $post['price_from']);
            }

            if ($post['price_to'] != '') {
                $this->db->where('price <=', $post['price_to']);
            }

            if ($post['town'] != '') {
                $this->db->like('town', $post['town']);
            }

            if ($post['no'] != '') {
                $this->db->where('rooms', $post['no']);
            }
        } else { // jezeli wpisano numer ogloszenia
            $this->db->where('no', $post['no']);
        }

        $result = $this->db->get()->row_array();
        
        return $result['number'];
    }
    
    function get_offers_pagination($post, $offset, $sort_type){
        
        $this->db->select('o.*, (SELECT r.name FROM regions r WHERE r.id = o.voivodeships) as voivodeship_name, (SELECT r.name FROM regions r WHERE r.id = o.district) as district_name');
        $this->db->from('offers o');
        
        // jezeli nie wpisano numeru ogloszenia
        if($post['no'] == ''){

            $this->db->where('type', $post['type']);
            $this->db->where('rent_sold', $post['rent_sold']);

            if($post['area_from'] != ''){
                $this->db->where('area >=', $post['area_from']);
                $this->db->or_where('full_area >=', $post['area_from']);
            }

            if($post['area_to'] != ''){
                $this->db->where('area <=', $post['area_to']);
                $this->db->or_where('full_area <=', $post['area_to']);
            }

            if($post['voivodeships'] == '0'){}
            else{
                $this->db->where('voivodeships', $post['voivodeships']);
            }

            if($post['district'] == '0'){}
            else{
                $this->db->where('district', $post['district']);
            }

            if($post['price_from'] != ''){
                $this->db->where('price >=', $post['price_from']);
            }

            if($post['price_to'] != ''){
                $this->db->where('price <=', $post['price_to']);
            }
            
            if($post['town'] != ''){
                $this->db->like('town', $post['town']); 
            }
            
            if($post['no'] != ''){
                $this->db->where('rooms', $post['no']);
            }
        }
        else{ // jezeli wpisano numer ogloszenia
            
            $this->db->where('no', $post['no']);
            
        }
        
         switch($sort_type){
            case '0' : { $this->db->order_by('o.price', 'asc'); break; }
            case '1' : { $this->db->order_by('o.price', 'desc'); break; }
            case '2' : { $this->db->order_by('o.update', 'asc'); break; }
            case '3' : { $this->db->order_by('o.update', 'desc'); break; }
            default : { $this->db->order_by('o.update', 'asc'); break; }
        }
        
        $this->db->limit('10', $offset);
        return $this->db->get()->result_array();
    }
    

    function get_offers_order_by($sort_type, $offset) {
        // Order by
        switch ($sort_type) {
            case '0' : {
                    $order = 'ORDER BY o.price asc';
                    break;
                }
            case '1' : {
                    $order = 'ORDER BY o.price desc';
                    break;
                }
            case '2' : {
                    $order = 'ORDER BY o.update asc';
                    break;
                }
            case '3' : {
                    $order = 'ORDER BY o.update desc';
                    break;
                }
            default : {
                    $order = 'ORDER BY o.update desc';
                    break;
                }
        }
        
        return $this->db->query("SELECT o.*, (SELECT r.name FROM regions r WHERE r.id = o.voivodeships) as voivodeship_name, (SELECT r.name FROM regions r WHERE r.id = o.district) as district_name FROM `offers` o " . $order . " LIMIT " . $this->db->escape(intval($offset)) . ",10")->result_array();
    }

    function offers_search_form($kind, $type, $market, $voivodeship, $district, $town, $pricefrom, $priceto) {

        $this->db->from('offers');

        $this->db->where('kind', $kind);
        $this->db->where('type', $type);
        $this->db->where('market', $market);

        if ($voivodeship == '0') {
            
        } else {
            $this->db->where('voivodeship', $voiodeship);
        }

        if ($district == '0') {
            
        } else {
            $this->db->where('district', $district);
        }

        // upewniamy sie ze nazwa miasta jest poprawnie wpisana
        $test = trim(mb_strtolower($town, 'UTF-8'));

        if ($test == '') {
            
        } else {
            $this->db->where('town', $test);
        }

        // upewniamy sie ze cena jest poprawnie wpisana
        $test2 = trim(mb_strtolower($pricefrom, 'UTF-8'));

        if ($test2 == '') {
            
        } else {
            $this->db->where('price >=', $test);
        }

        // upewniamy sie ze cena jest poprawnie wpisana
        $test3 = trim(mb_strtolower($priceto, 'UTF-8'));

        if ($test3 == '') {
            
        } else {
            $this->db->where('price <=', $test);
        }
    }

}

?>
