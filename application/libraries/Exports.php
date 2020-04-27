<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* Parsing XML and imports offers */
class Exports extends CI_Controller {
    
    protected $CI;

    public function __construct()
    {
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
    }

    public function index() {
        
        $autoload['libraries'] = array('session');
        $this->CI->load->model('Otherpages_model');

        // Get FTP accounts
        $ftps = $this->CI->db->get('ftps')->result_array();
        
        foreach ($ftps as $key) {

            // List directories
            $dir = 'imports/' . $key['directory'];
            $files = $this->scan_dir($dir);
            
            foreach ($files as $file) {

                $user = $key['user_id'];
                $re = '/(oferty_([0-9]{4}-[0-9]{2}-[0-9]{2})\.zip)/';

                    // Unzipe file into temporary directory - check is it full import or diferential
                    $this->unzip($key['directory'], $file, 'temporary');
                    
                    // Check is it full import or diferential
                    $type = $this->check_export($key['directory']);                  
                    
                    // Full import or diferential
                    if($type=='roznica'){
                        
                        // Unzipe
                        $this->unzip($key['directory'], $file, 'unziped');
                        
                        // Parsing XML
                        $this->get_differential($key['directory'], $file, $user);
                        
                    }
                    else{
                        
                        // Delete all offers
                        $this->CI->db->delete('offers', array('user'=>$user));
                        $this->CI->db->delete('images', array('user'=>$user));
                        
                        // unzip
                        $this->rrmdir('imports/' . $key['directory'] . '/unziped');
                        $this->unzip($key['directory'], $file, 'unziped');
                        
                        // Parsing xml & save
                        $this->get_offer($key['directory'], $file, $user);
                        
                    }
                    
                    // Delete temporary directory
                    $this->rrmdir('imports/' . $key['directory'] . '/temporary');
                    
                    // Move directory to archive
                    rename('imports/'.$key['directory'].'/'.$file, 'imports/'.$key['directory'].'/archiwum/'.$file);
                
            }
        }
    }
    
    // Full export or diferential
    private function check_export($ftp){
        $xmlObject = simplexml_load_file('./imports/' . $ftp . '/temporary/oferty.xml');
        return $header['content'] = $xmlObject->header->zawartosc_pliku;
    }
    
    // Diferential
    public function get_differential($ftp, $file, $user) {

        $xmlObject = simplexml_load_file('./imports/' . $ftp . '/unziped/oferty.xml');

        // Save import info
        $user_id = $user;

        $header['user_id'] = $user_id;
        $header['info'] = $xmlObject->header->informacje;
        $header['agency'] = $xmlObject->header->agencja;
        $header['time'] = $xmlObject->header->data;
        $header['version'] = $xmlObject->header->wersja;
        $header['target'] = $xmlObject->header->cel;
        $header['content'] = $xmlObject->header->zawartosc_pliku;

        $offers_to_insert = array();
        $offers_to_insert['user'] = $user_id;

        // insert to db
        $this->CI->db->insert('imports', $header);

        foreach ($xmlObject->lista_ofert as $key) {

            foreach ($key->dzial as $value) {
                
                // Delete offer
                foreach ($value->oferta_usun as $usun) {
                    $this->CI->db->delete('offers', array('user'=>$user, 'no'=>$usun->id));
                }

                // Set types
                $offers_to_insert['rent_sold'] = $this->set_rent_sold($value->attributes()->typ);
                $offers_to_insert['type'] = $this->set_type($value->attributes()->tab);

                foreach ($value->oferta as $offer) {

                    // offer no
                    $offers_to_insert['no'] = $offer->id;

                    // price
                    $offers_to_insert['price'] = $offer->cena[0];

                    // price / m2
                    $offers_to_insert['pricem2'] = $offer->cenam2[0];


                    foreach ($offer->param as $a) {

                        if ($a->attributes()->nazwa == 'opis') {

                            $opis = '';

                            foreach ($a->linia as $linie) {

                                $opis .= $linie . '</br>';
                            }

                            $o = $this->set_value($a->attributes()->nazwa, $opis);
                        } 
                        elseif($a->attributes()->nazwa == 'typlokalu'){
                            
                            // Overwrite general type
                            $offers_to_insert['type'] = $this->set_underType($a[0]);
                            
                        }
                        else {
                            // Result
                            $o = $this->set_value($a->attributes()->nazwa, $a[0]);
                        }

                        $offers_to_insert = array_merge($offers_to_insert, $o);
                    }

                    foreach ($offer->location->area as $b) {
                        $o = $this->set_location($b->attributes()->type, $b[0]);
                        $offers_to_insert = array_merge($offers_to_insert, $o);
                    }

                     $this->CI->db->update('offers', $offers_to_insert, array('no'=> $offers_to_insert['no'], 'user' => $user_id));
                     
                     // Clear data
                     unset($offers_to_insert);
                     $offers_to_insert['user'] = $user_id;
                     $offers_to_insert['rent_sold'] = $this->set_rent_sold($value->attributes()->typ);
                     $offers_to_insert['type'] = $this->set_type($value->attributes()->tab);
                     
                }
            }
        }

        // Images
        $images = Exports::xml2array($xmlObject);

        // Save images
        foreach ($images['zdjecia']['zdjecie'] as $key) {
            $insert['offer_no'] = $key['id'];
            $insert['typ'] = $key['typ'];
            $insert['sprzedaz'] = $key['sprzedaz'];
            $insert['kolejnosc'] = $key['kolejnosc'];
            $insert['akcja'] = $key['akcja'];
            $insert['name'] = $key['nazwa'];
            $insert['user'] = $user_id;
            $this->CI->db->insert('images', $insert);
        }

    }

    /* Full import */
    public function get_offer($ftp, $file, $user) {

        $xmlObject = simplexml_load_file('./imports/' . $ftp . '/unziped/oferty.xml');

        // Import info
        $user_id = $user;
        $header['user_id'] = $user_id;
        $header['info'] = $xmlObject->header->informacje;
        $header['agency'] = $xmlObject->header->agencja;
        $header['time'] = $xmlObject->header->data;
        $header['version'] = $xmlObject->header->wersja;
        $header['target'] = $xmlObject->header->cel;
        $header['content'] = $xmlObject->header->zawartosc_pliku;
        $offers_to_insert = array();
        $offers_to_insert['user'] = $user_id;
        $this->CI->db->insert('imports', $header);

        foreach ($xmlObject->lista_ofert as $key) {

            foreach ($key->dzial as $value) {

                // Set type
                $offers_to_insert['rent_sold'] = $this->set_rent_sold($value->attributes()->typ);
                $offers_to_insert['type'] = $this->set_type($value->attributes()->tab);

                foreach ($value->oferta as $offer) {

                    // Offer no
                    $offers_to_insert['no'] = $offer->id;

                    // Price
                    $offers_to_insert['price'] = $offer->cena[0];

                    // Price / m2
                    $offers_to_insert['pricem2'] = $offer->cenam2[0];


                    foreach ($offer->param as $a) {

                        if ($a->attributes()->nazwa == 'opis') {

                            $opis = '';

                            foreach ($a->linia as $linie) {

                                $opis .= $linie . '</br>';
                            }

                            $o = $this->set_value($a->attributes()->nazwa, $opis);
                        } 
                        elseif($a->attributes()->nazwa == 'typlokalu'){
                            // Overwrite general type
                            $offers_to_insert['type'] = $this->set_underType($a[0]);
                        }
                        else {

                            // Result
                            $o = $this->set_value($a->attributes()->nazwa, $a[0]);
                        }

                        $offers_to_insert = array_merge($offers_to_insert, $o);
                    }

                    foreach ($offer->location->area as $b) {
                        $o = $this->set_location($b->attributes()->type, $b[0]);
                        $offers_to_insert = array_merge($offers_to_insert, $o);
                    }

                     $this->CI->db->insert('offers', $offers_to_insert);
                     
                     // Clear array
                     unset($offers_to_insert);
                     $offers_to_insert['user'] = $user_id;
                     $offers_to_insert['rent_sold'] = $this->set_rent_sold($value->attributes()->typ);
                     $offers_to_insert['type'] = $this->set_type($value->attributes()->tab);
                }
            }
        }

        // Images
        $images = $this->xml2array($xmlObject);

        // Save images to db table
        foreach ($images['zdjecia']['zdjecie'] as $key) {
            $insert['offer_no'] = $key['id'];
            $insert['typ'] = $key['typ'];
            $insert['sprzedaz'] = $key['sprzedaz'];
            $insert['kolejnosc'] = $key['kolejnosc'];
            $insert['akcja'] = $key['akcja'];
            $insert['name'] = $key['nazwa'];
            $insert['user'] = $user_id;
            $this->CI->db->insert('images', $insert);
        }

    }

    function xml2array($xmlObject, $out = array()) {
        foreach ((array) $xmlObject as $index => $node)
            $out[$index] = ( is_object($node) || is_array($node) ) ? Exports::xml2array($node) : $node;

        return $out;
    }

    // Unzip
    private function unzip($ftp, $file, $to) {
        $zip = new ZipArchive;
        $res = $zip->open('imports/' . $ftp . '/' . $file);
        if ($res === TRUE) {
            $zip->extractTo('imports/' . $ftp . '/'.$to);
            $zip->close();
        } else {
        }
    }

    // Convert string to int
    private function set_rent_sold($typ) {

        switch ($typ) {

            case 'sprzedaz' : {
                    $result = '1';
                    break;
                }
            case 'wynajem' : {
                    $result = '0';
                    break;
                }return $result;
        }

        return $result;
    }

    // Test
    private function testowa($tab) {

        switch ($tab) {

            case 'komercyjne' : {
                    $result = '1';
                    break;
                }
            case 'domy' : {
                    $result = '2';
                    break;
                }
            case 'mieszkania' : {
                    $result = '3';
                    break;
                }
            case 'lokale' : {
                    $result = '4';
                    break;
                }
            case 'dzialki' : {
                    $result = '5';
                    break;
                }
            case 'pokoje' : {
                    $result = '6';
                    break;
                }
        }
    }

    // Convert string to int 
    private function set_type($tab) {

        switch ($tab) {
            case 'domy' : {
                    $result = '2';
                    break;
                }
            case 'mieszkania' : {
                    $result = '3';
                    break;
                }
            case 'lokale' : {
                    $result = '4';
                    break;
                }
            case 'dzialki' : {
                    $result = '5';
                    break;
                }
            case 'pokoje' : {
                    $result = '6';
                    break;
                }
            default : {
                    $result = '1';
                    break;
            }
        }

        return $result;
    }
    
    private function set_underType($tab) {
        
        $explode = explode(' ', trim($tab));
        
        switch ($explode[0]) {

            case 'biura' : {
                    $result = '6';
                    break;
                }
            case 'handel' : {
                    $result = '7';
                    break;
                }
            case 'hotele' : {
                    $result = '8';
                    break;
                }
            case 'magazyny' : {
                    $result = '9';
                    break;
                }
            case 'obiekty' : {
                    $result = '10';
                    break;
                }
            default : {
                    $result = '10';
                    break;
            }
                
        }

        return $result;
    }

    // Converting data
    public function set_value($name, $value) {

        $offers_to_insert = array();

        switch ($name) {

            case 'internet': {
                    $offers_to_insert['internet'] = $this->boolean2enum($value);
                    break;
                }
            case 'liczbapokoi': {
                    $offers_to_insert['rooms'] = $value;
                    break;
                }
            case 'powierzchnia': {
                    $offers_to_insert['area'] = $value;
                    break;
                }
            case 'powierzchniadzialki': {
                    $offers_to_insert['full_area'] = $value;
                    break;
                }
            case 'ulica': {
                    $offers_to_insert['street'] = $value;
                    break;
                }
            case 'winda': {
                    $offers_to_insert['lift'] = $this->boolean2enum($value);
                    break;
                }
            case 'agent_email': {
                    $offers_to_insert['agent_email'] = $value;
                    break;
                }
            case 'agent_nazwisko': {
                    $offers_to_insert['agent_name'] = $value;
                    break;
                }
            case 'agent_tel_biuro': {
                    $offers_to_insert['agent_tel_office'] = $value;
                    break;
                }
            case 'agent_tel_kom': {
                    $offers_to_insert['agent_tel_kom'] = $value;
                    break;
                }
            case 'przetarg': {
                    $offers_to_insert['auction'] = $this->boolean2enum($value);
                    break;
                }
            case 'termin_przetargu': {
                    $offers_to_insert['auction_term'] = $value;
                    break;
                }
            case 'vadium': {
                    $offers_to_insert['vadium'] = $value;
                    break;
                }
            case 'dataaktualizacji': {
                    $offers_to_insert['update'] = $value;
                    break;
                }
            case 'bezprowizji': {
                    $offers_to_insert['provision'] = $this->boolean2enum($value);
                    break;
                }
            case 'forma_wlasnosci': {
                    $offers_to_insert['owner'] = $value;
                    break;
                }
            case 'sprzedane': {
                    $offers_to_insert['sold'] = $this->boolean2enum($value);
                    break;
                }
            case 'datawprowadzenia': {
                    $offers_to_insert['added'] = $value;
                    break;
                }
            case 'opis': {
                    $offers_to_insert['description'] = $value;
                    break;
                }
            case 'gaz': {
                    $offers_to_insert['gas'] = $this->text2enum($value);
                    break;
                }
            case 'kanalizacja': {
                    $offers_to_insert['sewers'] = $this->text2enum($value);
                    break;
                }
            case 'ogrodzenie': {
                    $offers_to_insert['fence'] = $this->text2enum($value);
                    break;
                }
            case 'prad': {
                    $offers_to_insert['electric'] = $this->boolean2enum($value);
                    break;
                }
            case 'typdzialki': {
                    $offers_to_insert['type_of_plot'] = $value;
                    break;
                }
            case 'typpodlaczeniawody': {
                    $offers_to_insert['water'] = $this->text2enum($value);
                    break;
                }
            case 'przeznaczenie': {
                    $offers_to_insert['destination'] = $value;
                    break;
                }
            case 'stannieruchomosci': {
                    $offers_to_insert['status_of_property'] = $value;
                    break;
                }
            case 'stanbudynku': {
                    $offers_to_insert['status_of_bulding'] = $value;
                    break;
                }
            case 'balkon': {
                    $offers_to_insert['balcon'] = $this->boolean2enum($value);
                    break;
                }
            case 'biuro': {
                    $offers_to_insert['office'] = $this->boolean2enum($value);
                    break;
                }
            case 'dwupoziomowe': {
                    $offers_to_insert['duplex'] = $this->boolean2enum($value);
                    break;
                }
            case 'klimatyzacja': {
                    $offers_to_insert['duplex'] = $this->boolean2enum($value);
                    break;
                }
            case 'kuchniawyposazona': {
                    $offers_to_insert['kitchen_equipment'] = $this->boolean2enum($value);
                    break;
                }
            case 'meble': {
                    $offers_to_insert['furniture'] = $this->boolean2enum($value);
                    break;
                }
            case 'napoddaszu': {
                    $offers_to_insert['in_attic'] = $this->boolean2enum($value);
                    break;
                }
            case 'osiedlezamkniete': {
                    $offers_to_insert['gated_community'] = $this->boolean2enum($value);
                    break;
                }
            case 'piwnica': {
                    $offers_to_insert['basement'] = $this->boolean2enum($value);
                    break;
                }
            case 'ma_ogrzewanie': {
                    $offers_to_insert['heating'] = $this->boolean2enum($value);
                    break;
                }
            case 'wylacznosc': {
                    $offers_to_insert['exclusive'] = $this->boolean2enum($value);
                    break;
                }
        }

        // ta tablica jest widoczna tylko tutaj
        return $offers_to_insert;
    }

    // Converting
    public function set_location($location, $value) {

        $offers_to_insert = array();

        switch ($location) {

            case 'province': {
                    $query = $this->CI->db->get_where('regions', array('name' => mb_strtolower($value, 'UTF-8')), '1')->row_array();
                    $offers_to_insert['voivodeships'] = $query['id'];
                    break;
                }

            case 'district': {
                    $query = $this->CI->db->get_where('regions', array('name' => mb_strtolower($value, 'UTF-8')), '1')->row_array();
                    $offers_to_insert['district'] = $query['id'];
                    break;
                }

            case 'commune': {
                    $offers_to_insert['town'] = $value;
                    $offers_to_insert['community'] = $value;
                    break;
                }
        }

        return $offers_to_insert;
    }

    // Conversion
    private function boolean2enum($value) {
        if ($value == 'true') {
            return '1';
        } else {
            return '0';
        }
    }

    // Conversion
    private function text2enum($value) {
        if ($value == 'brak') {
            return '0';
        } else {
            return '1';
        }
    }
    
    private function counter(){
        
        $this->CI->load->model('Otherpages_model');
        
        // do licznika
                    if (isset($_COOKIE['cookiecookie']))
                    {
                          $count = $this->CI->Otherpages_model->getCount();
                    }
                    else
                    {             
                          setcookie('cookiecookie','tresc',time()+900) or die('blad');
                          $this->CI->Otherpages_model->updateCount();
                          $count = $this->CI->Otherpages_model->getCount();
                    }
                    
                    return $count['no'];
        
    }
    
   // Remove directory
   private function rrmdir($dir) { 
        if (is_dir($dir)) { 
          $objects = scandir($dir); 
          foreach ($objects as $object) { 
            if ($object != "." && $object != "..") { 
              if (is_dir($dir."/".$object))
                rrmdir($dir."/".$object);
              else
                unlink($dir."/".$object); 
            } 
          }
          rmdir($dir); 
        } 
    }
 
 
// Get zip files
private function scan_dir($dir) {
    $zip = array('.zip');
    $files = array();
    
    foreach (scandir($dir) as $file) {
        $extension = pathinfo($file, PATHINFO_EXTENSION);
            if ($extension != 'zip') continue;
        
        $files[$file] = filemtime($dir . '/' . $file);
    }
    krsort($files);
    $files = array_keys($files);
    return ($files) ? $files : false;
}

}