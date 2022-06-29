<?php
include("class/Havesms.php");



$statement = $conn->prepare("SELECT user_id,user_name,user_tel FROM user_data");
$statement->execute();
$user = $statement->fetchAll();

$statement = $conn->prepare("SELECT * FROM service_data");
$statement->execute();
$service = $statement->fetchAll();

?>
<div>
    <button type="button" class="btn btn-success mx-2 my-2" data-bs-toggle="modal" data-bs-target="#createMessageSms">
        <span><i class="fas fa-solid fa-comment"></i></span> ส่งข้อความทันที
    </button>

    <button type="button" class="btn btn-info mx-2 my-2" data-bs-toggle="modal" data-bs-target="#createServiceGroup">
        <span><i class="fas fa-solid fa-user"></i></span>สร้างกลุ่มบริการ
    </button>



    <!--begin::Col-->
    <div class=" mt-10">
        <!--begin::Tables Widget 9-->
        <div class="card h-md-100">
            <!--begin::Header-->

            <!--end::Header-->
            <!--begin::Body-->

            <div class="card-body py-3">

                <!--begin::Table container-->
                <div class="table-responsive ">

                    <!--begin::Table-->
                    <table id="datatable" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="fw-bolder text-muted">
                                <th class="min-w-145px">ลำดับ</th>
                                <th class="min-w-140px">ชื่อบริการ</th>
                                <th class="min-w-130px">วันแรกบริการ</th>
                                <th class="min-w-130px">วันสุดท้ายบริการ</th>
                                <th class="min-w-130px">สถานะ</th>
                                <th class="min-w-100px ">จัดการ</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody>

                            <?php
                            $i = 1;
                            foreach ($service as $val) {

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
                                                <p><?php echo $val['sv_name']; ?></p>
                                            </div>
                                        </div>
                                    </td>


                                    <td class="text-end">
                                        <div class="d-flex flex-column w-100 me-2">
                                            <div class="d-flex flex-stack mb-2">
                                                <p><?php echo $val['sv_start']; ?></p>
                                            </div>

                                        </div>
                                    </td>

                                    <td class="text-end">
                                        <div class="d-flex flex-column w-100 me-2">
                                            <div class="d-flex flex-stack mb-2">
                                                <p><?php echo $val['sv_end']; ?></p>
                                            </div>

                                        </div>
                                    </td>

                                    <td class="text-end">
                                        <div class="d-flex flex-column w-100 me-2">
                                            <div class="d-flex flex-stack mb-2">
                                                <?php if ($val['sv_status'] == 0) { ?>
                                                    <span class="badge badge-light-success">กำลังบริการ</span>
                                                <?php } else if ($val['sv_status']  == 2) { ?>
                                                    <span class="badge badge-light-warning">บริการใกล้หมด</span>
                                                <?php } else { ?>
                                                    <span class="badge badge-light-danger">หมดบริการ</span>
                                                <?php } ?>
                                            </div>

                                        </div>
                                    </td>


                                    <td>
                                        <div class="d-flex  flex-shrink-0">

                                            <a href="index.php?p=service&id=<?php echo $val['sv_id']; ?>" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                <!--begin::Svg Icon | path: icons/duotune/art/art005.svg delete message -->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                        <path fill="black" d="M15 12c0 1.654-1.346 3-3 3s-3-1.346-3-3 1.346-3 3-3 3 1.346 3 3zm9-.449s-4.252 8.449-11.985 8.449c-7.18 0-12.015-8.449-12.015-8.449s4.446-7.551 12.015-7.551c7.694 0 11.985 7.551 11.985 7.551zm-7 .449c0-2.757-2.243-5-5-5s-5 2.243-5 5 2.243 5 5 5 5-2.243 5-5z" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>

                                            <button @click="getServiceGroup('<?php echo $val['sv_name'] ?>','<?php echo $val['sv_description'] ?>','<?php echo $val['sv_start'] ?>','<?php echo $val['sv_end'] ?>','<?php echo $val['sv_id'] ?>')" type="button" class="btn btn-icon btn-bg-light btn-active-color-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editServiceGroup">
                                                <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
                                                        <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </button>

                                            <button @click="delServiceGroup('<?php echo $val['sv_id'] ?>')" type="button" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                                                        <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                                                        <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </button>
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
            <!--begin::Body-->
        </div>
        <!--end::Tables Widget 9-->
    </div>
    <!--end::Col-->
</div>





<!---  modal แจ้งข้อความทันที  -->
<div class="modal fade" tabindex="-1" role="dialog" id="createMessageSms" data-focus-on="input:first">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ส่งข้อความทันที</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-solid fa-times"></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">


                <div class="d-flex justify-content-between ">
                    <div class="mb-10 mx-2 w-100">
                        <label for="exampleFormControlInput1" class="required form-label">เลือกผู้ส่ง</label>
                        <select class="form-select" v-model="MessageSms.sender" aria-label="Select example" required>
                            <option disabled>เลือกผู้ส่ง</option>
                            <option value="Peivileged">Peivileged</option>
                            <option value="Force">Force</option>
                            <option value="REMARK">REMARK</option>
                            <option value="NOWW">NOWW</option>
                            <option value="MTG">MTG</option>
                        </select>
                    </div>

                    <div class="mb-10 nx-2 w-100">
                        <label for="exampleFormControlInput1" class="required form-label">เบอร์โทร</label>
                        <textarea name="" v-model="MessageSms.singleTel" placeholder="กรอกเบอร์โทรหลายเบอร์ให้ขั้นด้วย ',' " required class="form-control form-control-solid" required id="" cols="30" rows="1"></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between ">
                    <div class="mb-10 mx-2 w-100">
                        <label for="exampleFormControlInput1" class="required form-label">เลือกสมาชิก</label>
                        <button data-bs-toggle="modal" data-bs-target="#selectTel1" class="w-100 btn btn-info d-block">เลือก</button>

                        <div class="mt-5">
                            <div class="mb-10">
                                <label for="exampleFormControlInput1" class="required form-label">เวลาส่ง</label>
                                <select class="form-select" v-model="MessageSms.TimeSend" aria-label="Select example" required>
                                    <option>เลือกเวลาส่ง</option>
                                    <option value="1">ส่งทันที</option>
                                    <option value="2">ตั้งเวลา</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-10 mx-2 w-100">
                        <label for="exampleFormControlInput1" class="required form-label">ข้อความ</label>
                        <textarea name="" v-model="MessageSms.message" placeholder="ข้อความ.." required class="form-control form-control-solid" required id="" cols="30" rows="5"></textarea>
                    </div>
                </div>

                <div v-if="MessageSms.TimeSend == 2" class="   ">
                    <div class="mb-10">
                        <label for="exampleFormControlInput1" class="required form-label">เวลาส่ง</label>
                        <input type="datetime-local" v-model="MessageSms.dateTime" class="form-control form-control-solid" required>
                    </div>
                </div>




            </div>

            <div class="modal-footer">
                <button @click="clearMessageSingle" type="button" class="btn btn-light" data-bs-dismiss="modal">ปิด</button>
                <button @click="messageSingle" class="btn btn-primary">ส่งข้อความ</button>
            </div>

        </div>
    </div>
</div>

<!-- เลือกเบอร์ของ แจ้งเตือนทันที  -->
<div class="modal fade" tabindex="-1" data-modal-parent="#createMessageSms" role="dialog" id="selectTel1" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เลือกเบอร์โทรจากคลัง</h5>

                <!--begin::Close-->
                <button class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-toggle="modal" data-bs-target="#createMessageSms">
                    <i class="fas fa-solid fa-times"></i>
                </button>
                <!--end::Close-->
            </div>
            <div class="modal-body">
                <div class="card h-md-100">
                    <!--begin::Body-->
                    <div class="card-body py-3">

                        <!--begin::Table container-->
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="service table table-striped table-row-bordered gy-5 gs-7">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="fw-bolder text-muted">
                                        <th class="w-25px">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input " style="z-index:3 ;" type="checkbox" v-model="MessageSms.allSelected" value="0" data-kt-check="true" @change="selectAll" data-kt-check-target=".widget-9-check" />
                                                <p class="mt-4 " style="margin-left: 10px ;">ทั้งหมด</p>
                                            </div>
                                        </th>
                                        <th class="min-w-150px">ชื่อ - นามสกุล</th>
                                        <th class="min-w-140px">เบอร์โทร</th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <form action="" method="post">
                                    <tbody class="">
                                        <?php
                                        foreach ($user as $key => $val) {
                                        ?>
                                            <tr>
                                                <td>
                                                    <div class="form-check  form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input text-center widget-9-check" type="checkbox" value="<?php echo $val['user_tel'] ?>" v-model="MessageSms.multipleTel" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <h1 class="text-dark fw-bolder text-hover-primary fs-6"><?php echo $val['user_name'] ?></h1>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <h1 class="text-dark fw-bolder text-hover-primary d-block fs-6"><?php echo $val['user_tel'] ?></h1>
                                                </td>
                                            </tr>
                                        <?php } ?>


                                    </tbody>
                                    <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Table container-->
                    </div>
                    <!--begin::Body-->
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" @click="clearTel" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#createMessageSms">ปิด</button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createMessageSms">เลือก</button>
            </div>
            </form>
        </div>
    </div>
</div>



<!-- เลือกเบอร์ของ แจ้งเตือนทันที  -->
<div class="modal fade" tabindex="-1" data-modal-parent="#selectTel" role="dialog" id="kt_modal_4" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เลือกเบอร์โทรจากคลัง</h5>

                <!--begin::Close-->
                <button class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-toggle="modal" data-bs-target="#selectTel">
                    <i class="fas fa-solid fa-times"></i>
                </button>
                <!--end::Close-->
            </div>
            <div class="modal-body">
                <div class="card h-md-100">
                    <!--begin::Body-->
                    <div class="card-body py-3">

                        <!--begin::Table container-->
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="service table table-striped table-row-bordered gy-5 gs-7">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="fw-bolder text-muted">
                                        <th class="w-25px">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input " style="z-index:3 ;" type="checkbox" v-model="MessageSms.allSelected" value="0" data-kt-check="true" @change="selectAll" data-kt-check-target=".widget-9-check" />
                                                <p class="mt-4 " style="margin-left: 10px ;">ทั้งหมด</p>
                                            </div>
                                        </th>
                                        <th class="min-w-150px">ชื่อ - นามสกุล</th>
                                        <th class="min-w-140px">เบอร์โทร</th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <form action="" method="post">
                                    <tbody class="">
                                        <?php
                                        foreach ($user as $key => $val) {
                                        ?>
                                            <tr>
                                                <td>
                                                    <div class="form-check  form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input text-center widget-9-check" type="checkbox" value="<?php echo $val['user_tel'] ?>" v-model="MessageSms.multipleTel" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <h1 class="text-dark fw-bolder text-hover-primary fs-6"><?php echo $val['user_name'] ?></h1>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <h1 class="text-dark fw-bolder text-hover-primary d-block fs-6"><?php echo $val['user_tel'] ?></h1>
                                                </td>
                                            </tr>
                                        <?php } ?>


                                    </tbody>
                                    <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Table container-->
                    </div>
                    <!--begin::Body-->
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" @click="clearTel" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#selectTel">ปิด</button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#selectTel">เลือก</button>
            </div>
            </form>
        </div>
    </div>
</div>





<!------    สร้างกลุ่มบริการ    ------------>
<div class="modal fade" tabindex="-1" role="dialog" id="createServiceGroup" data-focus-on="input:first">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">สร้างกลุ่มบริการ</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-solid fa-times"></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">

                <div class="mb-10 mx-2 w-100">
                    <label for="exampleFormControlInput1" class="required form-label">ชื่อบริการ</label>
                    <input type="text" v-model="ServiceSms.title" required class="form-control form-control-solid" placeholder="กรอกชื่อบริการ" />
                </div>


                <div class="mb-10 mx-2 w-100">
                    <label for="exampleFormControlInput1" class="required form-label">รายละเอียด</label>
                    <textarea name="" v-model="ServiceSms.description" placeholder="รายละเอียด.." required class="form-control form-control-solid" required id="" cols="30" rows="5"></textarea>
                </div>


                <div class="datetime d-flex justify-content-between">
                    <div class="mb-10 mx-2 w-100">
                        <label for="exampleFormControlInput1" class="required form-label">วันแรกของการบริการ </label>
                        <input type="datetime-local" v-model="ServiceSms.dateStart" class="form-control form-control-solid" required>
                    </div>

                    <div class="mb-10  mx-2 w-100">
                        <label for="exampleFormControlInput1" class="required form-label"> วันสุดท้ายของการบริการ </label>
                        <input type="datetime-local" v-model="ServiceSms.dateEnd" class="form-control form-control-solid" required>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button @click="clearServiceGroup" type="button" class="btn btn-light" data-bs-dismiss="modal">ปิด</button>
                <button @click="ServiceGroup" class="btn btn-primary">สร้างกลุ่มบริการ</button>
            </div>

        </div>
    </div>
</div>


<!--  แก้ไขกล่มบริการ -->
<div class="modal fade" tabindex="-1" role="dialog" id="editServiceGroup" data-focus-on="input:first">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">แก้ไขกลุ่มบริการ</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-solid fa-times"></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">

                <div class="mb-10 mx-2 w-100">
                    <label for="exampleFormControlInput1" class="required form-label">ชื่อบริการ</label>
                    <input type="text" v-model="eServiceSms.title" required class="form-control form-control-solid" placeholder="กรอกชื่อบริการ" />
                </div>


                <div class="mb-10 mx-2 w-100">
                    <label for="exampleFormControlInput1" class="required form-label">รายละเอียด</label>
                    <textarea name="" v-model="eServiceSms.description" placeholder="รายละเอียด.." required class="form-control form-control-solid" required id="" cols="30" rows="5"></textarea>
                </div>


                <div class="datetime d-flex justify-content-between">
                    <div class="mb-10 mx-2 w-100">
                        <label for="exampleFormControlInput1" class="required form-label">วันแรกของการบริการ </label>
                        <input type="datetime-local" v-model="eServiceSms.dateStart" class="form-control form-control-solid" required>
                    </div>

                    <div class="mb-10 mx-2 w-100">
                        <label for="exampleFormControlInput1" class="required form-label"> วันสุดท้ายของการบริการ </label>
                        <input type="datetime-local" v-model="eServiceSms.dateEnd" class="form-control form-control-solid" required>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">ปิด</button>
                <button @click="editServiceGroup" class="btn btn-primary">แก้ไขกลุ่มบริการ</button>
            </div>

        </div>
    </div>
</div>