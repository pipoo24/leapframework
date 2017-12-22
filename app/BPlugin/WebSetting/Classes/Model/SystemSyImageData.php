<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/23/17
 * Time: 5:51 PM
 */

class SystemSyImageData extends Model{

    var $table_name = "sp_websetting_files";

    var $main_id    = "set_id";

    var $default_read_coloms = "set_id,set_value,set_description,set_url";

    var $set_id;
    var $set_description;
    var $set_url;
    //var	$set_name;
    var $set_value;

    //allowed colom in database
    var $coloumlist = "set_id,set_value,set_description,set_url";
    public $crud_setting = array("add"=>1,"search"=>1,"viewall"=>0,"export"=>0,"toggle"=>1,"import"=>0,"webservice"=>0,"publish"=>0);
    public $crud_webservice_allowed = "set_id,set_value,set_description,set_url";


    public function overwriteForm ($return, $returnfull)
    {
        $return  = parent::overwriteForm($return, $returnfull);


        $return['set_value'] = new Leap\View\InputFoto("set_value", "set_value",
            $this->set_value);

        $x = new Leap\View\InputTextCopy("set_url", "set_url",
            $this->set_url);
        //$x->readonly = "disabled";
        $return['set_url'] = $x;

        return $return;
    }

    public function overwriteRead ($return)
    {
        $return = parent::overwriteRead($return);
//        $oauth = IMBAuth::createOAuth();
        $objs = $return['objs'];

        foreach ($objs as $obj) {
            $t = time();
            $obj->removeAutoCrudClick = array("action","set_url");

            $cc = "cc".$obj->set_id.time();
            $obj->set_url = "<input width='100%' id='$cc' type='text' value='".$obj->set_url."'><button type='button' onclick='copyToClipboard(document.getElementById(\"$cc\"));'>copy</button>";
            //if($obj->set_url=="")
            //url,b,id,clm,status_id,download_id,cname
            $status_id = "status_".$obj->set_id.time();
            $url = "files/".$obj->set_value;
            $path = _PHOTOPATH.$obj->set_value;
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $b = base64_encode($data);
            $id = $obj->set_id;
            $clm = "set_url";
            $cname = "SystemSyImageData";
            $download_id = $cc;
//\"{$url}\",\"{$b}\",\"{$id}\",\"{$clm}\",\"{$status_id}\",\"{$download_id}\",\"{$cname}\"
            $obj->action = "<div id=\"{$status_id}\"></div><button type='button' onclick='uploadkan_image(\"{$url}\",\"{$b}\",\"{$id}\",\"{$clm}\",\"{$status_id}\",\"{$download_id}\",\"{$cname}\");'>publish</button>";


            if (isset($obj->set_value)) {
                $obj->set_value = \Leap\View\InputFoto::getAndMakeFoto($obj->set_value, $t."set_value_" . $obj->set_value);
            }
        }
        return $return;
    }

} 