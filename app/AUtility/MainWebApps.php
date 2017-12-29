<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 12/29/17
 * Time: 2:50 PM
 */

class MainWebApps extends WebApps{

    /*
         * login webview
         */
    function login ()
    {
        //check passcode
        if(_use_passcode)
            if($_POST['admin_passcode']!=SystemSetting::getData('PassCode')){
                Redirect::index("Wrong Pass Code");
            }


        /*
         * login logic
         */
        $acc = new AccountLogin();
        $acc->login_hook = array (
            "Role"            => "loadRoleToSession"
        );

        $acc->process_login();
    }

    /*
     * Web View For logout
     */
    function logout ()
    {
        $acc = new AccountLogin();
        $acc->process_logout();
    }
} 