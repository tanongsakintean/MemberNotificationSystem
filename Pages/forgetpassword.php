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
                            <h1 class="text-dark mb-3">???????????????????????????????????????????????????</h1>
                            <!--end::Title-->
                        </div>
                        <!--begin::Heading-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="form-label fs-6 fw-bolder text-dark">???????????????????????????????????????</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input v-model="email" class="form-control form-control-lg form-control-solid" type="text" autocomplete="off" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->


                        <div class="fv-row mb-10">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack mb-2">
                                <!--begin::Label-->
                                <label class="form-label fw-bolder text-dark fs-6 mb-0">????????????????????????</label>
                                <!--end::Label-->
                                <a href="login.php" class="link-primary fs-6 fw-bolder">????????????????????????????????????????????????????????????????????????????????? ?</a>

                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Input-->


                            <input v-model="tel" class="form-control form-control-lg form-control-solid" type="text" autocomplete=" off" />



                            <!--end::Input-->
                        </div>
                        <!--begin::Link-->
                        <!--end::Link-->
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <!--begin::Submit button-->
                            <button @click="Submit" class="btn btn-lg btn-primary w-100 mb-5">
                                <span class="indicator-label">?????????</span>
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
                tel: ""
            },
            methods: {
                Submit($event) {
                    $event.preventDefault();
                    if ((this.email != "" && this.tel != "") && this.tel.length == 10) {
                        axios.post("../actions/ac_login.php", {
                            action: "forgetpassword",
                            email: this.email,
                            tel: this.tel,
                        }).then((res) => {
                            if (res.data['status'] == 1) {
                                window.location.replace("newpassword.php?id=" + res.data['id']);
                            } else if (res.data['status'] == 2) {
                                Swal.fire({
                                    title: '??????????????????????????????????????????!',
                                    text: '????????????????????????????????? ??????????????????????????????????????? ???????????? ???????????????????????? ????????????????????????',
                                    icon: 'error',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            }
                        })
                    } else {
                        Swal.fire({
                            title: '??????????????????????????????????????????!',
                            text: '??????????????????????????????????????????????????????????????? ???????????? ???????????????????????? ??????????????????????????????',
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