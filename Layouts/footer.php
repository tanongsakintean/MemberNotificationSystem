<!--end::Wrapper-->
</div>
<!--end::Page-->
</div>





<!----แจ้งเตือน--->
<!--end::Footer-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
    <span class="svg-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black" />
            <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="black" />
        </svg>
    </span>
    <!--end::Svg Icon-->
</div>

<!--begin::Activities drawer-->
<div id="kt_activities" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="activities" data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_activities_toggle" data-kt-drawer-close="#kt_activities_close">
    <div class="card shadow-none rounded-0">
        <!--begin::Header-->
        <div class="card-header" id="kt_activities_header">
            <h3 class="card-title fw-bolder text-dark">การแจ้งเตือน</h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5" id="kt_activities_close">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </button>
            </div>
        </div>
        <!--end::Header-->
        <?php

        $statement = $conn->prepare("SELECT * FROM warn_sv LEFT JOIN service_data ON warn_sv.sv_id = service_data.sv_id ");
        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $key => $val) {
        ?>
            <!--begin::Record-->
            <div class="m-3 d-flex align-items-center border border-dashed border-gray-300 rounded min-w-750px px-7 py-3 mb-5">
                <!--begin::Title-->
                <a href="index.php?p=service&id=<?php echo $val['sv_id']; ?>&clear=1" class="fs-5 text-dark text-hover-primary fw-bold w-50px min-w-200px"><?php echo $val['sv_name'] ?></a>
                <!--end::Title-->
                <!--begin::Label-->
                <div class="min-w-175px pe-2">
                    <?php if (strlen($val['sv_description']) > 50) { ?>
                        <span class="badge badge-light text-muted"><?php echo substr($val['sv_description'], 0, 50) . "..."; ?> </span>
                    <?php } else { ?>
                        <span class="badge badge-light text-muted"><?php echo $val['sv_description']; ?> </span>
                    <?php } ?>
                </div>
                <!--end::Label-->
                <!--begin::Progress-->
                <div class="min-w-125px pe-2">
                    <?php if ($val['sv_status'] == 0) { ?>
                        <span class="badge badge-light-success">กำลังบริการ</span>
                    <?php } else if ($val['sv_status']  == 2) { ?>
                        <span class="badge badge-light-warning">บริการใกล้หมด</span>
                    <?php } else { ?>
                        <span class="badge badge-light-danger">หมดบริการ</span>
                    <?php } ?>
                </div>
                <a href="index.php?p=service&id=<?php echo $val['sv_id']; ?>&clear=1" class="btn btn-sm btn-light btn-active-light-primary">จัดการ</a>
                <!--end::Progress-->
            </div>
            <!--end::Record-->
        <?php } ?>


        <?php
        $statement = $conn->prepare("SELECT * FROM warn_noti LEFT JOIN notify_data ON warn_noti.noti_id = notify_data.noti_id ");
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $key => $val) {
            $statement = $conn->prepare("SELECT * FROM service_data WHERE sv_id = :sv_id");
            $statement->execute(array(':sv_id' => $val['sv_id']));
            $sv_name = $statement->fetchAll()[0]['sv_name'];
            $sv_id = $statement->fetchAll()[0]['sv_id'];
        ?>
            <!--begin::Record-->
            <div class="m-3 d-flex align-items-center border border-dashed border-gray-300 rounded min-w-750px px-7 py-3 mb-5">
                <!--begin::Title-->
                <a href="index.php?p=infomessage&id=<?php echo $val['noti_id']; ?>&sid=<?php echo $sv_id; ?>&clear=2" class="fs-5 text-dark text-hover-primary fw-bold w-50px min-w-200px"><?php echo $val['noti_sender'] ?></a>
                <!--end::Title-->
                <!--begin::Label-->

                <div class="min-w-175px pe-2">
                    <?php if ($sv_name != "") { ?>
                        <span class="badge badge-light-primary text-primary"> <?php echo $sv_name; ?></span>
                    <?php } else { ?>
                        <span class="badge badge-light-primary text-primary"> ไม่มีบริการ</span>
                    <?php } ?>
                </div>
                <!--end::Label-->
                <!--begin::Progress-->
                <div class="min-w-125px pe-2">
                    <?php if ($val['noti_status'] == 0) { ?>
                        <span class="badge badge-light-success">กำลังบริการ</span>
                    <?php } else if ($val['noti_status']  == 2) { ?>
                        <span class="badge badge-light-warning">บริการใกล้หมด</span>
                    <?php } else { ?>
                        <span class="badge badge-light-danger">หมดบริการ</span>
                    <?php } ?>
                </div>
                <a href="index.php?p=infomessage&id=<?php echo $val['noti_id']; ?>&sid=<?php echo $sv_id; ?>&clear=2" class="btn btn-sm btn-light btn-active-light-primary">จัดการ</a>
                <!--end::Progress-->
            </div>
            <!--end::Record-->
        <?php } ?>





    </div>
</div>


<!--begin::Javascript-->
<!--begin::Global Javascript Bundle(used by all pages)-->
<!--begin::Global Javascript Bundle(used by all pages)-->
<!--begin::Page Vendors Javascript(used by this page)-->

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/plugins/global/plugins.bundle.js"></script>
<script src="assets/js/scripts.bundle.js"></script>
<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Page Vendors Javascript-->
<!--begin::Page Custom Javascript(used by this page)-->
<script src="assets/js/custom/apps/user-management/users/list/table.js"></script>
<script src="assets/js/custom/apps/user-management/users/list/export-users.js"></script>
<script src="assets/js/custom/apps/user-management/users/list/add.js"></script>
<script src="assets/js/custom/widgets.js"></script>
<script src="assets/js/custom/apps/chat/chat.js"></script>
<script src="assets/js/custom/modals/create-app.js"></script>
<script src="assets/js/custom/modals/upgrade-plan.js"></script>
<!--end::Javascript-->
<script>
    let app = new Vue({
        el: "#app",
        data: {
            user: {
                fullName: "",
                tel: "",
                email: "",
            },
            eUsers: {
                id: "",
                fullName: "",
                tel: "",
                email: "",
            },
            MessageSms: {
                allSelected: false,
                multipleTel: [],
                singleTel: "",
                sender: "เลือกผู้ส่ง",
                message: "",
                TimeSend: "เลือกเวลาส่ง",
                dateTimeStart: "null",
                dateTime: "null",
                id: "",
            },
            eMessageSms: {
                allSelected: false,
                multipleTel: [],
                singleTel: "",
                sender: "เลือกผู้ส่ง",
                message: "",
                TimeSend: "เลือกเวลาส่ง",
                dateTimeStart: "",
                dateTime: "null",
                id: "",
            },
            ServiceSms: {
                title: "",
                description: "",
                dateStart: "",
                dateEnd: "",
            },
            eServiceSms: {
                title: "",
                description: "",
                dateStart: "",
                dateEnd: "",
                id: "",
            },
        },
        mounted() {},
        methods: {
            async selectAll() {
                if (!this.MessageSms.allSelected) {
                    if (this.MessageSms.multipleTel != []) {
                        this.MessageSms.multipleTel = [];
                    }
                }
            },
            clearTel() {
                this.MessageSms.multipleTel = [];
            },
            addUser($e) {
                $e.preventDefault();
                if (
                    this.user.fullName != "" &&
                    this.user.tel != "" &&
                    this.user.email != "" &&
                    this.user.tel.length == 10
                ) {
                    //check tel is digit only

                    if (this.user.tel.match(/^[0-9]+$/)) {
                        err = false;
                    } else {
                        err = true;
                    }

                    if (!err) {
                        Swal.fire({
                            title: "คุณแน่ใจหรือไม่",
                            icon: "info",
                            text: "คุณแน่ใจหรือไม่ที่จะบันทึกข้อมูล",
                            showCancelButton: true,
                            confirmButtonText: "ใช่",
                            cancelButtonText: "ไม่",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                axios
                                    .post("actions/ac_user.php", {
                                        action: "add",
                                        fullName: this.user.fullName,
                                        tel: this.user.tel,
                                        email: this.user.email,
                                    })
                                    .then((res) => {
                                        if (res.data == 1) {
                                            Swal.fire({
                                                title: "เกิดข้อผิดพลาด!",
                                                icon: "error",
                                                text: "อีเมลล์ซำ้โปรดตรวจสอบอีกครั้ง!",
                                                timer: 1300,
                                                showConfirmButton: false,
                                            });
                                        } else if (res.data == 2) {
                                            Swal.fire({
                                                title: "สำเร็จ!",
                                                icon: "success",
                                                text: "เพิ่มข้อมูลสำเร็จ!",
                                                timer: 1300,
                                                showConfirmButton: false,
                                            }).then(() => window.location.reload());
                                        } else if (res.data == 3) {
                                            Swal.fire({
                                                title: "เกิดข้อผิดพลาด!",
                                                icon: "error",
                                                text: "เกิดข้อผิดพลาดโปรดลองติดต่อแอดมิน!",
                                                timer: 1300,
                                                showConfirmButton: false,
                                            });
                                        }
                                    });
                            }
                        });
                    } else {
                        Swal.fire({
                            title: "เกิดข้อผิดพลาด!",
                            icon: "error",
                            text: "โปรดกรอกเบอร์โทรศัพท์ให้ถูกต้อง!",
                            timer: 1300,
                            showConfirmButton: false,
                        });
                    }
                } else {
                    Swal.fire({
                        title: "เกิดข้อผิดพลาด!",
                        icon: "error",
                        text: "โปรดกรอกข้อมูลให้ครบถ้วน",
                        timer: 1300,
                        showConfirmButton: false,
                    });
                }
            },
            getUser(...$data) {
                this.eUsers.fullName = $data[1];
                this.eUsers.email = $data[2];
                this.eUsers.tel = $data[3];
                this.eUsers.id = $data[0];
            },
            editUser($e) {
                $e.preventDefault();
                if (
                    this.eUsers.fullName != "" &&
                    this.eUsers.tel != "" &&
                    this.eUsers.email != "" &&
                    this.eUsers.tel.length == 10
                ) {
                    if (this.eUsers.tel.match(/^[0-9]+$/)) {
                        err = false;
                    } else {
                        err = true;
                    }

                    if (!err) {
                        Swal.fire({
                            title: "คุณต้องการแก้ไขข้อมูลนี้หรือไม่?",
                            icon: "info",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "ใช่",
                            cancelButtonText: "ยกเลิก",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                axios
                                    .post("actions/ac_user.php", {
                                        action: "update",
                                        id: this.eUsers.id,
                                        fullName: this.eUsers.fullName,
                                        email: this.eUsers.email,
                                        tel: this.eUsers.tel,
                                        id: this.eUsers.id,
                                    })
                                    .then((res) => {
                                        if (res.data == 1) {
                                            Swal.fire({
                                                title: "สำเร็จ!",
                                                icon: "success",
                                                text: "แก้ไขข้อมูลสำเร็จ!",
                                                timer: 1300,
                                                showConfirmButton: false,
                                            }).then(() => window.location.reload());
                                        }
                                    });
                            }
                        });
                    } else {
                        Swal.fire({
                            title: "เกิดข้อผิดพลาด!",
                            icon: "error",
                            text: "โปรดกรอกเบอร์โทรศัพท์ให้ถูกต้อง!",
                            timer: 1300,
                            showConfirmButton: false,
                        });
                    }
                } else {
                    Swal.fire({
                        title: "เกิดข้อผิดพลาด!",
                        icon: "error",
                        text: "โปรดกรอกข้อมูลให้ครบถ้วน!",
                        timer: 1300,
                        showConfirmButton: false,
                    });
                }
            },
            delUser($id) {
                Swal.fire({
                    title: "คุณแน่ใจหรือไม่",
                    icon: "info",
                    text: "คุณแน่ใจหรือไม่ที่จะลบข้อมูล",
                    showCancelButton: true,
                    confirmButtonText: "ลบ",
                    cancelButtonText: "ยกเลิก",
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios
                            .post("actions/ac_user.php", {
                                action: "del",
                                id: $id,
                            })
                            .then((res) => {
                                if (res.data == 1) {
                                    Swal.fire({
                                        title: "สำเร็จ!",
                                        icon: "success",
                                        text: "ลบข้อมูลสำเร็จ!",
                                        timer: 1300,
                                        showConfirmButton: false,
                                    }).then(() => window.location.reload());
                                } else {
                                    Swal.fire({
                                        title: "เกิดข้อผิดพลาด!",
                                        icon: "error",
                                        text: "เกิดข้อผิดพลาดโปรดลองติดต่อแอดมิน!",
                                        timer: 1300,
                                        showConfirmButton: false,
                                    });
                                }
                            });
                    }
                });
            },
            clearUser() {
                this.user.fullName = "";
                this.user.tel = "";
                this.user.email = "";
            },
            messageSingle($e) {
                $e.preventDefault();
                if (
                    this.MessageSms.sender != "เลือกผู้ส่ง" &&
                    this.MessageSms.message != "" &&
                    this.MessageSms.TimeSend != ""
                ) {
                    let err = false;
                    //insert multipleTel to tel array
                    let tel = [];
                    if (this.MessageSms.multipleTel != []) {
                        tel = this.MessageSms.multipleTel;
                    }
                    //check length tel array
                    if (this.MessageSms.singleTel != "") {

                        for (let i = 0; i < this.MessageSms.singleTel.split(",").length; i++) {
                            if (this.MessageSms.singleTel.split(",")[i].length == 10) {
                                if (this.MessageSms.singleTel.split(",")[i].match(/^[0-9]+$/)) {
                                    err = false;
                                } else {
                                    err = true;
                                    break;
                                }
                            } else {
                                err = true;
                                break;
                            }
                        }

                    }

                    if (!err) {
                        Swal.fire({
                            title: "คุณแน่ใจหรือไม่ที่จะส่งข้อความนี้?",
                            icon: "info",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "ใช่",
                            cancelButtonText: "ยกเลิก",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                axios
                                    .post("actions/ac_message.php", {
                                        action: "message",
                                        allSelected: this.MessageSms.allSelected,
                                        tel: [...tel, ...this.MessageSms.singleTel.split(",")],
                                        sender: this.MessageSms.sender,
                                        message: this.MessageSms.message,
                                        TimeSend: this.MessageSms.TimeSend,
                                        dateTime: this.MessageSms.dateTime,
                                        id: 0,
                                    })
                                    .then((res) => {
                                        console.log(res.data);
                                        if (res.data == 1) {
                                            Swal.fire({
                                                title: "สำเร็จ!",
                                                icon: "success",
                                                text: "ส่งข้อความสำเร็จ!",
                                                timer: 1300,
                                                showConfirmButton: false,
                                            }).then(() => window.location.reload());
                                        } else if (res.data == 2) {
                                            Swal.fire({
                                                title: "เกิดข้อผิดพลาด!",
                                                icon: "error",
                                                text: "เกิดข้อผิดพลาดโปรดลองอีกครั้ง!",
                                                timer: 1300,
                                                showConfirmButton: false,
                                            }).then(() => {
                                                window.location.reload();
                                            });
                                        } else if (res.data == 3) {
                                            Swal.fire({
                                                title: "เกิดข้อผิดพลาด!",
                                                icon: "error",
                                                text: "โปรดกรอกเบอร์โทร หรือ เลือกสมาชิก",
                                                timer: 1300,
                                                showConfirmButton: false,
                                            });
                                        }
                                    });
                            }
                        });
                    } else {
                        Swal.fire({
                            title: "เกิดข้อผิดพลาด!",
                            icon: "error",
                            text: "โปรดกรอกเบอร์โทรบุคคลทั่วไปให้ถูกต้อง",
                            timer: 1300,
                            showConfirmButton: false,
                        });
                    }
                } else {
                    Swal.fire({
                        title: "เกิดข้อผิดพลาด!",
                        icon: "error",
                        text: "โปรดกรอกข้อมูลให้ครบถ้วน!",
                        timer: 1300,
                        showConfirmButton: false,
                    });
                }
            },
            getMessageData(...$data) {
                this.eMessageSms.id = $data[0];
                this.eMessageSms.sender = $data[1];
                this.eMessageSms.message = $data[2];
                this.eMessageSms.dateTimeStart =
                    $data[3].substring(6, 10) -
                    543 +
                    "-" +
                    $data[3].substring(3, 5) +
                    "-" +
                    $data[3].substring(0, 2) +
                    "T" +
                    $data[3].substring(11, 16);
                this.eMessageSms.dateTime =
                    $data[4].substring(6, 10) -
                    543 +
                    "-" +
                    $data[4].substring(3, 5) +
                    "-" +
                    $data[4].substring(0, 2) +
                    "T" +
                    $data[4].substring(11, 16);

                axios
                    .post("actions/ac_message.php", {
                        action: "getTelmultiple",
                        id: $data[0],
                    })
                    .then((res) => {
                        this.eMessageSms.multipleTel = [...res.data.tel];
                    });

                axios
                    .post("actions/ac_message.php", {
                        action: "getTelsingle",
                        id: $data[0],
                    })
                    .then((res) => {
                        let tel = "";
                        for (let i = 0; i < res.data.length; i++) {
                            tel = tel + res.data[i].guest_tel + ",";
                        }
                        this.eMessageSms.singleTel = tel;
                    });
            },
            clearMessageSingle() {
                this.MessageSms.allSelected = false;
                this.MessageSms.multipleTel = [];
                this.MessageSms.singleTel = "";
                this.MessageSms.sender = "เลือกผู้ส่ง";
                this.MessageSms.message = "";
                this.MessageSms.TimeSend = "เลือกเวลาส่ง";
                this.MessageSms.dateTime = "null";
            },
            ServiceGroup($e) {
                $e.preventDefault();
                if (
                    this.ServiceSms.title != "" &&
                    this.ServiceSms.description != "" &&
                    this.ServiceSms.dateStart != "" &&
                    this.ServiceSms.dateEnd != ""
                ) {
                    Swal.fire({
                        title: `คุณแน่ใจหรือไม่ที่จะสร้างกลุ่มบริการ ${this.ServiceSms.title} นี้?`,
                        icon: "info",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "ใช่",
                        cancelButtonText: "ยกเลิก",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios
                                .post("actions/ac_message.php", {
                                    action: "ServiceGroup_add",
                                    title: this.ServiceSms.title,
                                    description: this.ServiceSms.description,
                                    dateStart: this.ServiceSms.dateStart,
                                    dateEnd: this.ServiceSms.dateEnd,
                                })
                                .then((res) => {
                                    if (res.data == 1) {
                                        Swal.fire({
                                            title: "สำเร็จ!",
                                            icon: "success",
                                            text: "สร้างกลุ่มบริการสำเร็จ!",
                                            timer: 1300,
                                            showConfirmButton: false,
                                        }).then(() => window.location.reload());
                                    } else if (res.data == 2) {
                                        Swal.fire({
                                            title: "เกิดข้อผิดพลาด!",
                                            icon: "error",
                                            text: "เกิดข้อผิดพลาดโปรดลองอีกครั้ง!",
                                            timer: 1300,
                                            showConfirmButton: false,
                                        }).then(() => {
                                            window.location.reload();
                                        });
                                    }
                                });
                        }
                    });
                } else {
                    Swal.fire({
                        title: "เกิดข้อผิดพลาด!",
                        icon: "error",
                        text: "โปรดกรอกข้อมูลให้ครบถ้วน!",
                        timer: 1300,
                        showConfirmButton: false,
                    });
                }
            },
            getServiceGroup(...$data) {
                this.eServiceSms.title = $data[0];
                this.eServiceSms.description = $data[1];
                this.eServiceSms.dateStart =
                    $data[2].substring(6, 10) -
                    543 +
                    "-" +
                    $data[2].substring(3, 5) +
                    "-" +
                    $data[2].substring(0, 2) +
                    "T" +
                    $data[2].substring(11, 16);
                this.eServiceSms.dateEnd =
                    $data[3].substring(6, 10) -
                    543 +
                    "-" +
                    $data[3].substring(3, 5) +
                    "-" +
                    $data[3].substring(0, 2) +
                    "T" +
                    $data[3].substring(11, 16);
                this.eServiceSms.id = $data[4];
            },
            editServiceGroup($e) {
                $e.preventDefault();
                if (
                    this.eServiceSms.title != "" &&
                    this.eServiceSms.description != "" &&
                    this.eServiceSms.dateStart != "" &&
                    this.eServiceSms.dateEnd != ""
                ) {
                    Swal.fire({
                        title: "คุณต้องการแก้ไขกลุ่มบริการนี้หรือไม่?",
                        icon: "info",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "ใช่",
                        cancelButtonText: "ยกเลิก",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios
                                .post("actions/ac_message.php", {
                                    action: "ServiceGroup_edit",
                                    id: this.eServiceSms.id,
                                    title: this.eServiceSms.title,
                                    description: this.eServiceSms.description,
                                    dateStart: this.eServiceSms.dateStart,
                                    dateEnd: this.eServiceSms.dateEnd,
                                })
                                .then((res) => {
                                    if (res.data == 1) {
                                        Swal.fire({
                                            title: "สำเร็จ!",
                                            icon: "success",
                                            text: "แก้ไขข้อมูลกลุ่มบริการสำเร็จ!",
                                            timer: 1300,
                                            showConfirmButton: false,
                                        }).then(() => window.location.reload());
                                    } else if (res.data == 2) {
                                        Swal.fire({
                                            title: "เกิดข้อผิดพลาด!",
                                            icon: "error",
                                            text: "เกิดข้อผิดพลาดโปรดลองอีกครั้ง!",
                                            timer: 1300,
                                            showConfirmButton: false,
                                        }).then(() => {
                                            window.location.reload();
                                        });
                                    }
                                });
                        }
                    });
                } else {
                    Swal.fire({
                        title: "เกิดข้อผิดพลาด!",
                        icon: "error",
                        text: "โปรดกรอกข้อมูลให้ครบถ้วน!",
                        timer: 1300,
                        showConfirmButton: false,
                    });
                }
            },
            delServiceGroup($id) {
                Swal.fire({
                    title: "คุณต้องการลบกลุ่มบริการนี้หรือไม่?",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "ลบ",
                    cancelButtonText: "ยกเลิก",
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios
                            .post("actions/ac_message.php", {
                                action: "ServiceGroup_del",
                                id: $id,
                            })
                            .then((res) => {
                                console.log(res.data);
                                if (res.data == 1) {
                                    Swal.fire({
                                        title: "สำเร็จ!",
                                        icon: "success",
                                        text: "ลบข้อมูลกลุ่มบริการสำเร็จ!",
                                        timer: 1300,
                                        showConfirmButton: false,
                                    }).then(() => window.location.reload());
                                } else if (res.data == 2) {
                                    Swal.fire({
                                        title: "เกิดข้อผิดพลาด!",
                                        icon: "error",
                                        text: "เกิดข้อผิดพลาดโปรดลองอีกครั้ง!",
                                        timer: 1300,
                                        showConfirmButton: false,
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                }
                            });
                    }
                });
            },
            clearServiceGroup() {
                this.ServiceSms.title = "";
                this.ServiceSms.description = "";
                this.ServiceSms.dateStart = "";
                this.ServiceSms.dateEnd = "";
            },
            messageMulti($id) {
                if (
                    this.MessageSms.sender != "เลือกผู้ส่ง" &&
                    this.MessageSms.message != "" &&
                    this.MessageSms.TimeSend != ""
                ) {
                    err = false;
                    //insert multipleTel to tel array
                    let tel = [];
                    if (this.MessageSms.multipleTel != []) {
                        tel = this.MessageSms.multipleTel;
                    }

                    if (this.MessageSms.singleTel != "") {
                        for (let i = 0; i < this.MessageSms.singleTel.split(",").length; i++) {
                            if (this.MessageSms.singleTel.split(",")[i].length == 10) {
                                if (this.MessageSms.singleTel.split(",")[i].match(/^[0-9]+$/)) {
                                    err = false;
                                } else {
                                    err = true;
                                    break;
                                }
                            } else {
                                err = true;
                                break;
                            }
                        }
                    }

                    if (!err) {
                        Swal.fire({
                            title: "คุณแน่ใจหรือไม่ที่จะส่งข้อความนี้?",
                            icon: "info",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "ใช่",
                            cancelButtonText: "ยกเลิก",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                axios
                                    .post("actions/ac_message.php", {
                                        action: "message",
                                        allSelected: this.MessageSms.allSelected,
                                        tel: [...tel, ...this.MessageSms.singleTel.split(",")],
                                        sender: this.MessageSms.sender,
                                        message: this.MessageSms.message,
                                        TimeSend: this.MessageSms.TimeSend,
                                        dateTime: this.MessageSms.dateTime,
                                        id: $id,
                                    })
                                    .then((res) => {
                                        if (res.data == 1) {
                                            Swal.fire({
                                                title: "สำเร็จ!",
                                                icon: "success",
                                                text: "ส่งข้อความสำเร็จ!",
                                                timer: 1300,
                                                showConfirmButton: false,
                                            }).then(() => window.location.reload());
                                        } else if (res.data == 2) {
                                            Swal.fire({
                                                title: "เกิดข้อผิดพลาด!",
                                                icon: "error",
                                                text: "เกิดข้อผิดพลาดโปรดลองอีกครั้ง!",
                                                timer: 1300,
                                                showConfirmButton: false,
                                            }).then(() => {
                                                window.location.reload();
                                            });
                                        } else if (res.data == 3) {
                                            Swal.fire({
                                                title: "เกิดข้อผิดพลาด!",
                                                icon: "error",
                                                text: "โปรดกรอกเบอร์โทร หรือ เลือกสมาชิก",
                                                timer: 1300,
                                                showConfirmButton: false,
                                            });
                                        }
                                    });
                            }
                        });
                    } else {
                        Swal.fire({
                            title: "เกิดข้อผิดพลาด!",
                            icon: "error",
                            text: "โปรดกรอกเบอร์โทรบุคคลทั่วไปให้ถูกต้อง",
                            timer: 1300,
                            showConfirmButton: false,
                        });
                    }
                } else {
                    Swal.fire({
                        title: "เกิดข้อผิดพลาด!",
                        icon: "error",
                        text: "โปรดกรอกข้อมูลให้ครบถ้วน!",
                        timer: 1300,
                        showConfirmButton: false,
                    });
                }
            },
            eMessageMulti($e) {
                $e.preventDefault();
                if (
                    this.eMessageSms.sender != "เลือกผู้ส่ง" &&
                    this.eMessageSms.message != "" &&
                    this.eMessageSms.TimeSend != ""
                ) {
                    err = false;
                    //insert multipleTel to tel array
                    let tel = [];
                    if (this.eMessageSms.multipleTel != []) {
                        tel = this.eMessageSms.multipleTel;
                    }

                    if (this.eMessageSms.singleTel != "") {
                        for (let i = 0; i < this.eMessageSms.singleTel.split(",").length; i++) {
                            if (this.eMessageSms.singleTel.split(",")[i].length == 10) {
                                if (this.eMessageSms.singleTel.split(",")[i].match(/^[0-9]+$/)) {
                                    err = false;
                                } else {
                                    err = true;
                                    break;
                                }
                            } else {
                                err = true;
                                break;
                            }
                        }
                    }

                    if (!err) {
                        Swal.fire({
                            title: "คุณแน่ใจหรือไม่ที่จะส่งข้อความนี้?",
                            icon: "info",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "ใช่",
                            cancelButtonText: "ยกเลิก",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                axios
                                    .post("actions/ac_message.php", {
                                        action: "Emessage",
                                        allSelected: this.eMessageSms.allSelected,
                                        tel: [...tel, ...this.eMessageSms.singleTel.split(",")],
                                        sender: this.eMessageSms.sender,
                                        message: this.eMessageSms.message,
                                        dateTimeStart: this.eMessageSms.dateTimeStart,
                                        dateTime: this.eMessageSms.dateTime,
                                        id: this.eMessageSms.id,
                                    })
                                    .then((res) => {
                                        if (res.data == 1) {
                                            Swal.fire({
                                                title: "สำเร็จ!",
                                                icon: "success",
                                                text: "แก้ไขข้อความสำเร็จ!",
                                                timer: 1300,
                                                showConfirmButton: false,
                                            }).then(() => window.location.reload());
                                        } else if (res.data == 2) {
                                            Swal.fire({
                                                title: "เกิดข้อผิดพลาด!",
                                                icon: "error",
                                                text: "เกิดข้อผิดพลาดโปรดลองอีกครั้ง!",
                                                timer: 1300,
                                                showConfirmButton: false,
                                            }).then(() => {
                                                window.location.reload();
                                            });
                                        } else if (res.data == 3) {
                                            Swal.fire({
                                                title: "เกิดข้อผิดพลาด!",
                                                icon: "error",
                                                text: "โปรดกรอกเบอร์โทร หรือ เลือกสมาชิก",
                                                timer: 1300,
                                                showConfirmButton: false,
                                            });
                                        }
                                    });
                            }
                        });
                    } else {
                        Swal.fire({
                            title: "เกิดข้อผิดพลาด!",
                            icon: "error",
                            text: "โปรดกรอกเบอร์โทรบุคคลทั่วไปให้ถูกต้อง",
                            timer: 1300,
                            showConfirmButton: false,
                        });
                    }
                } else {
                    Swal.fire({
                        title: "เกิดข้อผิดพลาด!",
                        icon: "error",
                        text: "โปรดกรอกข้อมูลให้ครบถ้วน!",
                        timer: 1300,
                        showConfirmButton: false,
                    });
                }
            },
            delMessageData($id) {
                Swal.fire({
                    title: "คุณแน่ใจหรือไม่ที่จะส่งข้อความนี้?",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "ใช่",
                    cancelButtonText: "ยกเลิก",
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios
                            .post("actions/ac_message.php", {
                                action: "delMessage",
                                id: $id,
                            })
                            .then((res) => {
                                if (res.data == 1) {
                                    Swal.fire({
                                        title: "สำเร็จ!",
                                        icon: "success",
                                        text: "ลบข้อความสำเร็จ!",
                                        timer: 1300,
                                        showConfirmButton: false,
                                    }).then(() => window.location.reload());
                                } else if (res.data == 2) {
                                    Swal.fire({
                                        title: "เกิดข้อผิดพลาด!",
                                        icon: "error",
                                        text: "เกิดข้อผิดพลาดโปรดลองอีกครั้ง!",
                                        timer: 1300,
                                        showConfirmButton: false,
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                }
                            });
                    }
                });
            },
        },
    });
    $("#datatable").DataTable({
        language: {
            lengthMenu: "Show _MENU_",
        },
        dom: "<'row'" +
            "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
            "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
            ">" +
            "<'table-responsive'tr>" +
            "<'row'" +
            "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
            "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
            ">",
    });
    $(".service").DataTable({
        language: {
            lengthMenu: "Show _MENU_",
        },
        dom: "<'row'" +
            "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
            "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
            ">" +
            "<'table-responsive'tr>" +
            "<'row'" +
            "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
            "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
            ">",
    });
</script>

</body>

</html>