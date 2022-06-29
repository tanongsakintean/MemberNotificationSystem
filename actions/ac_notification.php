<?php
include("../connect.php");
session_start();



$req = json_decode(file_get_contents("php://input"));

switch ($req->action) {
    case 'clearSv':
        $statement = $conn->prepare("DELETE FROM warn_sv WHERE sv_id = :sv_id");
        $statement->execute(array(':sv_id' => $req->sv_id));

        if ($statement->rowCount() != 1) {
            echo 1;
        }
        break;

    case 'clearNoti':
        $statement = $conn->prepare("DELETE FROM warn_noti WHERE noti_id = :noti_id");
        $statement->execute(array(':noti_id' => $req->noti_id));

        if ($statement->rowCount() != 1) {
            echo 1;
        }

        break;
}
