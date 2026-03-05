<?php

class Cart{

    public function getCart(){
        return $_SESSION['cart'] ?? [];
    }

    public function addToCart($productId, $quantity = 1){
        if(!isset($_SESSION['cart'])){
            $_SESSION['cart'] = [];
        }

        //Check if the item has been added already, if so increment the current quantity, else add it.
        if(isset($_SESSION['cart'][$productId])){
            $_SESSION['cart'][$productId] += $quantity;
        }
        else{
            $_SESSION['cart'][$productId] = $quantity;
        }
    }


}


?>