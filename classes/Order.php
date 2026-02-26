<?php

class Order {
    private $conn;

    function __construct($conn){
        $this->conn = $conn;
        
    }

    public function countAllOrders(){
        $sql = "SELECT COUNT(*) AS TotalOrders FROM Orders";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result)['TotalOrders'];
    }

    public function countUnprocessedOrders(){
        $sql = "SELECT COUNT(*) AS UnprocessedOrders FROM Orders WHERE Status = 'Processing'";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result)['UnprocessedOrders'];
    }

    public function countOrdersByDate(){
        $sql = "SELECT DATE(OrderDate) as OrderDate_Simplified, COUNT(*) as TotalOrdersPerDate FROM Orders GROUP BY DATE(OrderDate) ORDER BY OrderDate_Simplified ASC";
        $result = mysqli_query($this->conn, $sql);

        $data = array();
        foreach($result as $row){
            $data[] = $row;
        }
        return $data;
    }
}


?>