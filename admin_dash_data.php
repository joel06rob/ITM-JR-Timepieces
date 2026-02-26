<?php

require_once "init.php";

//User isn't admin - Forbid 403
if (!$auth->checkAdmin()){
  http_response_code(403);
  exit;
}

$orders = new Order($conn);
$totalOrders = $orders->countAllOrders();
$unprocessedOrders = $orders->countUnprocessedOrders();
$totalOrdersByDate = $orders->countOrdersByDate();


//Assoc array for JSON
$data = [
    "totalOrders" => $totalOrders,
    "totalUnprocessedOrders" => $unprocessedOrders,
    "totalOrdersByDate" => $totalOrdersByDate
];

//JSON response
header('Content-Type: application/json');
echo json_encode($data);
exit;
?>