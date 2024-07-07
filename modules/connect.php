<?php

#-----------------interface to insure connection-----------
interface is_connected{

    public function is_connected();

}

#-------------this class for connection of database--------- 
abstract class connect implements is_connected{

    protected $conn = NULL;

    const SERNAME = 'localhost' ;

    const USERNAME = 'root' ;

    const PASS = "" ;

    const DBNAME = 'school' ;

    public function __construct(){

        try{

            $temp = sprintf('mysql:host=%s;dbname=%s',self::SERNAME,self::DBNAME);

            $this->conn = new PDO($temp,self::USERNAME,self::PASS);

        }catch(PDOExeption $e){

            echo "feild to connect" ;

        }

    }

    public function is_connected(){

        if($this->conn ==NULL)

            return false;

        else  return true;

    }

    public function __destructor(){

        $this->conn = NULL ;

    }

}

?>