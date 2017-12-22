<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/23/17
 * Time: 6:08 PM
 */

namespace Leap\View;


class InputTextCopy extends Html {

    public $type;


    public function __construct ($id, $name, $value, $classname = 'form-control')
    {
        $this->id = $id;
        $this->name = $name;
//        $this->type = $type;
        $this->classname = $classname;
        $this->value = stripslashes($value);
    }

    public function p ()
    {
        $sem = $this->type;
        $idku = $this->id;


        echo "<input type='text' width='100%' name='{$this->name}' value=\"{$this->value}\" id='{$idku}' class='{$this->classname}' {$this->readonly}><button type='button' onclick='copyToClipboard(document.getElementById(\"$idku\"));'>copy</button>";




    }
}