<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 7/4/16
 * Time: 10:13 AM
 */

class AppContentHelper {

    public static function checkApp($app_id,$acc_id){

        if($app_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }

        if($acc_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }
        $pp = new AppAccount();
        $pp->getByID($app_id);

        if($pp->app_client_id != $acc_id){
            $json['status_code'] = 0;
            $json['status_message'] = "Mismatched";
            echo json_encode($json);
            die();
        }

        return $pp;
    }

    public static function checkPush($app_id,$acc_id,$camp_id){

    }

    public static function createJSON($app_id,$json){


        $fp = fopen(_PHOTOPATH.'json/'.$app_id.'.json', 'w');
        $status = fwrite($fp, json_encode($json));
        fclose($fp);

        return $status;

    }

    public static function loadJSON($app_id){
        $jsonstr = file_get_contents(_PHOTOPATH.'json/'.$app_id.'.json');
        return json_decode($jsonstr);
    }

    public static function doCURLPost($url,$fields){

        //extract data from the post
//set POST variables
//        $url = 'http://domain.com/get-post.php';
//        $fields = array(
//            'lname' => urlencode($_POST['last_name']),
//            'fname' => urlencode($_POST['first_name']),
//            'title' => urlencode($_POST['title']),
//            'company' => urlencode($_POST['institution']),
//            'age' => urlencode($_POST['age']),
//            'email' => urlencode($_POST['email']),
//            'phone' => urlencode($_POST['phone'])
//        );

        $fields_string = "";
//url-ify the data for the POST
        foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');

//open connection
        $ch = curl_init();

//set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//execute post
        $result = curl_exec($ch);

//close connection
        curl_close($ch);

        return $result;
    }

    public static function saveFromDraft($arrDraft,$classnameAsli){
        $new = new $classnameAsli();
        $colomlist = $new->getColumnlist();

//        pr($arrDraft);
        $num = 0;
        foreach($arrDraft as $appc){
            $appContentAsli = new $classnameAsli();
//            $appContentAsli->fill(Crud::clean2printEinzeln($appc));


            foreach ($colomlist as $colom) {



                $field = $colom->Field;
                $appContentAsli->{$field} = $appc->{$field};


            }

//            if($classnameAsli!="AppContent") {
//                pr($appContentAsli);
            $num += $appContentAsli->save(1,0);
//                echo "<h1>" . $num . "</h1>";
//            }

        }
        return $num;

    }

    public static function checkJarakJamPush(){

        $date = addslashes($_POST['push_date']);
        $time = addslashes($_POST['push_time']);

        $jarak = 1;

        $datetime1 = new DateTime($date." ".$time.":00:00");
        $datetime2 = new DateTime(date("Y-m-d h:i:s"));
        $interval = $datetime2->diff($datetime1);

//        pr($interval);

        if($interval->invert){
            return 0;
        }
        if($interval->days>0){
            return 1;
        }
        if($interval->h>=$jarak){
            return 1;
        }
        else return 0;

//        die();
    }

    public static function stripTagsDeep($arr,$allowable = '<b><i><u><h1><h2><h3><h4><h5><h6><br><section><nav><style><a><div><span>'){
        foreach ($arr as $key => $value) {
            $value = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $value);
            $arr[$key] = strip_tags(trim(rtrim(stripslashes($value))),$allowable);
        }
        return $arr;
    }

    public static function stripTag($string,$allowable = '<b><i><u><h1><h2><h3><h4><h5><h6><br><section><nav><style><a><div><span>'){

        $string = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $string);
        $sss = strip_tags(trim(rtrim($string)),$allowable);
        return $sss;
    }
} 