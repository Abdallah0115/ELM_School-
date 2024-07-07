<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
Header('Access-Control-Allow-Methods: GET, POST');

include ("E:/xampp/htdocs/dashboard/School/modules/student.php");

include ("E:/xampp/htdocs/dashboard/School/modules/validation/validation.php");

use student\student;

class data{
    public $err = 0;

    public $fname = Null ;

    public $lname = null;

    public $phone = null;

    public $birthDate = null;

    public $socialNum = null;

    public $id = null;

    public $mail = null;

    public $level = null;

    public $class = null;
}

$data = new data();

if(isset($_POST["email"]) && isset($_POST["pass"])){

    $stu = new  student($_POST["email"],$_POST["pass"]);

    if($stu->is_stu == true){

        $data->fname = $stu->fname;

        $data->lname = $stu->lname;

        $data->phone = $stu->phone;

        $data->birthDate = $stu->birthDate;

        $data->socialNum = $stu->socialNum;

        $data->id = $stu->id;

        $data->mail = $stu->mail;

        $data->level = $stu->level;

        $data->class = $stu->class;

    }else{

        $data->err = "Not valid try to change password or email" ;

    }

    $myJSON = json_encode($data);

    echo $myJSON;

}else{
    header("location:http://localhost/dashboard/school/NotValidAccess/index.php");
}

?>