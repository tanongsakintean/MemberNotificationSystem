<?php
if (isset($_REQUEST['clear'])) {
    if ($_REQUEST['clear'] == 2) {
        $statement = $conn->prepare("DELETE FROM warn_noti WHERE noti_id = :noti_id");
        $statement->execute(array(':noti_id' => $_REQUEST['id']));
    }
}


$statement = $conn->prepare("SELECT * FROM notify_data WHERE noti_id = :id");
$statement->bindParam(":id", $_REQUEST['id']);
$statement->execute();
$noti = $statement->fetch(PDO::FETCH_ASSOC);


?>
<div>
    <a href="index.php?p=service&id=<?php echo $_REQUEST['sid']; ?>" class="btn btn-primary">
        <span>
            <i class="fa fa-arrow-left"></i>
        </span>
        กลับ
    </a>


    <div class="d-flex mt-10 justify-content-between ">
        <div class="mb-10 mx-2 w-100">
            <h2 for="exampleFormControlInput1" class="required ">ผู้ส่ง</h2>
            <h3><?php echo $noti['noti_sender'] ?></h3>
        </div>

        <div class="mb-10 w-100">
            <h2 class="required ">วันที่สร้างข้อความ</h2>
            <h3><?php echo $noti['noti_start']; ?></h3>
        </div>

        <div class="mb-10 w-100">
            <h2 class="required ">วันที่ส่งข้อความ</h2>
            <h3><?php echo $noti['noti_end']; ?></h3>
        </div>

    </div>
    <div class="mb-10 mx-2 w-100">
        <h2 class="required ">ข้อความ</h2>
        <p class="mx-2" style="word-wrap: break-word; "><?php echo $noti['noti_meg']; ?></p>
    </div>

    <?php

    $statement = $conn->prepare("SELECT guest_tel FROM guest_data WHERE noti_id = :id");
    $statement->execute(array(
        ':id' => $_REQUEST['id']
    ));

    $guest = $statement->fetchAll(PDO::FETCH_ASSOC);



    ?>

    <div class="mx-2 w-100">
        <h2 class="required ">เบอร์โทรบุคคลทั่วไป</h2>
        <?php if (count($guest) > 0) { ?>
            <p><?php foreach ($guest as $key => $val) {
                    echo $val['guest_tel'] . " , ";
                } ?></p>
        <?php } else { ?>
            <h3>ไม่มีข้อมูล</h3>
        <?php } ?>
    </div>


    <!--begin::Table container-->
    <div class="table-responsive ">

        <!--begin::Table-->
        <table class="table service table-striped table-row-bordered gy-5 gs-7 border rounded">
            <!--begin::Table head-->
            <thead>
                <tr class="fw-bolder text-muted">
                    <th class="min-w-145px">ลำดับ</th>
                    <th class="min-w-150px">ชื่อ - นามสกุล</th>
                    <th class="min-w-150px">อีเมลล์</th>
                    <th class="min-w-150px">เบอร์โทร</th>
                </tr>
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody>


                <?php


                $statement = $conn->prepare("SELECT * FROM notify_data_item WHERE noti_id = :id");
                $statement->execute(array(':id' => $_REQUEST['id']));
                $result = $statement->fetchAll();
                $i = 1;



                foreach ($result as $val) {
                    $statement = $conn->prepare("SELECT * FROM user_data WHERE user_id = :id");
                    $statement->execute(array(':id' => $val['user_id']));
                    $user = $statement->fetch(PDO::FETCH_ASSOC);

                ?>

                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="d-flex justify-content-start flex-column">
                                    <p><?php echo $i; ?></p>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="d-flex align-items-center">
                                <div class="d-flex justify-content-start flex-column">
                                    <p><?php echo $user['user_name']; ?></p>
                                </div>
                            </div>
                        </td>



                        <td class="text-end">
                            <div class="d-flex flex-column w-100 me-2">
                                <div class="d-flex flex-stack mb-2">
                                    <p><?php echo $user['user_email']; ?></p>
                                </div>

                            </div>
                        </td>

                        <td class="text-end">
                            <div class="d-flex flex-column w-100 me-2">
                                <div class="d-flex flex-stack mb-2">
                                    <p><?php echo $user['user_tel']; ?></p>
                                </div>

                            </div>
                        </td>


                    </tr>
                <?php $i++;
                }
                ?>
            </tbody>
            <!--end::Table body-->
        </table>
        <!--end::Table-->
    </div>
    <!--end::Table container-->
</div>