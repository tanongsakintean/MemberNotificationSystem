<?php
session_start();
include("../connect.php");

$statement = $conn->prepare("UPDATE admin_data SET login_status = 0  WHERE ad_id = :ad_id");
$statement->execute(array(
    ':ad_id' => $_SESSION['ad_id']
));
session_destroy();
echo "<script>window.location.replace('../index.php')</script>";
