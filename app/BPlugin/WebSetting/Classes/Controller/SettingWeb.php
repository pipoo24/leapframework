<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SettingWeb
 *
 * @author User
 */
class SettingWeb extends WebService {


    var $access_efiwebsetting = "admin";
    public function efiwebsetting ()
    {

        if($_GET['cmd'] == "ws" && $_GET['mws']== "getall"){
            $this->getWebSetting();
        }else {

            //create the model object
            $cal = new Efiwebsetting();
            //send the webclass
            $webClass = __CLASS__;

            //run the crud utility
            Crud::run($cal, $webClass);
        }
        //pr($mps);
        //mode=ws
    }
    var $access_SystemSetting = "admin";
    public function SystemSetting ()
    {

        if($_GET['cmd'] == "ws" && $_GET['mws']== "getall"){
            $this->getWebSetting();
        }else {

            //create the model object
            $cal = new SystemSetting();
            //send the webclass
            $webClass = __CLASS__;

            //run the crud utility
            Crud::run($cal, $webClass);
        }
        //pr($mps);
        //mode=ws
    }

    var $access_GaweUMP = "admin";
    public function GaweUMP ()
    {



        //create the model object
        $cal = new GaweUMP();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
        //mode=ws
    }
    var $access_GaweUMK = "admin";
    public function GaweUMK ()
    {



        //create the model object
        $cal = new GaweUMK();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
        //mode=ws
    }


    var $access_Gawe_Setting = "admin";
    public function Gawe_Setting ()
    {



            //create the model object
            $cal = new Gawe_Setting();
            //send the webclass
            $webClass = __CLASS__;

            //run the crud utility
            Crud::run($cal, $webClass);

        //pr($mps);
        //mode=ws
    }

    var $access_GaweCommentPos = "admin";
    public function GaweCommentPos ()
    {



        //create the model object
        $cal = new GaweCommentPos();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
        //mode=ws
    }
    var $access_GaweCommentNeg = "admin";
    public function GaweCommentNeg ()
    {



        //create the model object
        $cal = new GaweCommentNeg();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
        //mode=ws
    }
    var $access_GaweCommentPosEr = "admin";
    public function GaweCommentPosEr ()
    {



        //create the model object
        $cal = new GaweCommentPosEr();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
        //mode=ws
    }
    var $access_GaweCommentNegEr = "admin";
    public function GaweCommentNegEr ()
    {



        //create the model object
        $cal = new GaweCommentNegEr();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
        //mode=ws
    }

    var $access_GaweCategory = "admin";
    public function GaweCategory ()
    {



        //create the model object
        $cal = new GaweCategory();
//        $cal->printColumlistAsAttributes();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
        //mode=ws
    }


    var $access_GaweReportMsg = "admin";
    public function GaweReportMsg ()
    {



        //create the model object
        $cal = new GaweReportMsg();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
        //mode=ws
    }

    var $access_GaweCancelEr = "admin";
    public function GaweCancelEr ()
    {



        //create the model object
        $cal = new GaweCancelEr();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
        //mode=ws
    }

    var $access_GaweCancelEe = "admin";
    public function GaweCancelEe ()
    {



        //create the model object
        $cal = new GaweCancelEe();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
        //mode=ws
    }

    var $access_GaweQuotes = "admin";
    public function GaweQuotes ()
    {



        //create the model object
        $cal = new GaweQuotes();
//        $cal->printColumlistAsAttributes();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
        //mode=ws
    }
    var $access_GawePaketAndroid = "admin";
    public function GawePaketAndroid ()
    {



        //create the model object
        $cal = new GawePaketAndroid();
//        $cal->printColumlistAsAttributes();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
        //mode=ws
    }
    var $access_GawePaketIos = "admin";
    public function GawePaketIos ()
    {



        //create the model object
        $cal = new GawePaketIos();
//        $cal->printColumlistAsAttributes();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
        //mode=ws
    }



    public function getWebSetting(){

        //dicache
        global $memcache;

        $cacheAvailable = $memcache->cacheAvailable;

        $key = 'websetting_ws';


        $product = null;

        if ($cacheAvailable == true)
        {
            $mc = $memcache->memcache;
            $product = $mc->get($key);

        }

        if(($product!=null)) {
            $json = $product;
            $json['use_cache'] = 1;
        }else {

            $obj = new Efiwebsetting();
            $obj->default_read_coloms = $obj->crud_webservice_allowed;
            $main_id = $obj->main_id;
            $exp = explode(",", $obj->crud_webservice_allowed);
            $arrPicsToAddPhotoUrl = $obj->crud_add_photourl;
            $arr = $obj->getAll();
            $json = array();
            $json['status_code'] = 1;
            //filter
            foreach ($arr as $o) {
                $sem = array();
                foreach ($exp as $attr) {
                    if (in_array($attr, $arrPicsToAddPhotoUrl)) {
                        $sem[$attr] = _PHOTOURL . $o->$attr;
                    } else
                        $sem[$attr] = stripslashes($o->$attr);
                }
                $json["results"][] = $sem;
            }
            if (count($arr) < 1) {
                $json['status_code'] = 0;
                $json['status_message'] = "No Details Found";
            }

            if ($cacheAvailable == true) {
                $mc = $memcache->memcache;
                $mc->set($key,$json);
            }
        }

        echo json_encode($json);
        die();
    }

    //to check if update needed or to do force update
    public function appVersion(){

        //dicache

        $userVersion = addslashes($_GET['version']);
        $userType = addslashes($_GET['os']);



        if($userVersion==""||$userType==""){
            $json['status_code'] = 0;
            $json['status_message'] = 'Please provide version and OS';
            echo json_encode($json);
            die();
        }

        //dicache
        global $memcache;

        $cacheAvailable = $memcache->cacheAvailable;

        $key = 'version_ws_'.$userVersion.'_'.$userType;
        $keytime = 'version_ws_time_'.$userVersion.'_'.$userType;

        $product = null;

        if ($cacheAvailable == true)
        {
            $mc = $memcache->memcache;
            //tambahi firsttime spy inboxnya banyak //if needed
            $lasttime = $mc->get($keytime);

            if($lasttime!=null && time()-$lasttime < 360)
                $product = $mc->get($key);

        }

        if(($product!=null)) {
            $json = $product;
            $json['use_cache'] = 1;
        }else {

            if ($userType == "android") {
                $ef = Efiwebsetting::getData("App_Version_Android");
                $url = Efiwebsetting::getData("App_URL_Android");
            }else{
                $ef = Efiwebsetting::getData("App_Version_iOS");
                $url = Efiwebsetting::getData("App_URL_iOS");
            }

            $exp = explode(";", $ef);
            $version = (int)$exp[0];
            $update = 0;

            if ($version > $userVersion) {
                $update = 1;
            }

            $force = (int)$exp[1];

            $json['status_code'] = 1;
            $json['results']['latest_version'] = $version;
            $json['results']['force_update'] = $force;
            $json['results']['ada_update'] = $update;
            $json['results']['url'] = $url;

            if ($cacheAvailable == true) {
                $mc = $memcache->memcache;
                $mc->set($key,$json);
                $mc->set($keytime,time());
            }
        }
        echo json_encode($json);
        die();

    }

}
