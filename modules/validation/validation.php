<?php

class validation{

    public function valid_ssn($ssn){

        return preg_match("/^[0-9]*$/",$ssn);
    }

    public function valid_name($name){

        $pattern = "/^[A-Z]+[a-z_ -]{1,}$/";

        return preg_match_all($pattern,$name); 
    }

    public function valid_email($email){

        return filter_var($email,FILTER_VALIDATE_EMAIL);
    }

    public function valid_date($date){

        return preg_match("/^20[0-9]+[0-9]-[0-1][0-9]-[1-30]*$/",$date); 
    }

    public function valid_num($num){

        return filter_var($num,FILTER_VALIDATE_FLOAT);
    }

    public function valid_id($num){
        return filter_var($num,FILTER_VALIDATE_INT);
    }

    public function valid_class_name($class_name){

        return preg_match("/^[A-Z]{1}+[0-9]*$/",$class_name);
    }

    public function valid_sub_name($sub){

        return preg_match("/^[a-z]*$/",$sub);
    }

    public function valid_phone($num){

        return preg_match("/^01[0-9]{9}$/",$num);
    }

}

?>