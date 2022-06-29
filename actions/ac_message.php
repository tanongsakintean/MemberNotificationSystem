<?php
include("../connect.php");
include("../Class/Havesms.php");
session_start();

$sms = new Havesms($token);
$req = json_decode(file_get_contents("php://input"));
if (isset($req)) {
    switch ($req->action) {
        case "getTelsingle":
            $statement = $conn->prepare("SELECT * FROM `guest_data` WHERE `noti_id` = :id");
            $statement->execute(array(':id' => $req->id));

            if ($statement->rowCount() > 0) {
                $result = $statement->fetchAll();
                echo json_encode($result);
            }
            break;
        case "getTelmultiple":
            $statement = $conn->prepare("SELECT noti_selected FROM notify_data WHERE noti_id = :id");
            $statement->execute(array(':id' => $req->id));
            $id = $statement->fetch();

            $statement = $conn->prepare("SELECT * FROM `notify_data_item` LEFT JOIN user_data ON notify_data_item.user_id = user_data.user_id WHERE `noti_id` = :id");
            $statement->execute(array(':id' => $req->id));

            if ($statement->rowCount() > 0) {
                $result = $statement->fetchAll();
                //insert result to array 
                foreach ($result as $row) {
                    $arr[] = $row['user_tel'];
                }

                $getTel = ['id' => $id, 'tel' => $arr];
                echo json_encode($getTel);
            } else {
                echo "0";
            }
            break;
        case "Emessage":
            echo   updateMessage($conn, $req->allSelected, $req->sender, $req->message, $req->tel, $req->dateTime, $req->dateTimeStart, $req->id);
            break;
        case "message":
            if ($req->TimeSend == 1) {
                echo SendMessageNow($conn, $sms, $req->allSelected, $req->sender, $req->message, $req->tel, $req->id);
            } else if ($req->TimeSend == 2) {
                echo  SendMessageDate($conn, $req->allSelected, $req->sender, $req->message, $req->tel, $req->dateTime, $req->id);
            }
            break;
        case "delMessage":
            echo deleteMessage($conn, $req->id);
            break;

        case "ServiceGroup_add":
            $dtStart = new DateTime($req->dateStart, new DateTimeZone('Asia/Bangkok'));
            $DateStart = $dtStart->format('d') . "/" . $dtStart->format('m') . "/" . ($dtStart->format('Y') +  543) . " " . $dtStart->format('H') . ":" . $dtStart->format('i') . ":" . $dtStart->format('s');

            $dtEnd = new DateTime($req->dateEnd, new DateTimeZone('Asia/Bangkok'));
            $DateEnd = $dtEnd->format('d') . "/" . $dtEnd->format('m') . "/" . ($dtEnd->format('Y') +  543) . " " . $dtEnd->format('H') . ":" . $dtEnd->format('i') . ":" . $dtEnd->format('s');
            $date = new DateTime();

            if (strtotime($req->dateEnd) > strtotime($req->dateStart)) {
                if ((strtotime($req->dateEnd) - strtotime($req->dateStart)) < 600000) {
                    $sv_status = 2;
                } else {
                    $sv_status = 0;
                }
            } else {
                $sv_status = 1;
            }



            $statement = $conn->prepare("INSERT INTO service_data (sv_name, sv_description, sv_start, sv_end,sv_status) VALUES (:sv_name, :sv_description, :sv_start, :sv_end, :sv_status)");
            $statement->execute(array(
                ':sv_name' => $req->title,
                ':sv_description' => $req->description,
                ':sv_start' => $DateStart,
                ':sv_end' => $DateEnd,
                ':sv_status' => $sv_status,
            ));


            $statement = $conn->prepare("SELECT MAX(sv_id) FROM service_data");
            $statement->execute();
            $sv_id = $statement->fetch()[0];

            if ($sv_status != 0) {
                $statement = $conn->prepare("INSERT INTO warn_sv (sv_id) VALUES (:sv_id)");
                $statement->execute(array(
                    ':sv_id' => $sv_id
                ));
            }

            if ($statement->rowCount() == 1) {
                echo 1;
            } else {
                echo 2;
            }
            break;
        case "ServiceGroup_edit":
            $dtStart = new DateTime($req->dateStart, new DateTimeZone('Asia/Bangkok'));
            $DateStart = $dtStart->format('d') . "/" . $dtStart->format('m') . "/" . ($dtStart->format('Y') +  543) . " " . $dtStart->format('H') . ":" . $dtStart->format('i');

            $dtEnd = new DateTime($req->dateEnd, new DateTimeZone('Asia/Bangkok'));
            $DateEnd = $dtEnd->format('d') . "/" . $dtEnd->format('m') . "/" . ($dtEnd->format('Y') +  543) . " " . $dtEnd->format('H') . ":" . $dtEnd->format('i');

            if (strtotime($req->dateEnd) > strtotime($req->dateStart)) {
                if ((strtotime($req->dateEnd) - strtotime($req->dateStart)) < 600000) {
                    $sv_status = 2;
                } else {
                    $sv_status = 0;
                }
            } else {
                $sv_status = 1;
            }



            if ($sv_status != 0) {
                $statement = $conn->prepare("INSERT INTO warn_sv (sv_id) VALUES (:sv_id)");
                $statement->execute(array(
                    ':sv_id' => $req->id
                ));
            }

            $statement = $conn->prepare("UPDATE service_data SET sv_name = :sv_name, sv_description = :sv_description, sv_start = :sv_start, sv_end = :sv_end, sv_status = :sv_status WHERE sv_id = :sv_id");
            $statement->execute(array(
                ':sv_name' => $req->title,
                ':sv_description' => $req->description,
                ':sv_start' => $DateStart,
                ':sv_end' => $DateEnd,
                ':sv_status' => $sv_status,
                ':sv_id' => $req->id
            ));

            if ($statement->rowCount() == 1) {
                echo 1;
            } else {
                echo 2;
            }
            break;
        case "ServiceGroup_del":
            $err = true;
            $statement = $conn->prepare("SELECT noti_id FROM notify_data WHERE sv_id = :id");
            $statement->execute(array(':id' => $req->id));
            $result = $statement->fetchAll();
            foreach ($result as $row) {
                $status = deleteMessage($conn, $row['noti_id']);
            }

            if ($status == 1) {
                $err = true;
            } else {
                $err = false;
            }

            $statement = $conn->prepare("DELETE FROM service_data WHERE sv_id = :sv_id");
            $statement->execute(array(
                ':sv_id' => $req->id
            ));

            if ($statement->rowCount() == 1) {
                $err = true;
            } else {
                $err = false;
            }

            if ($err == true) {
                echo 1;
            } else {
                echo 2;
            }

            break;
    }
}


function SendMessageNow($conn, $sms, $AllSelect, $sender, $message, $tel, $id)
{

    if ($AllSelect) {
        $err = false;
        $now = Date("d") . "/" . Date("m") . "/" . (Date("Y") + 543) . " " . (Date("H") + 7) . ":" . date("i");
        if ($id != 0) {
            $statement = $conn->prepare("INSERT INTO notify_data (sv_id,noti_sender,noti_selected,noti_meg,noti_start,noti_end,noti_status) VALUES (:sv_id, :noti_sender, :noti_selected,:noti_meg, :noti_start, :noti_end, :noti_status)");
            $statement->execute(array(
                ':sv_id' => $id,
                ':noti_sender' => $sender,
                ':noti_selected' => 1,
                ':noti_meg' => $message,
                ':noti_start' =>  $now,
                ':noti_end' => $now,
                ':noti_status' => 1
            ));


            $statement = $conn->prepare("SELECT MAX(noti_id) FROM notify_data");
            $statement->execute();
            $noti_id = $statement->fetch()[0];
        }
        if ($tel != [""]) {
            foreach ($tel as $key => $val) {
                if ($val != "") {
                    $now = Date("d") . "/" . Date("m") . "/" . (Date("Y") + 543) . " " . (Date("H") + 7) . ":" . date("i");
                    $statement = $conn->prepare("SELECT * FROM user_data WHERE user_tel = :user_tel");
                    $statement->execute(array(':user_tel' => $val));
                    if ($statement->rowCount() == 0) {
                        if ($id != 0) {
                            $statement = $conn->prepare("INSERT INTO guest_data (guest_tel,noti_id) VALUES (:tel, :noti_id)");
                            $statement->execute(array(
                                ':tel' => $val,
                                ':noti_id' => $noti_id
                            ));

                            if ($statement->rowCount() == 1) {
                                //     $response = $sms
                                //         ->setSender($req->sender)
                                //         ->setMsisdn($val)
                                //         ->setMessage($req->message)
                                //         ->send();
                            } else {
                                $err = true;
                            }
                        } else {
                            //     $response = $sms
                            //         ->setSender($req->sender)
                            //         ->setMsisdn($val)
                            //         ->setMessage($req->message)
                            //         ->send(); 
                        }
                    }
                }
            }
        }

        $statement = $conn->prepare("SELECT * FROM user_data ");
        $statement->execute();
        $AllUser = $statement->fetchAll();

        foreach ($AllUser as $user) {
            $now = Date("d") . "/" . Date("m") . "/" . (Date("Y") + 543) . " " . (Date("H") + 7) . ":" . date("i");
            $n = 1;
            if ($id != 0) {
                $statement = $conn->prepare("INSERT INTO `notify_data_item`(`noti_id`, `user_id`, `item_stauts`, `item_tranfer`) VALUES (:noti_id,:user_id,:noti_status,:item_tranfer) ");
                $statement->execute(array(
                    ':noti_id' => $noti_id,
                    ':user_id' => $user['user_id'],
                    ':noti_status' => $n,
                    ':item_tranfer' => $now
                ));

                if ($statement->rowCount() == 1) {
                    //     // $response = $sms
                    //     //     ->setSender($req->sender)
                    //     //     ->setMsisdn($user['user_tel'])
                    //     //     ->setMessage($req->message)
                    //     //     ->send();
                } else {
                    $err = true;
                }
            } else {
                //     // $response = $sms
                //     //     ->setSender($req->sender)
                //     //     ->setMsisdn($user['user_tel'])
                //     //     ->setMessage($req->message)
                //     //     ->send();
            }
        }


        if (!$err) {
            return 1;
        } else {
            return 2;
        }
    } else {
        if ($tel != [""]) {
            $now = Date("d") . "/" . Date("m") . "/" . (Date("Y") + 543) . " " . (Date("H") + 7) . ":" . date("i");
            $err = false;
            if ($id != 0) {
                $statement = $conn->prepare("INSERT INTO notify_data (sv_id,noti_sender,noti_selected,noti_meg,noti_start,noti_end,noti_status) VALUES (:sv_id, :noti_sender,:noti_selected, :noti_meg, :noti_start, :noti_end, :noti_status)");
                $statement->execute(array(
                    ':sv_id' => $id,
                    ':noti_sender' => $sender,
                    ':noti_selected' => 0,
                    ':noti_meg' => $message,
                    ':noti_start' =>  $now,
                    ':noti_end' => $now,
                    ':noti_status' => 1
                ));

                $statement = $conn->prepare("SELECT MAX(noti_id) FROM notify_data");
                $statement->execute();
                $noti_id = $statement->fetch()[0];
            }
            foreach ($tel as $key => $val) {
                $n = 1;
                $statement = $conn->prepare("SELECT user_id FROM user_data WHERE user_tel = '" . $val . "'");
                $statement->execute();
                $user_id = $statement->fetch()[0];

                if ($statement->rowCount() == 1) {

                    $now = Date("d") . "/" . Date("m") . "/" . (Date("Y") + 543) . " " . (Date("H") + 7) . ":" . date("i");
                    if ($id != 0) {
                        $statement = $conn->prepare("INSERT INTO `notify_data_item`(`noti_id`, `user_id`, `item_stauts`, `item_tranfer`) VALUES (:noti_id,:user_id,:noti_status,:item_tranfer) ");
                        $statement->execute(array(
                            ':noti_id' => $noti_id,
                            ':user_id' => $user_id,
                            ':noti_status' => $n,
                            ':item_tranfer' => $now
                        ));
                        /// check สำเร็จไหม ถ้า สำเร็จ จะส่ง sms ไปที่เบอร์เลย

                        if ($statement->rowCount() == 1) {
                            // $response = $sms
                            //     ->setSender($sender)
                            //     ->setMsisdn($val)
                            //     ->setMessage($message)
                            //     ->send();
                            // echo "this is response = " . $response;
                        } else {
                            $err = true;
                        }
                    } else {
                        // $response = $sms
                        //     ->setSender($sender)
                        //     ->setMsisdn($val)
                        //     ->setMessage($message)
                        //     ->send();
                    }
                } else {
                    if ($val != "") {
                        if ($id != 0) {
                            $statement = $conn->prepare("INSERT INTO guest_data (guest_tel,noti_id) VALUES (:tel, :noti_id)");
                            $statement->execute(array(
                                ':tel' => $val,
                                ':noti_id' => $noti_id
                            ));

                            /// check สำเร็จไหม ถ้า สำเร็จ จะส่ง sms ไปที่เบอร์เลย
                            if ($statement->rowCount() == 1) {
                                // $response = $sms
                                //     ->setSender($req->sender)
                                //     ->setMsisdn($val)
                                //     ->setMessage($req->message)
                                //     ->send();
                            } else {
                                $err = true;
                            }
                        } else {
                            // $response = $sms
                            //     ->setSender($req->sender)
                            //     ->setMsisdn($val)
                            //     ->setMessage($req->message)
                            //     ->send();
                        }
                    }
                }
            }

            if (!$err) {
                return 1;
            } else {
                return 2;
            }
        } else {
            ///แจ้งว่าข้อมูลเบอร์ไม่ได้กรอก
            return 3;
        }
    }
}

function SendMessageDate($conn, $AllSelect, $sender, $message, $tel, $dateTime, $id)
{
    $dt = new DateTime($dateTime, new DateTimeZone('Asia/Bangkok'));
    $Date = $dt->format('d') . "/" . $dt->format('m') . "/" . ($dt->format('Y') +  543) . " " . $dt->format('H') . ":" . $dt->format('i');
    if ($AllSelect) {
        $err = false;
        if ((Date("H") + 7) < 10) {
            $hour = "0" . (Date("H") + 7);
        } else {
            $hour = (Date("H") + 7);
        }
        $now = Date("d") . "/" . Date("m") . "/" . (Date("Y") + 543) . " " . $hour . ":" . date("i");

        $date = new DateTime();

        if (strtotime($dateTime) > $date->getTimestamp()) {
            if ((strtotime($dateTime) - $date->getTimestamp()) < 600000) {
                $noti_status = 2;
            } else {
                $noti_status = 0;
            }
        } else {
            $noti_status = 1;
        }


        $statement = $conn->prepare("INSERT INTO notify_data (sv_id,noti_sender,noti_selected,noti_meg,noti_start,noti_end,noti_status) VALUES (:sv_id, :noti_sender, :noti_selected, :noti_meg, :noti_start, :noti_end, :noti_status)");
        $statement->execute(array(
            ':sv_id' => $id,
            ':noti_sender' => $sender,
            ':noti_selected' => 1,
            ':noti_meg' => $message,
            ':noti_start' =>  $now,
            ':noti_end' => $Date,
            ':noti_status' => $noti_status
        ));

        $statement = $conn->prepare("SELECT MAX(noti_id) FROM notify_data");
        $statement->execute();
        $noti_id = $statement->fetch()[0];

        if ($noti_status != 0) {
            $statement = $conn->prepare("INSERT INTO warn_noti (noti_id) VALUES (:noti_id)");
            $statement->execute(array(
                ':noti_id' => $noti_id
            ));
        }


        if ($tel != [""]) {
            foreach ($tel as $key => $val) {
                $now = Date("d") . "/" . Date("m") . "/" . (Date("Y") + 543) . " " . (Date("H") + 7) . ":" . date("i");
                $statement = $conn->prepare("SELECT * FROM user_data WHERE user_tel = :tel");
                $statement->execute(array(
                    ':tel' => $val,
                ));

                if ($statement->rowCount() == 0) {
                    $statement = $conn->prepare("INSERT INTO guest_data (guest_tel,noti_id) VALUES (:tel, :noti_id)");
                    $statement->execute(array(
                        ':tel' => $val,
                        ':noti_id' => $noti_id
                    ));
                    if ($statement->rowCount() == 1) {
                    } else {
                        $err = true;
                    }
                }
            }
        }

        $statement = $conn->prepare("SELECT user_id FROM user_data ");
        $statement->execute();
        $AllUser = $statement->fetchAll();

        foreach ($AllUser as $user) {
            $now = Date("d") . "/" . Date("m") . "/" . (Date("Y") + 543) . " " . (Date("H") + 7) . ":" . date("i");
            $n = 1;
            $statement = $conn->prepare("INSERT INTO `notify_data_item`(`noti_id`, `user_id`, `item_stauts`, `item_tranfer`) VALUES (:noti_id,:user_id,:noti_status,:item_tranfer) ");
            $statement->execute(array(
                ':noti_id' => $noti_id,
                ':user_id' => $user['user_id'],
                ':noti_status' => $n,
                ':item_tranfer' => $now
            ));

            // if ($statement->rowCount() == 1) {
            //     // $response = $sms
            //     //     ->setSender($req->sender)
            //     //     ->setMsisdn($tel['user_tel'])
            //     //     ->setMessage($req->message)
            //     //     ->send();
            // } else {
            //     $err = true;
            // }
        }

        if (!$err) {
            return 1;
        } else {
            return 2;
        }
    } else {
        if ($tel != [""]) {
            if ((Date("H") + 7) < 10) {
                $hour = "0" . (Date("H") + 7);
            } else {
                $hour = (Date("H") + 7);
            }
            $now = Date("d") . "/" . Date("m") . "/" . (Date("Y") + 543) . " " . $hour . ":" . date("i");
            $err = false;

            $date = new DateTime();

            if (strtotime($dateTime) > $date->getTimestamp()) {
                if ((strtotime($dateTime) - $date->getTimestamp()) < 600000) {
                    $noti_status = 2;
                } else {
                    $noti_status = 0;
                }
            } else {
                $noti_status = 1;
            }

            $statement = $conn->prepare("INSERT INTO notify_data (sv_id,noti_sender,noti_selected,noti_meg,noti_start,noti_end,noti_status) VALUES (:sv_id, :noti_sender, :noti_selected ,:noti_meg, :noti_start, :noti_end, :noti_status)");
            $statement->execute(array(
                ':sv_id' => $id,
                ':noti_sender' => $sender,
                'noti_selected' => 0,
                ':noti_meg' => $message,
                ':noti_start' =>  $now,
                ':noti_end' =>  $Date,
                ':noti_status' => $noti_status
            ));


            $statement = $conn->prepare("SELECT MAX(noti_id) FROM notify_data");
            $statement->execute();
            $noti_id = $statement->fetch()[0];

            if ($noti_status != 0) {
                $statement = $conn->prepare("INSERT INTO warn_noti (noti_id) VALUES (:noti_id)");
                $statement->execute(array(
                    ':noti_id' => $noti_id
                ));
            }


            foreach ($tel as $key => $val) {
                $n = 1;
                $statement = $conn->prepare("SELECT user_id FROM user_data WHERE user_tel = '" . $val . "'");
                $statement->execute();
                $user_id = $statement->fetch()[0];

                if ($statement->rowCount() == 1) {
                    $now = Date("d") . "/" . Date("m") . "/" . (Date("Y") + 543) . " " . (Date("H") + 7) . ":" . date("i");

                    $statement = $conn->prepare("INSERT INTO `notify_data_item`(`noti_id`, `user_id`, `item_stauts`, `item_tranfer`) VALUES (:noti_id,:user_id,:noti_status,:item_tranfer) ");
                    $statement->execute(array(
                        ':noti_id' => $noti_id,
                        ':user_id' => $user_id,
                        ':noti_status' => $n,
                        ':item_tranfer' => $now
                    ));

                    /// check สำเร็จไหม ถ้า สำเร็จ จะส่ง sms ไปที่เบอร์เลย
                    // if ($statement->rowCount() == 1) {
                    //     $response = $sms
                    //         ->setSender($req->sender)
                    //         ->setMsisdn($val)
                    //         ->setMessage($req->message)
                    //         ->send();
                    // } else {
                    //     $err = true;
                    // }

                } else {
                    if ($val != "") {
                        $statement = $conn->prepare("INSERT INTO guest_data (guest_tel,noti_id) VALUES (:tel, :noti_id)");
                        $statement->execute(array(
                            ':tel' => $val,
                            ':noti_id' => $noti_id
                        ));

                        /// check สำเร็จไหม ถ้า สำเร็จ จะส่ง sms ไปที่เบอร์เลย
                        // if ($statement->rowCount() == 1) {
                        //     $response = $sms
                        //         ->setSender($req->sender)
                        //         ->setMsisdn($val)
                        //         ->setMessage($req->message)
                        //         ->send();
                        // } else {
                        //     $err = true;
                        // }
                    }
                }
            }
            if (!$err) {
                return 1;
            } else {
                return 2;
            }
        } else {
            ///แจ้งว่าข้อมูลเบอร์ไม่ได้กรอก
            return 3;
        }
    }
}


function updateMessage($conn,  $AllSelect, $sender, $message, $tel, $dateTime, $dateTimeStart, $id)
{

    $dt = new DateTime($dateTimeStart, new DateTimeZone('Asia/Bangkok'));
    $Date_start = $dt->format('d') . "/" . $dt->format('m') . "/" . ($dt->format('Y') +  543) . " " . $dt->format('H') . ":" . $dt->format('i');

    $dt = new DateTime($dateTime, new DateTimeZone('Asia/Bangkok'));
    $Date_end = $dt->format('d') . "/" . $dt->format('m') . "/" . ($dt->format('Y') +  543) . " " . $dt->format('H') . ":" . $dt->format('i');
    if ($AllSelect) {
        $err = true;

        if (strtotime($dateTime) >  strtotime($dateTimeStart)) {
            if ((strtotime($dateTime) - strtotime($dateTimeStart)) < 600000) {
                $noti_status = 2;
            } else {
                $noti_status = 0;
            }
        } else {
            $noti_status = 1;
        }

        if ($noti_status != 0) {
            $statement = $conn->prepare("INSERT INTO warn_noti (noti_id) VALUES (:noti_id)");
            $statement->execute(array(
                ':noti_id' => $id
            ));
        }


        $statement = $conn->prepare("UPDATE notify_data SET noti_sender = :sender, noti_selected = :noti_selected, noti_meg = :noti_meg,noti_start = :noti_start, noti_end = :noti_end , noti_status = :noti_status WHERE noti_id = :id");
        $statement->execute(array(
            ':sender' => $sender,
            ':noti_selected' => 1,
            ':noti_meg' => $message,
            ':noti_start' => $Date_start,
            ':noti_end' => $Date_end,
            ':noti_status' => $noti_status,
            ':id' => $id
        ));


        if ($tel != [""] || null) {
            foreach ($tel as $key => $val) {
                if ($val != "") {
                    $statement = $conn->prepare("SELECT user_id FROM user_data WHERE user_tel = :tel");
                    $statement->execute(array(
                        ':tel' => $val
                    ));

                    if ($statement->rowCount() != 1) {
                        $statement = $conn->prepare("SELECT guest_id FROM guest_data WHERE guest_tel = :guest_tel AND noti_id = :noti_id");
                        $statement->execute(array(
                            ':guest_tel' => $val,
                            ':noti_id' => $id
                        ));

                        if ($statement->rowCount() != 1) {
                            $statement = $conn->prepare("INSERT INTO guest_data (guest_tel,noti_id) VALUES (:tel, :noti_id)");
                            $statement->execute(array(
                                ':tel' => $val,
                                ':noti_id' => $id
                            ));

                            if ($statement->rowCount() == 1) {
                                $err = true;
                            } else {
                                $err = false;
                            }
                        }
                    }
                }
            }
        }

        foreach ($tel as $key => $val) {
            $statement = $conn->prepare("SELECT user_id FROM user_data WHERE user_tel = :tel");
            $statement->execute(array(
                ':tel' => $val
            ));

            if ($statement->rowCount() == 0) {
                $user_tel[] = $val;
            }
        }

        $statement = $conn->prepare("SELECT guest_tel FROM guest_data WHERE noti_id = :noti_id");
        $statement->execute(array(
            ':noti_id' => $id
        ));

        foreach ($statement->fetchAll() as $row) {
            $guest_tel[] = $row['guest_tel'];
        }



        $result = array_diff($guest_tel, $user_tel);
        foreach ($result as $key => $val) {
            $statement = $conn->prepare("DELETE FROM guest_data WHERE guest_tel = :guest_tel");
            $statement->execute(array(
                ':guest_tel' => $val
            ));

            if ($statement->rowCount() == 1) {
                $err = true;
            } else {
                $err = false;
            }
        }

        // ///สมาชิก

        $statement = $conn->prepare("SELECT user_id FROM notify_data_item WHERE noti_id = :id");
        $statement->execute(array(
            ':id' => $id
        ));
        $old_userID = $statement->fetchAll();

        foreach ($old_userID as $row) {
            $old[] = $row['user_id'];
        }


        if ($old == null) {
            $statement = $conn->prepare("SELECT user_id FROM user_data");
            $statement->execute();
            $user_id = $statement->fetchAll();

            foreach ($user_id as $key => $val) {
                $statement = $conn->prepare("INSERT INTO notify_data_item (noti_id,user_id,item_stauts,item_tranfer) VALUES (:noti_id, :user_id, :item_stauts, :item_tranfer)");
                $statement->execute(array(
                    ':noti_id' => $id,
                    ':user_id' => $val['user_id'],
                    ':item_stauts' => 1,
                    ':item_tranfer' => Date('Y-m-d H:i')
                ));

                if ($statement->rowCount() == 1) {
                    $err = true;
                } else {
                    $err = false;
                }
            }
        } else {
            $statement = $conn->prepare("SELECT user_id FROM user_data");
            $statement->execute();
            $new_userID = $statement->fetchAll();

            foreach ($new_userID as $row) {
                $new[] = $row['user_id'];
            }

            $result = array_diff($new, $old);
            foreach ($result as $key => $val) {
                $statement = $conn->prepare("INSERT INTO notify_data_item (noti_id,user_id,item_stauts,item_tranfer) VALUES (:noti_id, :user_id, :item_stauts, :item_tranfer)");
                $statement->execute(array(
                    ':noti_id' => $id,
                    ':user_id' => $val,
                    ':item_stauts' => 1,
                    ':item_tranfer' => Date('Y-m-d H:i')
                ));

                if ($statement->rowCount() == 1) {
                    $err = true;
                } else {
                    $err = false;
                }
            }
        }


        if ($err) {
            return 1;
        } else {
            return 2;
        }
    } else {
        if ($tel != [""]) {
            $err = true;

            if (strtotime($dateTime) >  strtotime($dateTimeStart)) {
                if ((strtotime($dateTime) - strtotime($dateTimeStart)) < 600000) {
                    $noti_status = 2;
                } else {
                    $noti_status = 0;
                }
            } else {
                $noti_status = 1;
            }

            if ($noti_status != 0) {
                $statement = $conn->prepare("INSERT INTO warn_noti (noti_id) VALUES (:noti_id)");
                $statement->execute(array(
                    ':noti_id' => $id
                ));
            }

            $statement = $conn->prepare("UPDATE notify_data SET noti_sender = :sender, noti_selected = :noti_selected, noti_meg = :noti_meg, noti_start = :noti_start, noti_end = :noti_end , noti_status = :noti_status WHERE noti_id = :id");
            $statement->execute(array(
                ':sender' => $sender,
                ':noti_selected' => 1,
                ':noti_meg' => $message,
                ':noti_start' => $Date_start,
                ':noti_end' => $Date_end,
                ':noti_status' => $noti_status,
                ':id' => $id
            ));



            foreach ($tel as $key => $val) {
                if ($val != "" && $val != null) {

                    $statement = $conn->prepare("SELECT user_id FROM user_data WHERE user_tel = :tel");
                    $statement->execute(array(
                        ':tel' => $val
                    ));
                    if ($statement->rowCount() == 0) {
                        $guestTel[] = $val;
                        $statement = $conn->prepare("SELECT guest_id FROM guest_data WHERE guest_tel = :guest_tel AND noti_id = :noti_id");
                        $statement->execute(array(
                            ':guest_tel' => $val,
                            ':noti_id' => $id
                        ));
                        if ($statement->rowCount() == 0) {
                            if ($val != null) {
                                $statement = $conn->prepare("INSERT INTO guest_data (guest_tel,noti_id) VALUES (:tel, :noti_id)");
                                $statement->execute(array(
                                    ':tel' => $val,
                                    ':noti_id' => $id
                                ));
                            }
                        }
                    }
                }
            }



            foreach ($tel as $key => $val) {
                $statement = $conn->prepare("SELECT user_id FROM user_data WHERE user_tel = :tel");
                $statement->execute(array(
                    ':tel' => $val
                ));

                if ($statement->rowCount() == 0) {
                    $user_tel[] = $val;
                }
            }

            $statement = $conn->prepare("SELECT guest_tel FROM guest_data WHERE noti_id = :noti_id");
            $statement->execute(array(
                ':noti_id' => $id
            ));

            foreach ($statement->fetchAll() as $row) {
                $guest_tel[] = $row['guest_tel'];
            }



            $result = array_diff($guest_tel, $user_tel);
            foreach ($result as $key => $val) {
                $statement = $conn->prepare("DELETE FROM guest_data WHERE guest_tel = :guest_tel");
                $statement->execute(array(
                    ':guest_tel' => $val
                ));

                if ($statement->rowCount() == 1) {
                    $err = true;
                } else {
                    $err = false;
                }
            }


            // //สมาชิก

            foreach ($tel as $key => $val) {
                $statement = $conn->prepare("SELECT user_id FROM user_data WHERE user_tel = :tel");
                $statement->execute(array(
                    ':tel' => $val
                ));

                if ($statement->rowCount() == 1) {
                    $tels[] = $val;
                }
            }

            $statement = $conn->prepare("SELECT user_id FROM notify_data_item WHERE noti_id = :id");
            $statement->execute(array(
                ':id' => $id
            ));
            $old_userID = $statement->fetchAll();

            foreach ($old_userID as $row) {
                $statement = $conn->prepare("SELECT user_tel FROM user_data WHERE user_id = :id");
                $statement->execute(array(
                    ':id' => $row['user_id']
                ));
                $old[] = $statement->fetch()['user_tel'];
            }

            if ($old == null) {
                foreach ($tels as $key => $val) {
                    $statement = $conn->prepare("SELECT user_id FROM user_data WHERE user_tel = :tel");
                    $statement->execute(array(
                        ':tel' => $val
                    ));
                    $user_id = $statement->fetchAll();

                    foreach ($user_id as $key => $val) {
                        $statement = $conn->prepare("INSERT INTO notify_data_item (noti_id,user_id,item_stauts,item_tranfer) VALUES (:noti_id, :user_id, :item_stauts, :item_tranfer)");
                        $statement->execute(array(
                            ':noti_id' => $id,
                            ':user_id' => $val['user_id'],
                            ':item_stauts' => 1,
                            ':item_tranfer' => $dateTime
                        ));

                        if ($statement->rowCount() == 1) {
                            $err = true;
                        } else {
                            $err = false;
                        }
                    }
                }
            } else {

                $statement = $conn->prepare("SELECT user_id FROM notify_data_item WHERE noti_id = :noti_id");
                $statement->execute(array(
                    ':noti_id' => $id
                ));
                $new_userID = $statement->fetchAll();

                foreach ($new_userID as $row) {
                    $statement = $conn->prepare("SELECT user_tel FROM user_data WHERE user_id = :id");
                    $statement->execute(array(
                        ':id' => $row['user_id']
                    ));
                    $new[] = $statement->fetch()['user_tel'];
                }

                $result = array_diff($new, $tels);
                foreach ($result as $key => $val) {
                    $statement = $conn->prepare("SELECT user_id FROM user_data WHERE user_tel = :tel");
                    $statement->execute(array(
                        ':tel' => $val
                    ));
                    $user_id = $statement->fetchAll();

                    foreach ($user_id as $key => $val) {
                        $statement = $conn->prepare("DELETE FROM notify_data_item WHERE user_id = :user_id AND noti_id = :noti_id");
                        $statement->execute(array(
                            ':user_id' => $val['user_id'],
                            ':noti_id' => $id
                        ));

                        if ($statement->rowCount() == 1) {
                            $err = true;
                        } else {
                            $err = false;
                        }
                    }
                }


                foreach ($tels as $key => $val) {
                    $statement = $conn->prepare("SELECT user_id FROM user_data WHERE user_tel = :tel");
                    $statement->execute(array(
                        ':tel' => $val
                    ));

                    if ($statement->rowCount() == 1) {
                        $new_id[] = $statement->fetch()['user_id'];
                    }
                }

                $statement = $conn->prepare("SELECT user_id FROM notify_data_item WHERE noti_id = :noti_id");
                $statement->execute(array(
                    ':noti_id' => $id
                ));

                $old_userID = $statement->fetchAll();

                foreach ($old_userID as $row) {
                    $old_id[] = $row['user_id'];
                }


                $result = array_diff($new_id, $old_id);

                foreach ($result as $key => $val) {
                    $statement = $conn->prepare("INSERT INTO notify_data_item (noti_id,user_id,item_stauts,item_tranfer) VALUES (:noti_id, :user_id, :item_stauts, :item_tranfer)");
                    $statement->execute(array(
                        ':noti_id' => $id,
                        ':user_id' => $val,
                        ':item_stauts' => 1,
                        ':item_tranfer' => $dateTime
                    ));

                    if ($statement->rowCount() == 1) {
                        $err = true;
                    } else {
                        $err = false;
                    }
                }
            }


            if ($err) {
                return 1;
            } else {
                return 2;
            }
        } else {
            ///แจ้งว่าข้อมูลเบอร์ไม่ได้กรอก
            return 3;
        }
    }
}


function deleteMessage($conn, $id)
{
    $err = false;
    $statement = $conn->prepare("DELETE FROM notify_data WHERE noti_id = :id");
    $statement->execute(array(
        ':id' => $id
    ));

    if ($statement->rowCount() == 1) {
        $err = true;
    } else {
        $err = false;
    }

    $statement = $conn->prepare("SELECT user_id FROM notify_data_item WHERE noti_id = :id");
    $statement->execute(array(
        ':id' => $id
    ));
    $user_id = $statement->fetchAll();

    foreach ($user_id as $key => $val) {
        $statement = $conn->prepare("DELETE FROM notify_data_item WHERE user_id = :user_id AND noti_id = :noti_id");
        $statement->execute(array(
            ':user_id' => $val['user_id'],
            ':noti_id' => $id
        ));

        if ($statement->rowCount() == 1) {
            $err = true;
        } else {
            $err = false;
        }
    }

    $statement = $conn->prepare("SELECT guest_id FROM guest_data WHERE noti_id = :id");
    $statement->execute(array(
        ':id' => $id
    ));

    $guest_id = $statement->fetchAll();

    foreach ($guest_id as $key => $val) {
        $statement = $conn->prepare("DELETE FROM guest_data WHERE guest_id = :guest_id AND noti_id = :noti_id");
        $statement->execute(array(
            ':guest_id' => $val['guest_id'],
            ':noti_id' => $id
        ));

        if ($statement->rowCount() == 1) {
            $err = true;
        } else {
            $err = false;
        }
    }


    if ($err) {
        return 1;
    } else {
        return 2;
    }
}
