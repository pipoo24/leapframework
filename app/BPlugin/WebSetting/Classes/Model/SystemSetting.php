<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/23/17
 * Time: 9:56 AM
 */

class SystemSetting extends Efiwebsetting{

    var $table_name = "sp_websetting_system";

    public $crud_setting = array("add"=>1,"search"=>1,"viewall"=>1,"export"=>1,"toggle"=>1,"import"=>0,"webservice"=>0,"publish"=>0);
    public $dont_truncate = 1;

    public function overwriteForm ($return, $returnfull)
    {
        $return  = parent::overwriteForm($return, $returnfull);


        $return['set_value'] = new Leap\View\InputTextArea("set_value", "set_value",
            $this->set_value);

        return $return;
    }

    public function constraints ()
    {
        //err id => err msg
        $err = array ();
        $this->set_id = trim(rtrim($this->set_id));
        $this->set_value = trim(rtrim(htmlspecialchars($this->set_value)));
        if (!isset($this->set_id)) {
            $err['set_id'] = Lang::t('ID cannot be empty');
        }


        if (!isset($this->set_value)) {
            $err['set_value'] = Lang::t('Value cannot be empty');
        }



        return $err;
    }

    public function loadToSession ($whereClause = '', $selectedColom = "*")
    {
        //cek apakah sudah ada di session
        //if(count($_SESSION[get_called_class()])<1){
        global $db;
        $where = "";
        if ($whereClause != '') {
            $where = " WHERE " . $whereClause;
        }
        $q = "SELECT {$selectedColom} FROM {$this->table_name} $where";
        $arr = $db->query($q, 2);
        //pr($arr);
        foreach ($arr as $ss) {
            $_SESSION[get_called_class()][$ss->set_id] = stripslashes(htmlspecialchars_decode($ss->set_value));
        }
        //}
        //pr($_SESSION);die();
    }

    public static function setData($id,$val){
        self::setDataSementara($id, $val);
        $ef = new SystemSetting();
        $ef->set_id = $id;
        $ef->set_value = $val;
        return $ef->save(1);
    }
    public static function setDataSementara($id,$val){
        $_SESSION[get_called_class()][$id] = $val;
    }
} 