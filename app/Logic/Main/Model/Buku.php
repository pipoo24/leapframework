<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 12/22/17
 * Time: 10:21 AM
 */

class Buku2 extends Model{
    var $table_name = "buku";
    var $main_id = "id";
    var $default_read_coloms = "id,title,stok,gambar";

    //allowed colom in database
    var $coloumlist =  "id,title,stok,gambar";

    var $id;
    var $title;
    var $stok;
    var $gambar;


    public function overwriteForm ($return)
    {
        $acc = new Account();
        $acc_arr = $acc->getWhere("admin_id>0");
        foreach($acc_arr as $key=>$val){
            $arr[$val->admin_id] = $val->admin_username;
        }
//        $arr = array(
//            "5"=>"kecil 10",
//            "10"=>"pas 10",
//            "11"=>"lebih besar 10"
//        );

        $return['gambar'] = new Leap\View\InputFoto("gambar", "gambar", $this->gambar);
        $return['stok'] = new Leap\View\InputSelect($arr,"stok", "stok", $this->stok);
        $return['title'] = new Leap\View\InputTextRTE("title", "title", $this->title);
        return $return;
    }

    public function constraints ()
    {
        //err id => err msg
        $err = array ();

//        if (!isset($this->gambar)) {
//            $err['gambar'] = Lang::t('gambar tidak boleh kosong');
//        }
//        if ($this->stok<10) {
//            $err['stok'] = Lang::t('stok kurang gede');
//        }
        /*if (!isset($this->admin_id)) {
            $err['admin_username'] = Lang::t('Create New User Not Allowed');
        }*/

        return $err;
    }

    public function overwriteRead ($return)
    {
        $objs = $return['objs'];
        foreach ($objs as $obj) {
            if ($obj->stok>0) {
                $obj->stok =  idr($obj->stok*10000);
            }
            if(isset($obj->title)){
                $obj->title = ucwords($obj->title);
            }


        }

        //pr($return);
        return $return;
    }
} 