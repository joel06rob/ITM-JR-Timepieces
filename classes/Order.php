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

        //Get the inserted ID in Orders
        $order_id = mysqli_insert_id($this->conn);

        //Get the products in the cart
        $product_ids = implode(",", array_keys($cart));

        $sql = "SELECT ID, Price FROM Product WHERE ID IN ($product_ids)";
        $result = mysqli_query($this->conn, $sql);

        //Update stock
        $product = new Product($this->conn);

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

            //Update stock for each item
            $product->updateStock($product_id);
        }
        
        return $order_id;
    }


    public function getAllUserOrders($user_id){
        $sql = "SELECT * FROM Orders WHERE CustomerID = ?";
        $stmt = mysqli_stmt_init($this->conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            echo "ERROR: SQL STMT FAILED";
            return;
        }
        
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);

        //Get the results and input into array to return
        $result = mysqli_stmt_get_result($stmt);
        $orders= array();
        foreach($result as $row){
            $orders[] = $row;
        }

        return $orders;
        
        
    }

    
}


?>