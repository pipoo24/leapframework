<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 12/22/17
 * Time: 10:21 AM
 */

class Buku extends Model{
    var $table_name = "buku";
    var $main_id = "id";
    var $default_read_coloms = "id,title,stok";

    //allowed colom in database
    var $coloumlist =  "id,title,stok";

    var $id;
    var $title;
    var $stok;
} 