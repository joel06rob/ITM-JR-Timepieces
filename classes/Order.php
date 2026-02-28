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

    public function countTotalRevenue(){
        $sql = "SELECT SUM(PriceAtPurchase * Quantity) AS TotalRevenue FROM Orders_Items oi JOIN Orders o ON o.ID = oi.OrderID WHERE o.Status = 'Completed'";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result)['TotalRevenue'];
    }

    public function countRevenueByDate(){
        $sql = "SELECT DATE(o.OrderDate) AS RevenueDate, SUM(oi.PriceAtPurchase * oi.Quantity) AS TotalRevenue FROM Orders o JOIN Orders_Items oi ON o.ID = oi.OrderID WHERE o.Status = 'Completed' GROUP BY DATE(o.OrderDate) ORDER BY RevenueDate ASC";
        $result = mysqli_query($this->conn, $sql);

        $data= array();
        foreach($result as $row){
            $data[] = $row;
        }
        return $data;
    }
}


?>