<?php
include("../connect.php");
session_start();
$req = json_decode(file_get_contents("php://input"));

if (isset($req)) {
    switch ($req->action) {
        case 'login':
            $statement = $conn->prepare("SELECT * FROM admin_data WHERE ad_email = '" . $req->email . "' AND ad_password = '" . $req->password . "'");
            $statement->execute();
            if ($statement->rowCount() == 1) {
                $result = $statement->fetch(PDO::FETCH_ASSOC);
                if ($result['login_status'] == 0) {
                    $statement = $conn->prepare("UPDATE admin_data SET login_status = '1' WHERE ad_id = '" . $result['ad_id'] . "'");
                    $statement->execute();
                    $_SESSION['ses_id'] = session_id();
                    $_SESSION['ad_id'] = $result['ad_id'];
                    $_SESSION['ses_name'] = $result['ad_name'];
                    $_SESSION['ses_tel'] = $result['ad_tel'];
                    $_SESSION['ses_lastLogin'] = $result['last_login'];
                    $_SESSION['ses_noti_data'] = array();
                    $_SESSION['ses_sv_data'] = array();
                    echo  1;
                } else {
                    echo 3;
                }
            } else {
                echo 2;
            }
            break;
        case 'forgetpassword':
            $statement = $conn->prepare("SELECT * FROM admin_data WHERE ad_email = :email AND ad_tel = :tel");
            $statement->execute(array(
                ':email' => $req->email,
                ':tel' => $req->tel
            ));
            $id = $statement->fetch(PDO::FETCH_ASSOC);
            if ($statement->rowCount() == 1) {
                $user = array(
                    'id' => $id['ad_id'],
                    'status' => 1,
                );
                echo json_encode($user);
            } else {
                $user = array(
                    'id' => 0,
                    'status' => 2,
                );
                echo json_encode($user);
            }
            break;
        case 'newpassword':
            ///check online ? before update
            $statement = $conn->prepare("SELECT * FROM admin_data WHERE ad_id = :id");
            $statement->execute(array(
                ':id' => $req->id
            ));

            if ($statement->rowCount() == 1) {
                $result = $statement->fetch(PDO::FETCH_ASSOC);
                if ($result['login_status'] == 1) {
                    echo 3;
                } else {
                    if ($req->newpassword == $req->confirmpassword) {
                        $statement = $conn->prepare("UPDATE admin_data SET ad_password = :password WHERE ad_id = :id");
                        $statement->execute(array(
                            ':password' => $req->newpassword,
                            ':id' => $req->id
                        ));
                        if ($statement->rowCount() == 1) {
                            echo 1;
                        } else {
                            echo 2;
                        }
                    } else {
                        echo 2;
                    }
                }
            }


            break;
        default:
            # code...
            break;
    }
}
