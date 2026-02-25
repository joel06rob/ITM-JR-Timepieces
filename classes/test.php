<?php
//----------TESTING CLASS-----------

class Test {
    private $conn;

    function __construct($conn){
        $this->conn = $conn;
        
    }

    public function testCountAllUsers(){
        $sql = "SELECT COUNT(*) AS Total FROM User";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result)['Total'];
    }
}


?>