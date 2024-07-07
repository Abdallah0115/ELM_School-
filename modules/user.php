<?php

require_once (__DIR__.'/connect.php');

require_once (__DIR__.'/manegment/studentManegment.php');

require_once (__DIR__.'/manegment/teacherManegment.php');

require_once (__DIR__.'/manegment/ITManegmanet.php');

require_once (__DIR__.'/manegment/manManegment.php');

require_once (__DIR__.'/manegment/classManegment.php');

#------------------------ trait for asure that this is user-------------------------------------
trait is_user{
    public function is_user($email,$pass,$conn)

    {

        try{

            $stm = $conn->prepare("call select_use(?);");

            $stm->bindParam(1,$email);

            $stm->execute();

            $res = $stm->fetchAll(PDO::FETCH_ASSOC);

            if($res[0]['pass_f']=='feild'){

                return false ;

            }else {

                if(hash('md5',$pass,0)==$res[0]['pass_f'])

                {

                    return true ;

                }else{

                    return false ;

                }

            }
        }catch(PDOExeption $e){

            echo "failed to connect";

        }

    }

}

#------------------------ trait for retrieve that user's data ----------------------------------
trait get_user{
    public function get_user($email,$conn){

        try{

            $stm = $conn->prepare("select * from get_user where email = ? ;");

            $stm->bindparam(1,$email);

            $stm->execute();

            $res=$stm->fetchAll(PDO::FETCH_ASSOC);

            return $res[0] ;

        }catch(PDOExeption $e){

            $conn->PDO::rollback();

            echo "failed to connect";

        }
    }
}

trait settings{
    public function edit_pass($new_pass){

        $new = hash('md5',$new_pass,false);

        $conn = $this->conn;

        try{

        $stm = $conn->prepare("update user set password = ? where id = ?");

        $stm->bindparam(1,$new);

        $stm->bindparam(2,$this->id);

        $stm->execute();

        }catch(PDOExeption $e){

            echo "feild :".$e.messege();
        }

    }

    public function edit_phone($new_phone){
        $conn = $this->conn;

        try{

        $stm = $conn->prepare("update user set phone = ? where id = ?");

        $stm->bindparam(1,$new_phone);

        $stm->bindparam(2,$this->id);

        $stm->execute();

        }catch(PDOExeption $e){

            echo "feild :".$e.messege();
        }
    } 
}

#----------check is user at all-------------------
interface is_users{
    public function is_user_on($pass);
}

#---------return user id---------------------------
interface get_user_data{
    public function get_user_id();
}

#------------------------ class for user's data and constructer for data -----------------------
class user extends connect implements is_users ,get_user_data{
    use is_user,get_user;

    use settings , stu_man, edit_stu ,IT_edit,add_maneger;

    use teacher_man , IT_man ,edit_teacher,man_man , class_man;

    public $fname ;

    public $lname ;

    public $phone ;

    public $birthDate;

    public $socialNum;

    public $id;

    public $mail;

    private $validation;

    public function __construct($mail , $pass){

        try{

            connect::__construct();

            if($this->is_user($mail,$pass,$this->conn)){

                $list = $this->get_user($mail,$this->conn);

                if(isset($list)){

                    $this->fname = $list['fname'];

                    $this->lname = $list['lname'];

                    $this->phone = $list['phone'];

                    $this->birthDate = $list['bdate'];

                    $this->socialNum = $list['ssn'];

                    $this->id = $list['id'];

                    $this->mail = $mail;
                }
            }
        }catch(PDOExeption $e){
            echo "error :there are no user with this data";
        }
    }

    public function is_user_on($pass){

        return $this->is_user($this->mail,$pass,$this->conn);

    }

    public function get_user_id(){

        return $this->id;

    }

    protected function set_validity($ved){
        $this->validation = $ved ;
    }

    protected function get_validity(){
        return $this->validation;
    }

}

?>