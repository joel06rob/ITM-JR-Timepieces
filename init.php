<?php
    //Every page that needs auth will use this method i.e. login, checking user state (profile etc), admin pages
    //Handles session_start()
    session_start();
    require_once "autoloader.php";

    $db = new Database();
    $conn = $db->connect();

    $auth = new Auth($conn);

?>