<?php

class Order {
    private $conn;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function createOrder($user_id, $cart){
        
        //Pre-Set values
        // Created (Timestamp: Now)
        // Initial Status: Processing
        $created = date("Y-m-d H:i:s");
        $status = "Processing";

        $sql = "INSERT INTO Orders (CustomerID, OrderDate, Status) VALUES (?, ?, ?)";
        $stmt = mysqli_stmt_init($this->conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            echo "ERROR: SQL STMT FAILED";
            return;
        }
        
        mysqli_stmt_bind_param($stmt, "iss", $user_id, $created, $status);
        mysqli_stmt_execute($stmt);

        //Get the inserted ID to Orders
        $order_id = mysqli_insert_id($this->conn);
        $product_ids = implode(",", array_keys($cart));

        $sql = "SELECT ID, Price FROM Product WHERE ID IN ($product_ids)";
        $result = mysqli_query($this->conn, $sql);

        //Loop through all products in Cart
        while($row = mysqli_fetch_assoc($result)){
            $product_id = $row['ID'];
            $price = $row['Price'];
            $quantity = $cart[$product_id];

            //Insert into Orders_Items each individual item
            $sql = "INSERT INTO Orders_Items (ProductID, OrderID, Quantity, PriceAtPurchase) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($this->conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                echo "ERROR: SQL STMT FAILED";
                return;
            }
            
            mysqli_stmt_bind_param($stmt, "iiid", $product_id, $order_id, $quantity, $price);
            mysqli_stmt_execute($stmt);
        }
        
        return true;
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

    public function countRevenueLast30Days(){
        $sql = "SELECT COALESCE(SUM(oi.PriceAtPurchase * oi.Quantity), 0) AS TotalRevenueThirty FROM Orders_Items oi JOIN Orders o ON o.ID = oi.OrderID WHERE o.Status = 'Completed' AND o.OrderDate >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result)['TotalRevenueThirty'];
    }
    

    public function countMostPopular(){
        $sql = "SELECT p.Name, SUM(oi.Quantity) AS TotalUnitsSold FROM Orders_Items oi JOIN Product p ON p.ID = oi.ProductID JOIN Orders o ON o.ID = oi.OrderID WHERE o.Status = 'Completed' GROUP BY p.Name ORDER BY TotalUnitsSold DESC LIMIT 1";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function countUnitsSold(){
        $sql = "SELECT p.Name, COALESCE(SUM(oi.Quantity), 0) AS TotalUnitsSold FROM Product p LEFT JOIN Orders_Items oi on p.ID = oi.ProductID LEFT JOIN Orders o ON o.ID = oi.OrderID AND o.Status = 'Completed' GROUP BY p.ID, p.Name ORDER BY TotalUnitsSold DESC";
        $result = mysqli_query($this->conn, $sql);

        $data= array();
        foreach($result as $row){
            $data[] = $row;
        }
        return $data;
    }
}


?>