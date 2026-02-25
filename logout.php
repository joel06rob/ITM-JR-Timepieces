<?php
require_once "init.php";

if($auth->checkUser()){
    $auth->logoutUser();
}

header("Location: index.php");


?>