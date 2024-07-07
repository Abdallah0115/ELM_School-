<?php
class grade_man{

    public $name;

    public $arabic;

    public $math;

    public$english;

    public $science;
}

trait class_man{
    public function is_class_man($cName){

        try{
            $conn = $this->conn;

            $stm = $conn->prepare("select count(class) as count from class where class = ?");

            $stm->bindparam(1,$cName);

            $stm->execute();

            $res = $stm->fetchAll(PDO::FETCH_ASSOC);

            if($res[0]['count'] == 1){

                return true;

            }else{
                return false;
            }
        }catch(PDOExeption $e){

            return false;

        }

    }

    public function retrieve_classes(){
        if($this->get_validity() <= 2){

            $conn = $this->conn;

            $stm = $conn->prepare("select * from class");

            $stm->execute();

            $res = $stm->fetchAll(PDO::FETCH_ASSOC);

            return $res;

        }else{
            return false;
        }
    }

    public function add_class($className){
        
        if($this->get_validity() <= 2 && !$this->is_class_man($className)){

            try{

                $conn = $this->conn;

                $stm = $conn->prepare("insert into class(class) values(?);");

                $stm->bindparam(1,$className);

                $stm->execute();

                return true;

            }catch(PDOExeption $e){

                return false;

            }

        }else{
            return false;
        }
    }

    public function get_students_name_of_class($className){
        if($this->get_validity() <= 2 && $this->is_class_man($className)){

            $conn = $this->conn;

            try{

                $stm = $conn->prepare("select fname , lname ,class_class
                from git_students
                where class_class = ?");

                $stm->bindparam(1,$className);

                $stm->execute();

                $res = $stm->fetchAll(PDO::FETCH_ASSOC);

                return $res;

            }catch(PDOExeption $e){

                echo $e.messege();

                return false;
            }
        }else{
            return false;
        }
    }

    public function get_students_ids_of_class($className){

        if($this->get_validity() <= 2 && $this->is_class_man($className)){
    
            $conn = $this->conn;
    
            try{
    
                $stm = $conn->prepare("select user_id as id from student where class_class = ?");
    
                $stm->bindparam(1,$className);
    
                $stm->execute();
    
                $res = $stm->fetchAll(PDO::FETCH_ASSOC);
    
                return $res;
    
            }catch(PDOExeption $e){
    
                return false;
            }
        }
    
    }

    public function get_grade_man($id){

        try{

            $conn = $this->conn;

            $stm = $conn->prepare("call get_grade_of(?)");

            $stm->bindparam(1,$id);

            $stm->execute();

            $res =$stm->fetchAll(PDO::FETCH_ASSOC);

            $realRes = new grade_man ;

            $realRes->name = $res[0]['fname']." ".$res[0]['lname'];

            $realRes->arabic = $res[0]['total'];

            $realRes->english =$res[1]['total'];

            $realRes->math = $res[2]['total'];

            $realRes->science = $res[3]['total'];

            return $realRes;

        }catch(PDOExeptio $e){

            return false;
        }

    }

    public function get_students_grades_of_class($className){
        if($this->get_validity() <= 2 && $this->is_class_man($className)){
    
            try{

                $temp = $this->get_students_ids_of_class($className);

                $tempRes = array();

                for($i = 0;$i < count($temp);$i++){

                    array_push($tempRes,$this->get_grade_man($temp[$i]['id']));

                }

                return $tempRes;

            }catch(PDOExeption $e){

                return false;
            }
    
        }else{
            return false;
        }
    }

    public function get_teachers_of_class($class){
        if($this->get_validity() <= 2 && $this->is_class_man($class)){

            $conn = $this->conn;

            try{

                $stm = $conn->prepare("select g.fname ,g.lname,g.ssn,g.special
                from get_teacher g ,class_teach c
                where g.id = c.teacher_user_id and c.class_class = ?;");

                $stm->bindparam(1,$class); 

                $stm->execute();

                $res = $stm->fetchAll(PDO::FETCH_ASSOC);

                return $res;

            }catch(PDOExeption $e){

                return false;

            }

        }else{

            return false;
        }
    }

    public function is_special_found($class ,$spec){

        try{

            $teachers = $this->get_teachers_of_class($class);

            $flag = false;

            for($i =0 ;$i<count($teachers);$i++){

                if($spec == $teachers[$i]['special']){

                    $flag = true;

                    break;

                }
            }

            return $flag;

        }catch(PDOExeption $e){

            echo $e->messege();
        }
    }

    public function add_teacher_class($ssn,$class){

        if($this->get_validity() <= 2 && $this->is_teacher_for_maneg($ssn) &&
        $this->is_class_man($class) && !$this->is_special_found($class,$this->get_spec($ssn))){

            $conn = $this->conn;

            $stm = $conn->prepare("call set_teacher_class(?, ?)");

            $stm->bindparam(1,$ssn);

            $stm->bindparam(2,$class);

            $stm->execute();

            return true;

        }else{

            return false;

        }
    }

    public function delete_teacher_class($ssn,$class){

        if($this->get_validity() <= 2 && $this->is_teacher_for_maneg($ssn) &&
        $this->is_class_man($class) && $this->is_special_found($class,$this->get_spec($ssn))){

            $conn = $this->conn;

            $stm = $conn->prepare("call delete_teacher_class(?, ?)");

            $stm->bindparam(1,$ssn);

            $stm->bindparam(2,$class);

            $stm->execute();

            return true;

        }else{

            return false;

        }
    }

    public function clear_teacher_of_class($class){
        if($this->get_validity() <= 2 && $this->is_class_man($class)){

            $conn = $this->conn;

            $stm = $conn->prepare("delete from class_teach where class_class = ?");

            $stm->bindparam(1,$ssn);

            $stm->execute();

            return true;

        }else{

            return false;

        }
    }

}

?>