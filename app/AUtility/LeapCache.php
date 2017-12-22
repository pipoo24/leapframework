<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/29/16
 * Time: 9:27 AM
 */

class LeapCache {

    static $path = "cache/";

    public static function check($key,$expiry){


        $filename = self::$path.$key.".txt";

//        echo "<br>";
//        echo time()."<br>";
//        echo filemtime($filename)."<br>";
//        echo "Last now: ".date("F d Y H:i:s.",time());
//        echo "Last modified: ".date("F d Y H:i:s.",filemtime($filename));
//        echo "<br>".(time()-filemtime($filename));

        if (file_exists($filename)) {
//            echo "<br>";
//            echo time()."<br>";
//            echo filemtime($filename)."<br>";
//            echo "Last now: ".date("F d Y H:i:s.",time());
//            echo "Last modified: ".date("F d Y H:i:s.",filemtime($filename));
//            echo "<br>".(time()-filemtime($filename));
            if((time()-filemtime($filename))>$expiry){
                //overwrite file
                return '0';
            }
            else{
//                echo "<br>";echo "in";echo "<br>";
                $homepage = file_get_contents($filename);

//                echo $homepage."<br>";

                return $homepage;
            }
        }
        return '0';

    }

    public static function store($key,$value){

//        echo "<br>";echo "stored";echo "<br>";
        $filename = self::$path.$key.".txt";
        file_put_contents($filename, $value);
    }
} 