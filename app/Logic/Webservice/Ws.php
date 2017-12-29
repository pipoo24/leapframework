<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 12/22/17
 * Time: 10:44 AM
 */

class Ws extends WebService{


    function daftarGuru(){

        $arr = array();

        for($x=0;$x<100;$x++) {
            $berita = array();
            $berita["id"] = $x;
            $berita["judul"] = "Ada gempa";
            $berita["date"] = date("Y-m-d");
            $arr[] = $berita;
        }


        echo json_encode($arr);

    }
} 