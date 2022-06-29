<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        VVI
    </title>
    <meta charset="utf-8" />
    <meta name="description" content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 94,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue &amp; Laravel versions. Grab your copy now and get life-time updates for free." />
    <meta name="keywords" content="Metronic, bootstrap, bootstrap 5, Angular, VueJs, React, Laravel, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Metronic - Bootstrap 5 HTML, VueJS, React, Angular &amp; Laravel Admin Dashboard Theme" />
    <meta property="og:url" content="https://keenthemes.com/metronic" />
    <meta property="og:site_name" content="Keenthemes | Metronic" />
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="shortcut icon" href="../assets/media/logos/favicon.ico" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="../assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-body">
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root" id="app">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(../assets/media/illustrations/dozzy-1/14.png">
            <!--begin::Content-->
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <!--begin::Logo-->
                <a href="index.php" class="mb-12">
                    <img alt="Logo" src="../assets/image/logo.png" class="h-40px" />
                </a>
                <!--end::Logo-->
                <!--begin::Wrapper-->
                <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <!--begin::Form-->
                    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="#">
                        <!--begin::Heading-->
                        <div class="text-center mb-10">
                            <!--begin::Title-->
                            <h1 class="text-dark mb-3">ลงชื่อเข้าสู่ระบบ</h1>
                            <!--end::Title-->
                        </div>
                        <!--begin::Heading-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="form-label fs-6 fw-bolder text-dark">ขื่อผู้ใช้งาน</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input v-model="email" class="form-control form-control-lg form-control-solid" type="text" name="email" autocomplete="off" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack mb-2">
                                <!--begin::Label-->
                                <label class="form-label fw-bolder text-dark fs-6 mb-0">รหัสผ่าน</label>
                                <!--end::Label-->
                                <!--begin::Link-->
                                <a href="forgetpassword.php" class="link-primary fs-6 fw-bolder">ลืมรหัสผ่านใช่ไหม ?</a>
                                <!--end::Link-->
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Input-->
                            <input @input="CheckPass" v-model="password" class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <!--begin::Submit button-->
                            <button @click="Submit" class="btn btn-lg btn-primary w-100 mb-5">
                                <span class="indicator-label">ลงชื่อเข้าใช้งาน</span>
                                <span class="indicator-progress">Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <!--end::Submit button-->
                            <!--begin::Separator-->

                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
            <!--begin::Footer-->

            <!--end::Footer-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Main-->

    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="../assets/plugins/global/plugins.bundle.js"></script>
    <script src="../assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="../assets/js/custom/authentication/sign-in/general.js"></script>
    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->

    <script>
        let app = new Vue({
            el: "#app",
            data: {
                err: false,
                email: "",
                password: ""
            },
            methods: {
                CheckPass($event) {
                    if ($event.target.value != "") {
                        this.err = false;
                    } else {
                        this.err = true;
                    }
                },
                Submit($event) {
                    $event.preventDefault();
                    if (this.email != "" && this.password != "") {
                        axios.post("../actions/ac_login.php", {
                            action: "login",
                            email: this.email,
                            password: this.password,
                        }).then((res) => {
                            if (res.data == 1) {
                                Swal.fire({
                                    title: 'สำเร็จ!',
                                    text: 'ยินดีต้อนรับเข้าสู่ระบบ',
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    window.location.replace("../index.php");
                                })
                            } else if (res.data == 2) {
                                Swal.fire({
                                    title: 'เกิดข้อผิดพลาด!',
                                    text: 'โปรดตรวจสอบ ชื่อผู้ใช้งาน หรือ รหัสผ่าน อีกครั้ง',
                                    icon: 'error',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            } else if (res.data == 3) {
                                Swal.fire({
                                    title: 'เกิดข้อผิดพลาด!',
                                    text: 'ชื่อผู้ใช้งาน ออนไลน์อยู่ ไม่สามารถใช้งานพร้อมกันได้ กรุณาตรวจสอบล๊อคอินใหม่อีกครั้ง',
                                    icon: 'error',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            }
                        })
                    } else {
                        Swal.fire({
                            title: 'เกิดข้อผิดพลาด!',
                            text: 'โปรดกรอกชื่อผู้ใช้งาน หรือ รหัสผ่าน',
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }

                }

            }
        });
    </script>

</body>

</html>