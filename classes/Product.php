<?php
class Product {
    private $conn;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getProducts($searchterm){
        if($searchterm == "all"){
            $sql = "SELECT * FROM Product";
        }
        else{

            $sql = "SELECT * FROM Product WHERE Name LIKE ?";
        }

        $stmt = mysqli_stmt_init($this->conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                echo "ERROR: SQL STMT FAILED";
                return;
            }
        
        if($searchterm != "all"){
            $searchterm = "%" . $searchterm . "%";
            mysqli_stmt_bind_param($stmt, "s", $searchterm);
        }
        mysqli_stmt_execute($stmt);

        //Get the results and input into array to return
        $result = mysqli_stmt_get_result($stmt);
        $products= array();
        foreach($result as $row){
            $products[] = $row;
        }

        return $products;
    }

    public function getShowcaseProducts(){
        $sql = "SELECT * FROM Product WHERE ID = 3 OR ID = 10 OR ID = 6";
        $result = mysqli_query($this->conn, $sql); 

        return $result;
    }

    public function updateStock($product_id){
        $sql = "UPDATE Product SET Stock = Stock - 1 WHERE ID = ?";
        $stmt = mysqli_stmt_init($this->conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            echo "ERROR: SQL STMT FAILED";
            return;
        }
        mysqli_stmt_bind_param($stmt, "i", $product_id);
        mysqli_stmt_execute($stmt);
    }

}


?>