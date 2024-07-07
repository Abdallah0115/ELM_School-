<?php

trait stu_man{

    public function add_student($fn,$ln,$phone,$brith,$ssn,$class,$lev){

        if($this->get_validity() <= 2){

            $conn = $this->conn;

            $email = $fn . $ln . $ssn . "@school.com";

            $pass = hash("md5","school_user",false);

            try{

                $stm = $conn->prepare("call add_user(?,?,?,?,?,?) ;
                call add_student(?,?,?);");

                $stm->bindparam(1,$fn);

                $stm->bindparam(2,$ln);

                $stm->bindparam(3,$phone);

                $stm->bindparam(4,$brith);

                $stm->bindparam(5,$pass);

                $stm->bindparam(6,$ssn);

                $stm->bindparam(7,$lev);

                $stm->bindparam(8,$class);

                $stm->bindparam(9,$email);

                $stm->execute();

                return true;

            }catch(PDOExeption $e){

                echo "feild";

                return false;

            }

        }else{

            return false;
        }
    }
}

trait edit_stu{

    public function is_stu_for_maneg($ssn){

        try{
            $conn = $this->conn;

            $stm = $conn->prepare("select count(id) as count from git_students where ssn = ?");

            $stm->bindparam(1,$ssn);

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

    public function is_stu_for_maneg2($id){

        try{
            $conn = $this->conn;

            $stm = $conn->prepare("select count(ssn) from git_students where id = ?");

            $stm->bindparam(1,$id);

            $stm->execute();

            $res = $stm->fetchAll(PDO::FETCH_ASSOC);

            if($res[0]['count(ssn)'] == 1){

                return true;

            }else{
                echo "feild";
                return false;
            }
        }catch(PDOExeption $e){

            return false;

        }
    }

    public function code_of_sub($id,$subName){
        try{

            $conn = $this->conn;

            $stm = $conn->prepare("select code_of_sub(?,?) as code");

            $stm->bindparam(1,$id);

            $stm->bindparam(2,$subName);

            $stm->execute();

            $res = $stm->fetchAll(PDO::FETCH_ASSOC);

            return $res[0]['code'];

        }catch(PDOExeption $e){
            return false;
        }
    }

    public function count_came($id,$sub_code){
        try{
            $conn = $this->conn;

            $stm = $conn->prepare("select count_sub(?,?) as conti;");

            $stm->bindparam(1,$id);

            $stm->bindparam(2,$sub_code);

            $stm->execute();
            $res = $stm->fetchAll(PDO::FETCH_ASSOC);

            return $res[0]['conti'];

        }catch(PDOExeptio $e){

            return false;

        }
    }

    public function is_class($class){

        try{
            $conn = $this->conn;

            $stm = $conn->prepare("select count(class) as count from class where class = ?");

            $stm->bindparam(1,$class);

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

    public function edit_stu_name($ssn,$fname,$lname){

        if($this->get_validity() <= 2 && $this->is_stu_for_maneg($ssn)){

            $conn = $this->conn;

            try{

                $stm = $conn->prepare("update  user
                set fname = ? ,lname = ?
                where ssn = ?;");

                $stm->bindparam(1,$fname);

                $stm->bindparam(2,$lname);

                $stm->bindparam(3,$ssn);

                $stm->execute();

                return true;

            }catch(PDOExeption $e){

                echo $e->messege();

                return false;

            }

        }else{
            return  false;
        }

    }

    public function edit_phone_stu_for_maneg($ssn,$phone){

        if($this->get_validity() <= 2 && $this->is_stu_for_maneg($ssn)){

            $conn = $this->conn;

            try{

                $stm = $conn->prepare("update user
                set phone = ?
                where ssn = ?;");

                $stm->bindparam(1,$phone);

                $stm->bindparam(2,$ssn);

                $stm->execute();

                return true;

            }catch(PDOExeption $e){

                echo $e->messege();

                return false;

            }

        }else{
            return  false;
        }
    }

    public function edit_stu_birthDate($ssn,$birth){

        if($this->get_validity() <= 2 && $this->is_stu_for_maneg($ssn)){

            $conn = $this->conn;

            try{

                $stm = $conn->prepare("update  user
                set bdate = ?
                where ssn = ?;");

                $stm->bindparam(1,$birth);

                $stm->bindparam(2,$ssn);

                $stm->execute();

                return true;

            }catch(PDOExeption $e){

                echo $e->messege();

                return false;

            }

        }else{
            return  false;
        }
    }

    public function edit_password_stu_for_maneg($ssn,$pass){

        if($this->get_validity() <= 2 && $this->is_stu_for_maneg($ssn)){

            $conn = $this->conn;

            $passHashed = hash("md5",$pass,false);

            try{

                $stm = $conn->prepare("update  user
                set password = ?
                where ssn = ?;");

                $stm->bindparam(1,$passHashed);

                $stm->bindparam(2,$ssn);

                $stm->execute();

                return true;

            }catch(PDOExeption $e){

                echo $e->messege();

                return false;

            }

        }else{
            return  false;
        }
    }

    public function edit_level($ssn,$level){

        if($level>3||$level<1)
            return false ;

        if($this->get_validity() <= 2 && $this->is_stu_for_maneg($ssn)){

            $conn = $this->conn;
    
            try{
    
                $stm = $conn->prepare("update  student
                set leve = ?
                where user_id = (select id from user where ssn = ?);");
    
                $stm->bindparam(1,$level);
    
                $stm->bindparam(2,$ssn);
    
                $stm->execute();
    
                return true;
    
            }catch(PDOExeption $e){
    
                echo $e->messege();
    
                return false;
    
            }
    
        }else{
            return  false;
        }
    }

    public function edit_class($ssn,$class){

        if(!$this->is_class($class))
        return false ;

        if($this->get_validity() <= 2 && $this->is_stu_for_maneg($ssn)){

            $conn = $this->conn;

            try{

                $stm = $conn->prepare("update  student
                set class_class = ?
                where user_id = (select id from user where ssn = ?);");

                $stm->bindparam(1,$class);

                $stm->bindparam(2,$ssn);

                $stm->execute();

                return true;

            }catch(PDOExeption $e){

                echo $e->messege();

                return false;

            }

        }else{
            return  false;
        }
    }

    public function set_grades_mid_of_stu($id ,$subName ,$deg){

        $sub_code = $this->code_of_sub($id,$subName);

        $sub_count = $this->count_came($id,$sub_code); 

        if($this->get_validity() <= 3 && $this->is_stu_for_maneg2($id) && $sub_count == 0){

            try{

                $conn = $this->conn;

                $stm = $conn->prepare("call set_grades_mid_of(?,?,?)");

                $stm->bindparam(1,$id);

                $stm->bindparam(2,$subName);

                $stm->bindparam(3,$deg);

                $stm->execute();

                return true;

            }catch(PDOExeption $e){

                return false;

            }

        }else{
            return false;
        }
    }

    public function set_grades_final_of_stu($id,$subName,$deg){

        $sub_code = $this->code_of_sub($id,$subName);

        $sub_count = $this->count_came($id,$sub_code);

        if($this->get_validity() <= 3 && $this->is_stu_for_maneg2($id) && $sub_count){

            try{

                $conn = $this->conn;

                $stm = $conn->prepare("call set_grades_final_of(?,?,?)");

                $stm->bindparam(1,$id);

                $stm->bindparam(2,$subName);

                $stm->bindparam(3,$deg);

                $stm->execute();

                return true;

            }catch(PDOExeption $e){

                return false;

            }

        }else{
            return false;
        }
    }

    public function edit_grades_mid_of_stu($id,$subName,$deg){
        $sub_code = $this->code_of_sub($id,$subName);

        $sub_count = $this->count_came($id,$sub_code);

        if($this->get_validity() <= 3 && $this->is_stu_for_maneg2($id) && $sub_count){

            try{

                $conn = $this->conn;

                $stm = $conn->prepare("call update_grades_mid_of(?,?,?)");

                $stm->bindparam(1,$id);

                $stm->bindparam(2,$subName);

                $stm->bindparam(3,$deg);

                $stm->execute();

                return true;

            }catch(PDOExeption $e){

                return false;

            }

        }else{
            return false;
        }
    }
}
?>