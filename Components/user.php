<?php
include("connect.php");

$statement = $conn->prepare("SELECT * FROM user_data");
$statement->execute();
$user = $statement->fetchAll();
// print_r($user)
?>
<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
    <span><i class="fas fa-solid fa-plus"></i></span> เพิ่มสมาชิก
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
                            <th class="min-w-150px">ลำดับ</th>
                            <th class="min-w-150px">ชื่อ - นามสกุล</th>
                            <th class="min-w-140px">อีเมลล์</th>
                            <th class="min-w-120px">เบอร์โทร</th>
                            <th class="min-w-100px text-end">จัดการ</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>

                        <?php
                        $i = 1;
                        foreach ($user as $val) {

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
                                            <p><?php echo $val['user_name']; ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p><?php echo $val['user_email']; ?></p>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex flex-column w-100 me-2">
                                        <div class="d-flex flex-stack mb-2">
                                            <p><?php echo $val['user_tel']; ?></p>
                                        </div>

                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end flex-shrink-0">
                                        <button @click="getUser('<?php echo $val['user_id']; ?>','<?php echo $val['user_name']; ?>','<?php echo $val['user_email']; ?>','<?php echo $val['user_tel']; ?>','<?php echo $val['user_id'] ?>')" type="button" class="btn btn-icon btn-bg-light btn-active-color-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#model_edit">
                                            <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
                                                    <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                        <button type="button" @click="delUser('<?php echo $val['user_id'] ?>')" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm">
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


<div class="modal fade" tabindex="-1" id="kt_modal_1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เพิ่มข้อมูลสมาชิก</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-solid fa-times"></i>
                </div>
                <!--end::Close-->
            </div>
            <form action="">
                <div class="modal-body">

                    <div>
                        <div class="mb-10">
                            <label for="exampleFormControlInput1" class="required form-label">ชื่อ - นามสกุล</label>
                            <input type="text" v-model="user.fullName" required class="form-control form-control-solid" placeholder="กรอกชื่อ - นามสกุล" />
                        </div>


                    </div>
                    <div class="">
                        <div class="mb-10">
                            <label for="exampleFormControlInput1" class="required form-label">อีเมลล์</label>
                            <input type="email" v-model="user.email" required class="form-control form-control-solid" placeholder="กรอกอีเมลล์" />
                        </div>
                    </div>

                    <div>
                        <div class="mb-10">
                            <label for="exampleFormControlInput1" class="required form-label">เบอร์โทร</label>
                            <input type="text" v-model="user.tel" required maxlength="10" class="form-control form-control-solid" placeholder="กรอกเบอร์โทร" />
                        </div>
                    </div>


                </div>

                <div class="modal-footer">
                    <button @click="clearUser" type="button" class="btn btn-light" data-bs-dismiss="modal">ปิด</button>
                    <button @click="addUser" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>




<div class="modal fade" tabindex="-1" id="model_edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">แก้ไขข้อมูลสมาชิก</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-solid fa-times"></i>
                </div>
                <!--end::Close-->
            </div>
            <form action="">
                <div class="modal-body">

                    <div>
                        <div class="mb-10">
                            <label for="exampleFormControlInput1" class="required form-label">ชื่อ - นามสกุล</label>
                            <input type="text" v-model="eUsers.fullName" required class="form-control form-control-solid" placeholder="กรอกชื่อ - นามสกุล" />
                        </div>


                    </div>
                    <div class="">
                        <div class="mb-10">
                            <label for="exampleFormControlInput1" class="required form-label">อีเมลล์</label>
                            <input type="email" v-model="eUsers.email" required class="form-control form-control-solid" placeholder="กรอกอีเมลล์" />
                        </div>
                    </div>

                    <div>
                        <div class="mb-10">
                            <label for="exampleFormControlInput1" class="required form-label">เบอร์โทร</label>
                            <input type="text" v-model="eUsers.tel" required maxlength="10" class="form-control form-control-solid" placeholder="กรอกเบอร์โทร" />
                        </div>
                    </div>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">ปิด</button>
                    <button @click="editUser" class="btn btn-primary">แก้ไข</button>
                </div>
            </form>
        </div>
    </div>
</div>