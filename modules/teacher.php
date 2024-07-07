<?php

namespace teacher;

require (__DIR__."/user.php");

use user ;

use PDO;

#---------------------traits for data-------------------------
trait is_teacher{
    public function is_teacher($email){

        $conn = $this->conn;

        try{

            $stm = $conn->prepare("select count(id) as conti 
            from get_teacher 
            where email = ?");

            $stm->bindparam(1,$email);

            $stm->execute();

            $res = $stm->fetchAll(PDO::FETCH_ASSOC);

            if($res[0]['conti']==1){

                return true;

            }else{

                return false ;

            }

        }catch(PDOExeptio $e){

            echo $e.messege();

        }

    }
}

trait get_info{
    public function info(){

        $stm = $this->conn->prepare("select selary as sal , special as sp from get_teacher where id =?");

        $stm->bindparam(1,$this->id);

        $stm->execute();

        $res = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $res[0];

        try{

        }catch(PDOExeption  $e){
            echo "feild". $e->messege();
        }
    }
}

trait get_classes{
    public function get_class(){

        $conn = $this->conn;

        $id = $this->id;

        try{

            $stm = $conn->prepare('select class_class as cl 
            from class_teach 
            where teacher_user_id = ?');

            $stm->bindparam(1,$id);

            $stm->execute();

            $res = $stm->fetchAll(PDO::FETCH_ASSOC);

            $reAll = array();

            for($i = 0;$i < count($res);$i++){

                array_push($reAll,$res[$i]['cl']);

            }

            return $reAll;

        }catch(PDOExeption $e){

            echo "feild:" .$e.messege();

        }
    }
}

trait get_stu{
    public function get_stu($class){
        $conn = $this->conn;

        $res = array($class =>array());

        try{

            $stm = $conn->prepare("call stu_of_class(?)");

            $stm->bindparam(1,$class);

            $stm->execute();

            $res = $stm->fetchAll(PDO::FETCH_ASSOC);

            return $res;

        }catch(PDOExeption $e){

            echo "feild :" .$e->messege();
        }

    }
}

#-----------------------class for teacher-----------------------
class teacher extends user{

    use is_teacher , get_info;

    use get_classes , get_stu;

    public $salary;

    public $speciality;

    public $is_tea;

    public function __construct($email,$pass){
    
        try{

            user::__construct($email,$pass);

            if($this->is_user_on($pass)&&$this->is_teacher($email)){

                $info = $this->info();

                if(isset($info)){

                    $this->salary = $info['sal'];

                    $this->speciality = $info['sp'];

                    $this->is_tea = true;

                    $this->set_validity(3);

                }

            }

        }catch(PDOExiptio $e){

            echo "failed :faild to connect";

        }

    }
}

#$tet = new teacher('karamsalama1027547215@school.com','school_user1');

#echo $tet->edit_grades_mid_of_stu(5,"math",37);

?>