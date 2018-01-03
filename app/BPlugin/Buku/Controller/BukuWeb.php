<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/3/18
 * Time: 9:35 AM
 */

class BukuWeb extends WebService{

    var $access_Buku2 = "admin";
    public function Buku2 ()
    {



        //create the model object
        $cal = new Buku2();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
        //mode=ws
    }
} 