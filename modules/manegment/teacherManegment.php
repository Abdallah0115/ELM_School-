<?php

trait teacher_man{

    public function add_teacher($fn,$ln,$phone,$brith,$ssn,$sal,$spec){

        if($this->get_validity() <= 2 && $this->is_spec($spec)){

            $conn = $this->conn;

            $email = $fn . $ln . $ssn . "@school.com";

            $pass = hash("md5","school_user",false);

            try{

                $stm = $conn->prepare("call add_user(?,?,?,?,?,?) ;
                call add_teacher(?,?,?);");

                $stm->bindparam(1,$fn);

                $stm->bindparam(2,$ln);

                $stm->bindparam(3,$phone);

                $stm->bindparam(4,$brith);

                $stm->bindparam(5,$pass);

                $stm->bindparam(6,$ssn);

                $stm->bindparam(7,$email);

                $stm->bindparam(8,$sal);

                $stm->bindparam(9,$spec);

                $stm->execute();

            }catch(PDOExeption $e){

                echo "feild";

            }

        }else{

            echo "not valid";
        }
    }
}

trait edit_teacher{

    public function is_spec($spec){
        $arr= ['arabic','math','science','english'];

        for($i=0;$i<4;$i++)
            if($spec == $arr[$i])
                return true;

        return false;
    }

    public function is_teacher_for_maneg($ssn){

        try{
            $conn = $this->conn;

            $stm = $conn->prepare("select count(id) as count from get_teacher where ssn = ?");

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

    public function get_spec($ssn){
        if($this->get_validity() <= 2 && $this->is_teacher_for_maneg($ssn)){
            $conn = $this->conn;
            try{
                $stm = $conn->prepare("select t.special as sp
                from teacher t , user u
                where u.id = t.user_id and u.ssn=?");

                $stm->bindparam(1,$ssn);

                $stm->execute();

                $res = $stm->fetchAll(PDO::FETCH_ASSOC);

                return $res[0]['sp'];
            }catch(PDOExeption $e){

                return false;
            }
        }else{
            return false;
        }
    }

    public function edit_teacher_name($ssn,$fname,$lname){

        if($this->get_validity() <= 2 && $this->is_teacher_for_maneg($ssn)){
    
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

    public function edit_phone_teacher_for_maneg($ssn,$phone){

        if($this->get_validity() <= 2 && $this->is_teacher_for_maneg($ssn)){

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

    public function edit_teacher_birthDate($ssn,$birth){

        if($this->get_validity() <= 2 && $this->is_teacher_for_maneg($ssn)){

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

    public function edit_password_teacher_for_maneg($ssn,$pass){

        if($this->get_validity() <= 2 && $this->is_teacher_for_maneg($ssn)){

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

    public function edit_selary_teacher($ssn,$sal){

        if($this->get_validity() <= 2 && $this->is_teacher_for_maneg($ssn)){

            $conn = $this->conn;
    
            try{
    
                $stm = $conn->prepare("update  teacher
                set salery = ?
                where user_id = (select id from user where ssn = ?);");
    
                $stm->bindparam(1,$sal);
    
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

    public function edit_speciality($ssn,$spec){

        if(!$this->is_spec($spec)){
            return false;
        }

        if($this->get_validity() <= 2 && $this->is_teacher_for_maneg($ssn)){

            $conn = $this->conn;
        
            try{
        
                $stm = $conn->prepare("update  teacher
                set special = ?
                where user_id = (select id from user where ssn = ?);");
        
                $stm->bindparam(1,$spec);
        
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

}

?>