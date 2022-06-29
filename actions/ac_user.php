<?php
include("../connect.php");
session_start();
$req = json_decode(file_get_contents("php://input"));

if (isset($req)) {
    switch ($req->action) {
        case "add":
            $statement = $conn->prepare("SELECT * FROM user_data WHERE  user_email = '" . $req->email . "'");
            $statement->execute();
            if ($statement->rowCount() == 1) {
                echo 1;
            } else {
                $statement = $conn->prepare("INSERT INTO user_data (user_name,user_email,user_tel) VALUES (:user_name,:user_email,:user_tel)");
                $statement->execute(array(
                    ':user_name' => $req->fullName,
                    ':user_email' => $req->email,
                    ':user_tel' => $req->tel
                ));

                if ($statement->rowCount() == 1) {
                    echo 2;
                } else {
                    echo 3;
                }
            }
            break;

        case "update":
            $statement = $conn->prepare("UPDATE user_data SET user_email = :email , user_name = :name , user_tel = :tel WHERE user_id = :id");
            $statement->execute(array(
                ':email' => $req->email,
                ':name' => $req->fullName,
                ':tel' => $req->tel,
                ':id' => $req->id
            ));

            if ($statement->rowCount() > 0) {
                echo 1;
            }
            break;
        case "del":
            $statement = $conn->prepare("DELETE FROM user_data WHERE user_id = :id ");
            $statement->execute(array(
                ':id' => $req->id
            ));

            if ($statement->rowCount() == 1) {

                $status = delUserMessage($conn, $req->id);
                if ($status == 1) {
                    echo 1;
                } else if ($status == 3) {
                    echo 1;
                } else {
                    echo 2;
                }
            }
            break;
        case "getTel":
            $statement = $conn->prepare("SELECT user_id,user_name,user_tel FROM user_data ");
            $statement->execute();
            $result = $statement->fetchAll();
            echo json_encode($result);
            break;
    }
}


function delUserMessage($conn, $id)
{

    $statement = $conn->prepare("DELETE FROM notify_data_item WHERE user_id = :user_id ");
    $statement->execute(array(
        ':user_id' => $id
    ));


    if ($statement->rowCount() > 0) {
        return 1;
    } else if ($statement->rowCount() == 0) {
        return 3;
    } else {
        return 2;
    }
}
