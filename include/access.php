<?php
/*
 *  Database, Websetting and Path Setting
 *  untuk multiple selection di def di init.php
 *
 * [serverpath:protected] => 35.201.252.238
    [db_username:protected] => webgawe
    [db_password:protected] => 818283Imb88
 */
$serverpath = "localhost"; //koneksi di server idokter
$db_username = "root"; //catalyst
$db_password = "root"; //Nn#6of68
$db_name = "gaweframework"; //admin_catalyst
$db_prefix = '';
//init db setting
$DbSetting = array ("serverpath" => $serverpath, "db_username" => $db_username, "db_password" => $db_password,
                    "db_name"    => $db_name, "db_prefix" => $db_prefix);
//Websetting
$domain = "localhost:8888";
$folder = '/gaweframework/';
$title = 'GAWE INDONESIA';
$metakey = 'TBS';
$metadescription = 'TBS';
$lang = 'en';
$currency = 'IDR';
//path untuk save, filesystem path kalau untuk linux bisa dari depan /opt/lamp/...
$photo_path = '/Users/elroy/htdocs/gaweframework/uploads/'; //always use full path - elroy 19 12 2014
//path utk url, tanpa http:// dan tanpa folder e.g /leapportal/
$photo_url = '/uploads/';

$themepath = "keren";
// init web setting
$WebSetting = array ("domain"          => $domain, "folder" => $folder, "title" => $title, "metakey" => $metakey,
                     "metadescription" => $metadescription, "lang" => $lang, "currency" => $currency,
                     "photopath"       => $photo_path, "photourl" => $photo_url, "themepath" => $themepath);
//timezone
$timezone = 'Asia/Jakarta';

//javascript files
$js = "loader_js.php";
//css files
$css = "loader_css.php";

//main class MUST BE subclass of Apps
$mainClass = "MainPage";
//set namespace for apps
$nameSpaceForApps = array ("");