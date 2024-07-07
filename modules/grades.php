<?php

namespace grades ;

#--------------requiring classes used in this shit----------------

use DateTime;

use pdo ;

#-------------traits used to ease this tasks----------------------
trait get_mid_grades{

    public function get_grades_mid($id,$sub,$conn){

        try{

            $stm = $conn->prepare("select mid_term as deg
            from get_grades_mid
            where id = ? and name = ?");

            $stm->bindparam(1,$id);

            $stm->bindparam(2,$sub);

            $stm->execute();

            $res = $stm->fetchAll(PDO::FETCH_ASSOC);

            if(isset($res)){

                return $res[0]['deg'];

            }else return false ;

        }catch(PDOExeption $e){

            echo $e->messege();

        }
    }
}

trait get_final_grades{

    public function get_grades_final($id,$sub,$conn){

        try{

            $stm = $conn->prepare("select final_exam as deg
            from get_grades_final
            where id = ? and name = ?");

            $stm->bindparam(1,$id);

            $stm->bindparam(2,$sub);

            $stm->execute();

            $res = $stm->fetchAll(PDO::FETCH_ASSOC);

            if(isset($res)){

                return $res[0]['deg'];

            }else return false ;

        }catch(PDOExeption $e){

            echo $e->messege();

        }
    }
}

#----------------class grades for composition------------------------
class grades_mid{
    private $arabic;

    private $math;

    private $english;

    private $science;

    public function set_ara($deg){

        $this->arabic = $deg;

    }

    public function set_math($deg){

        $this->math = $deg;

    }

    public function set_eng($deg){

        $this->english = $deg;

    }

    public function set_sci($deg){

        $this->science = $deg;

    }

    public function get_ara(){

        return $this->arabic ;

    }

    public function get_math(){

        return $this->math ;

    }

    public function get_eng(){

        return $this->english ;

    }

    public function get_sci(){

        return $this->science ;

    }
}

class grades_final{
    private $arabic;

    private $math;

    private $english;

    private $science;

    public function set_ara($deg){

        $this->arabic = $deg;

    }

    public function set_math($deg){

        $this->math = $deg;

    }

    public function set_eng($deg){

        $this->english = $deg;

    }

    public function set_sci($deg){

        $this->science = $deg;

    }

    public function get_ara(){

        return $this->arabic ;

    }

    public function get_math(){

        return $this->math ;

    }

    public function get_eng(){

        return $this->english ;

    }

    public function get_sci(){

        return $this->science ;

    }

}

#----------------class grades for student ---------------------------

class grades_mid_for_student {

    use get_mid_grades;

    private $mid;

    private $conn;

    public function __construct($id ,$conn){

        $this->conn = $conn;

        $this->mid = new grades_mid();

        $this->mid->set_ara($this->get_grades_mid($id,'arabic',$this->conn));

        $this->mid->set_eng($this->get_grades_mid($id,'english',$this->conn));

        $this->mid->set_math($this->get_grades_mid($id,'math',$this->conn));

        $this->mid->set_sci($this->get_grades_mid($id,'science',$this->conn));
    }

    public function myMid(){

        return $this->mid ;

    }    
} 

class grades_final_for_student {

    use get_final_grades;

    private $final;

    private $conn ;

    public function __construct($id,$conn){
        $this->conn = $conn;

        $this->final = new grades_final();

        $this->final->set_ara($this->get_grades_final($id,'arabic',$this->conn));

        $this->final->set_eng($this->get_grades_final($id,'english',$this->conn));

        $this->final->set_math($this->get_grades_final($id,'math',$this->conn));

        $this->final->set_sci($this->get_grades_final($id,'science',$this->conn));
    }

    public function myFinal(){

        return $this->final ;

    }    
}

class time_grades_mid {
    private $time_mid;
    private $conn ;

    private function get_time($lev, $conn){

        $stm = $conn->prepare('select mid_date 
        from get_time_grades
        where level = ?');

        $stm->bindparam(1,$lev);

        $stm->execute();

        $res = $stm->fetchAll(PDO::FETCH_ASSOC);

        if(!isset($res) || $res[0]['mid_date'] == NULL){

            return false;

        }else return $res[0]['mid_date'];

    }

    public function __construct($level,$conn){

        $this->conn = $conn ;

        $this->time_mid = $this->get_time($level ,$this->conn);

    }

    public function is_time(){

        $date1 = new DateTime('now');

        $date2 = new DateTime($this->time_mid);

        if($this->time_mid == false ||  $date1 < $date2)

            return false;

        else return true ;
    }
}

class time_grades_final  {
    private $time_final;
    private $conn ;

    private function get_time($lev, $conn){

        $stm = $conn->prepare('select final_date 
        from get_time_grades
        where level = ?');

        $stm->bindparam(1,$lev);

        $stm->execute();

        $res = $stm->fetchAll(PDO::FETCH_ASSOC);

        if(!isset($res) || $res[0]['final_date'] == NULL){

            return false;

        }else return $res[0]['final_date'];

    }

    public function __construct($level,$conn){

        $this->conn = $conn ;

        $this->time_final = $this->get_time($level ,$this->conn);

    }

    public function is_time(){

        $date1 = new DateTime('now');

        $date2 = new DateTime($this->time_final);

        if($this->time_final == false ||  $date1 < $date2)

            return false;

        else return true ;
    }
}
?>