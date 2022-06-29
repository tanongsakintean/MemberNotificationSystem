<?php
include("connect.php");
include("class/Havesms.php");
session_start();

$sms = new Havesms($token);

// ///check service date 
$statement = $conn->prepare("SELECT * FROM service_data WHERE SUBSTRING(sv_end, 7, 5) = :year");
$statement->execute(array(
    ':year' => (Date("Y")  + 543)
));

$sv = $statement->fetchAll();
$date = new DateTime();

foreach ($sv as $key => $val) {
    $sv_end = (substr($val['sv_end'], 6, 10) - 543) . "-" . substr($val['sv_end'], 3, 2) . "-" . substr($val['sv_end'], 0, 2) . "T" . substr($val['sv_end'], 11, 16);
    ///ถ้าเวลาใกล้เข้ามาใน 7 วัน ก็แจ้งเตือน
    if ((strtotime($sv_end) - $date->getTimestamp())  < 600000) {
        $statement = $conn->prepare("SELECT * FROM service_data WHERE sv_id = :id AND sv_status = 0");
        $statement->execute(array(
            ':id' => $val['sv_id']
        ));

        ///ถ้าวันตรงกันส่งsms 
        if ($statement->rowCount() == 1) {
            if ((strtotime($sv_end) - $date->getTimestamp()) < 1) {
                $statement = $conn->prepare("UPDATE service_data SET sv_status = '1' WHERE sv_id = :id");
                $statement->execute(array(
                    ':id' => $val['sv_id']
                ));

                if ($statement->rowCount() == 1) {
                    ///sms send meg 

                    $statement = $conn->prepare("INSERT INTO warn_sv (sv_id) VALUES (:sv_id)");
                    $statement->execute(array(
                        ':sv_id' => $val['sv_id']
                    ));

                    // $statement = $conn->prepare("DELETE FROM service_data WHERE sv_id = :id");
                    // $statement->execute(array(
                    //     ':id' => $val['sv_id']
                    // ));
                }
            } else {
                if ($val['sv_status'] != 2 && $val['sv_status'] == 0) {
                    $statement = $conn->prepare("UPDATE service_data SET sv_status = 2 WHERE sv_id = :id");
                    $statement->execute(array(
                        ':id' => $val['sv_id']
                    ));

                    if ($statement->rowCount() == 1) {

                        $statement = $conn->prepare("INSERT INTO warn_sv (sv_id) VALUES (:id)");
                        $statement->execute(array(
                            ':id' => $val['sv_id']
                        ));
                    }


                    $statement = $conn->prepare("SELECT * FROM notify_data WHERE sv_id = :sv_id AND SUBSTRING(noti_end, 7, 5) = :year");
                    $statement->execute(array(
                        ':sv_id' => $val['sv_id'],
                        ':year' => (Date("Y")  + 543)
                    ));
                    $noti = $statement->fetchAll();

                    foreach ($noti as $key => $val) {
                        $noti_end = (substr($val['noti_end'], 6, 10) - 543) . "-" . substr($val['noti_end'], 3, 2) . "-" . substr($val['noti_end'], 0, 2) . "T" . substr($val['sv_end'], 11, 16);

                        if ((strtotime($noti_end) - $date->getTimestamp())  < 600000) {
                            if ($val['noti_status'] != 2) {
                                $statement = $conn->prepare("UPDATE notify_data SET noti_status = 2 WHERE noti_id = :id");
                                $statement->execute(array(
                                    ':id' => $val['noti_id']
                                ));

                                if ($statement->rowCount() == 1) {
                                    $statement = $conn->prepare("INSERT INTO warn_noti (noti_id) VALUES (:id)");
                                    $statement->execute(array(
                                        ':id' => $val['noti_id']
                                    ));
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}


$statement = $conn->prepare("SELECT * FROM notify_data WHERE sv_id = 0 AND SUBSTRING(noti_end, 7, 5) = :year");
$statement->execute(array(
    ':year' => (Date("Y")  + 543)
));
$noti = $statement->fetchAll();

foreach ($noti as $key => $val) {
    $noti_end = (substr($val['noti_end'], 6, 10) - 543) . "-" . substr($val['noti_end'], 3, 2) . "-" . substr($val['noti_end'], 0, 2) . "T" . substr($val['noti_end'], 11, 16);

    if ((strtotime($noti_end) - $date->getTimestamp())  < 600000) {

        $statement = $conn->prepare("SELECT * FROM notify_data WHERE noti_id = :id AND noti_status = 0 AND sv_id = 0");
        $statement->execute(array(
            ':id' => $val['noti_id']
        ));

        if ($statement->rowCount() == 1) {
            if ((strtotime($noti_end) - $date->getTimestamp()) < 1) {
                $statement = $conn->prepare("UPDATE notify_data SET noti_status = '1' WHERE noti_id = :id");
                $statement->execute(array(
                    ':id' => $val['noti_id']
                ));

                if ($statement->rowCount() == 1) {
                    $statement = $conn->prepare("INSERT INTO warn_noti (noti_id) VALUES (:id)");
                    $statement->execute(array(
                        ':id' => $val['noti_id']
                    ));

                    ///sms send meg 
                    // $response = $sms
                    //     ->setSender($sender)
                    //     ->setMsisdn($val)
                    //     ->setMessage($message)
                    //     ->send();

                    // $statement = $conn->prepare("DELETE notify_data WHERE noti_id = :id");
                    // $statement->execute(array(
                    //     ':id' => $val['noti_id']
                    // ));
                }
            } else {
                if ($val['noti_status'] != 2 && $val['noti_status'] != 1) {
                    $statement = $conn->prepare("UPDATE notify_data SET noti_status = 2 WHERE noti_id = :id");
                    $statement->execute(array(
                        ':id' => $val['noti_id']
                    ));
                    ///เก็บใน session

                    if ($statement->rowCount() == 1) {
                        $statement = $conn->prepare("INSERT INTO warn_noti (noti_id) VALUES (:id)");
                        $statement->execute(array(
                            ':id' => $val['noti_id']
                        ));
                    }
                }
            }
        }
    }
}
