<?php

require_once "init.php";

//User isn't admin - Forbid 403
if (!$auth->checkAdmin()){
  http_response_code(403);
  exit;
}

$test = new Test($conn);
$totalUsers = $test->testCountAllUsers();


//Assoc array for JSON
$data = [
    "totalUsers" => $totalUsers
];

//JSON response
header('Content-Type: application/json');
echo json_encode($data);
exit;
?>