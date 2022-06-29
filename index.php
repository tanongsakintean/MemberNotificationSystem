<?php
session_start();
include("./connect.php");
if (session_id() != $_SESSION['ses_id']) {
    $statement = $conn->prepare("UPDATE admin_data SET login_status = 0  WHERE ad_id = :ad_id");
    $statement->execute(array(
        ':ad_id' => $_SESSION['ad_id']
    ));
    echo "<script>window.location.replace('Pages/login.php')</script>";
}




require_once("Layouts/header.php");


if (isset($_REQUEST['p'])) {
    require_once("Components/" . $_REQUEST['p'] . ".php");
} else {
    require_once 'Components/default.php';
}
include("Layouts/footer.php");
