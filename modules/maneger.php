<?php
namespace maneger;

require __DIR__."/user.php";

use user;

use PDO;

trait is_man{
    public function is_jop($email){

        $conn = $this->conn;

        try{

            $stm = $conn->prepare("select count(id) as conti 
            from get_maneg 
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

            return false;

        }

    }
    
} 

class maneger extends user{
    use is_man;

    public $selary ;

    public $is_man ;

    public function __construct($email,$pass){

        try{

            user::__construct($email,$pass);

            if($this->is_jop($email) && $this->is_user_on($pass)){

                $stm = $this->conn->prepare("select selary from get_maneg where id = ?"); 

                $stm->bindparam(1,$this->id);

                $stm->execute();

                $this->selary = $stm->fetchAll(PDO::FETCH_ASSOC)[0]['selary'];

                $this->set_validity(1);

                $this->is_man = true;

            }

        }catch(PDOExeption $e){
            echo "feild :" .$e->messege();
        }
    }

    public function is_maneger(){

        return $this->selary != NULL; 

    }
}
#$m = new maneger('abdoshehata1152184179@school.com','school_user');

#echo $m->add_teacher_class('1027547215','C3');

#var_dump($m->get_teachers_of_class('A1'));

#var_dump($m->get_grade_man(4));
?>