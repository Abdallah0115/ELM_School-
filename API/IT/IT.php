<?php

header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Headers: *");

Header('Access-Control-Allow-Methods: GET, POST');

include ("E:/xampp/htdocs/dashboard/School/modules/it.php");

include ("E:/xampp/htdocs/dashboard/School/modules/validation/validation.php");

use IT\it;

class data{
    public $err = 0;

    public $fname = Null ;

    public $lname = null;

    public $phone = null;

    public $birthDate = null;

    public $socialNum = null;

    public $id = null;

    public $mail = null; 

    public $selary = Null;

}

$data = new data();

if(isset($_POST["email"]) && isset($_POST["pass"])){

    $stu = new  it($_POST["email"],$_POST["pass"]);

    if($stu->is_it == true){


        $data->fname = $stu->fname;

        $data->lname = $stu->lname;

        $data->phone = $stu->phone;

        $data->birthDate = $stu->birthDate;

        $data->socialNum = $stu->socialNum;

        $data->id = $stu->id;

        $data->mail = $stu->mail;

        $data->selary = $stu->selary;

    }else{

        $data->err = "not valid try to change password or email .";


    }

    $myJSON = json_encode($data);

    echo $myJSON;
}else{
    header("location:http://localhost/dashboard/school/NotValidAccess/index.php");
}

?>