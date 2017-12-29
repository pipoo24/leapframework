<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 12/22/17
 * Time: 9:36 AM
 */

class MainPage extends MainWebApps{

    function index(){

        echo "hello world hahaha";

        ?>
        <a href="<?=_SPPATH;?>daftar_buku">daftar_buku</a>
        <?
    }

    function daftar_buku(){

        echo "buku1, buku2";
//        $buku = new Buku();
//        $arr = $buku->getAll();
//        pr($arr);
    }

    function backend(){


        $acc = new AccountLogin();
        $acc->loginForm();

    }


} 