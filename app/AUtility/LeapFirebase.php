<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/16/17
 * Time: 10:18 AM
 */

class LeapFirebase {

    var $key = "rmdivOcBN4ekUBXACmnkI1aspHBfqb5H2VgopjaX";
    function __construct() {

        $this->key = SystemSetting::getData('firebase_secrets');
        $this->web = SystemSetting::getData('firebase_web');
        $this->db = SystemSetting::getData('firebase_db');
    }

    public static function getWebSetup(){

        $lf = new LeapFirebase();
        return $lf->web;
    }

    function patch($path,$c){

        $url = $this->db.$path.'?auth='.$this->key;

        if(is_object($c)||is_array($c))
        $data_string = json_encode($c);
        else $data_string = $c;

//        pr($data_string);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );
        return $result = curl_exec($ch);
    }

    function put($path,$c){

        $url = $this->db.$path.'?auth='.$this->key;

        $data_string = json_encode($c);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );
        return $result = curl_exec($ch);
    }

    function delete($path){

        $url = $this->db.$path.'?auth='.$this->key;

//        $data_string = json_encode($c);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json'
//                'Content-Length: ' . strlen($data_string))
            )
        );
        return $result = curl_exec($ch);
    }

    function fetch($path){
        $urlmalls = "https://mallbros-27e78.firebaseio.com/malls.json?auth=PnaE6JyaKFcE1zUrSjDFWtFT1aNvm8QGSBA29IYE";

        $urlmalls = $this->db.$path."?auth=".$this->key;

        //https://graph.facebook.com/296249987057786/feed?fields=admin_creator,name,message,full_picture,from&access_token=502346249941036|yPllO5UNnvfsbDxs2R8oVTQ8jhE

        $f = file_get_contents($urlmalls);
        $f2 = json_decode($f);
        return $f2;
    }

    function fetchComplex($path){
        $urlmalls = "https://mallbros-27e78.firebaseio.com/malls.json?auth=PnaE6JyaKFcE1zUrSjDFWtFT1aNvm8QGSBA29IYE";

        $urlmalls = $this->db.$path."&auth=".$this->key;
        //echo $urlmalls;

        //https://graph.facebook.com/296249987057786/feed?fields=admin_creator,name,message,full_picture,from&access_token=502346249941036|yPllO5UNnvfsbDxs2R8oVTQ8jhE

        $f = file_get_contents($urlmalls);
        $f2 = json_decode($f);
        return $f2;
    }
} 