<?php

class User {

    //Database connection property to connect to DB for inserting users.
    private $conn;

    //Constructor for handling database connection ($conn)
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    //Method to create new Users
    //Uses: Hashing for passwords and prepared statments for record creation
    public function createUser($fname, $sname ,$email, $password){

        $usertype = "User";
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        //Created (Timestamp: Now)
        $created = date("Y-m-d H:i:s");

        //SQL
        $sql = "INSERT INTO User (Fname, Sname, Email, Password, Usertype, Created) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($this->conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            echo "ERROR: SQL STMT FAILED";
        }
        else{
            mysqli_stmt_bind_param($stmt, "ssssss", $fname, $sname, $email, $hashed_password, $usertype, $created);

        //TODO: Add a return value to notify user of successful user signup.
            $execute_result = mysqli_stmt_execute($stmt);
            if(!$execute_result){
                return false;
            }
            else{
                return true;
            }
        }
    }

}

?>