<?php
trait add_maneger{
    public function add_man($fn,$ln,$phone,$brith,$ssn,$sal){

        if($this->get_validity() === 1){

            $conn = $this->conn;

            $email = $fn . $ln . $ssn . "@school.com";

            $pass = hash("md5","school_user",false);

            try{

                $stm = $conn->prepare("call add_user(?,?,?,?,?,?) ;
                call add_man(?,?);");

                $stm->bindparam(1,$fn);

                $stm->bindparam(2,$ln);

                $stm->bindparam(3,$phone);

                $stm->bindparam(4,$brith);

                $stm->bindparam(5,$pass);

                $stm->bindparam(6,$ssn);

                $stm->bindparam(7,$email);

                $stm->bindparam(8,$sal);

                $stm->execute();

            }catch(PDOExeption $e){

                echo "feild";

            }

        }else{

            echo "not valid";
        }
    }
}

trait man_man{
    public function is_man_for_maneg($ssn){

        try{
            $conn = $this->conn;

            $stm = $conn->prepare("select count(id) as count from get_maneg where ssn = ?");

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

    public function edit_man_name($ssn,$fname,$lname){

        if($this->get_validity() == 1 && $this->is_man_for_maneg($ssn)){
    
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

    public function edit_phone_man_for_maneg($ssn,$phone){

        if($this->get_validity() == 1 && $this->is_man_for_maneg($ssn)){

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

    public function edit_man_birthDate($ssn,$birth){

        if($this->get_validity() == 1 && $this->is_man_for_maneg($ssn)){

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

    public function edit_password_man_for_maneg($ssn,$pass){

        if($this->get_validity() == 1 && $this->is_man_for_maneg($ssn)){

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

    public function edit_selary_man($ssn,$sal){

        if($this->get_validity() == 1 && $this->is_man_for_maneg($ssn)){

            $conn = $this->conn;
    
            try{
    
                $stm = $conn->prepare("update manger
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

    public function set_time_mid_grades($ssn,$level,$time){

        if($this->get_validity() == 1 && $this->is_man_for_maneg($ssn)){
    
            $conn = $this->conn;

            $id = $this->id;
    
            try{
    
                $stm = $conn->prepare("update  level
                set date_of_grades_of_mid = ?,manger_user_id = ?
                where level = ?;");
    
                $stm->bindparam(1,$time);
    
                $stm->bindparam(2,$id);
    
                $stm->bindparam(3,$level);
    
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

    public function set_time_final_grades($ssn,$level,$time){

        if($this->get_validity() == 1 && $this->is_man_for_maneg($ssn)){
    
            $conn = $this->conn;

            $id = $this->id;
    
            try{
    
                $stm = $conn->prepare("update  level
                set date_of_grades_final = ?,manger_user_id = ?
                where level = ?;");
    
                $stm->bindparam(1,$time);
    
                $stm->bindparam(2,$id);
    
                $stm->bindparam(3,$level);
    
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