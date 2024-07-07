<?php

#-----------------declaration of namespace-------------
namespace student ;


#-------------require data from other modules----------
require (__DIR__.'/user.php');

include (__DIR__.'/grades.php');

#---------using the class we use to declare user-------
use user;

use grades\grades_mid_for_student;

use grades\grades_final_for_student;

use grades\time_grades_mid;

use grades\time_grades_final;

use PDO;

#------------trait for ensure student------------------
trait is_student{
    public function is_student($email,$conn){

        try{

            $stm = $conn->prepare("select count(id) as conti 
            from git_students 
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
#------------trait for ensure student-------------------

trait get_student{
    public function get_stu($id,$conn){
        try{
            $stm = $conn->prepare("select level ,class_class 
            from git_students 
            where id = ?");

            $stm->bindparam(1,$id);

            $stm->execute();

            $res = $stm->fetchAll(PDO::FETCH_ASSOC);

            return $res[0];

        }catch(PDOExeption $e){

            echo "faild : ".$e->messege();

        }
    }

}

#---------------traits of grades------------------------
trait get_grades_mid{
    public function grades_mid($conn,$id){

        $mid = new grades_mid_for_student($id,$conn);

        return $mid->myMid();
    }
}

trait get_grades_final{
    public function grades_final($conn,$id){

        $final = new grades_final_for_student($id,$conn);

        return $final->myFinal();

    }
}
#-------------traits for showing grades----------------
trait show_mid{
    public function show_mid_of($sub_name){

        $sub_name = strtolower($sub_name); 

        $temp = new time_grades_mid($this->level,$this->conn);

        if($temp->is_time()){
            
            switch($sub_name){

                case "arabic":

                    return $this->grades_mid->get_ara();

                    break;

                case "math":

                    return $this->grades_mid->get_math();

                    break;

                case "english":

                    return $this->grades_mid->get_eng();

                    break;

                case "science":

                    return $this->grades_mid->get_sci();

                    break;

                default :

                    return false;

                    break;
            }
        }else{

            echo "denied";

            return false;

        }

    }
}

trait show_final{
    public function show_final_of($sub_name){

        $sub_name = strtolower($sub_name); 

        $temp = new time_grades_final($this->level,$this->conn);

        if($temp->is_time()){

            switch($sub_name){

                case "arabic":

                    return $this->grades_final->get_ara();

                    break;

                case "math":

                    return $this->grades_final->get_math();

                    break;

                case "english":

                    return $this->grades_final->get_eng();

                    break;

                case "science":

                    return $this->grades_final->get_sci();

                    break;

                default :

                    return false;

                    break;
            }
        }else{

            echo "denied";

            return false;

        }

    }
}


#---------------class for student----------------------
class student extends user{
    use is_student ,get_grades_mid ;

    use get_student ,get_grades_final;

    use show_mid ,show_final;

    public $level;

    public $class;

    protected $grades_mid ;

    protected $grades_final;

    public $is_stu ;

    public function __construct($email,$pass){
        try{
            user::__construct($email,$pass);

            if($this->is_user_on($pass)&&$this->is_student($email,$this->conn)){

                $info = $this->get_stu($this->id,$this->conn);

                if(isset($info)){

                    $this->level = $info["level"];

                    $this->class = $info["class_class"];

                    $this->grades_mid = $this->grades_mid($this->conn,$this->id);

                    $this->grades_final = $this->grades_final($this->conn,$this->id);

                    $this->set_validity(4);

                    $this->is_stu = true;

                }

            }
        }catch(PDOExeption $e){

            echo"feild : ". $e.messege();

        }
    }
}


?>