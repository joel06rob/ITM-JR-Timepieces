<?php

class Database {

    //TODO: Swap out for environment variables
    //Objects of the class, access with $this
    private $server = "localhost";
    private $username = "username";
    private $password = "password";
    private $dbname = "jrtimepieces";
    private $conn;

    public function connect(){
        
        $this->conn = null;
        
        $this->conn = mysqli_connect($this->server, $this->username, $this->password, $this->dbname);
        
        if(!$this->conn){
            die("Connection Failed");
        }

        return $this->conn;

    }
}


?>