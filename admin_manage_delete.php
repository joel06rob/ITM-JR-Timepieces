<?php
require_once "init.php";

//User isn't admin - Redirect
if (!$auth->checkAdmin()){
header("Location: index.php");
exit;
}

$order_id = $_POST['orderid'] ?? '';
$admin = new Admin($conn);
$admin->deleteOrder($order_id);

header("Location: admin_manage.php");
exit;
?>