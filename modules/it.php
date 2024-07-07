<?php
namespace IT;

require __DIR__."/user.php";

use user;

use PDO;

trait is_it{
    public function is_jop($email){

        $conn = $this->conn;

        try{

            $stm = $conn->prepare("select count(id) as conti 
            from get_it 
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

class it extends user{
    use is_it;

    public $selary ;

    public $is_it;

    public function __construct($email,$pass){

        try{

            user::__construct($email,$pass);

            if($this->is_jop($email)&&$this->is_user_on($pass)){

                $stm = $this->conn->prepare("select selary from get_it where id = ?"); 

                $stm->bindparam(1,$this->id);

                $stm->execute();

                $this->selary = $stm->fetchAll(PDO::FETCH_ASSOC)[0]['selary'];

                $this->is_it = true;

                $this->set_validity(2);

            }

        }catch(PDOExeption $e){
            echo "feild :" .$e->messege();
        }
    }

    public function is_IT(){

        return $this->selary != NULL; 

    }
}

#$it = new it('abdosleim1012349138@school.com','school_user');

#echo $it->is_IT()

?>