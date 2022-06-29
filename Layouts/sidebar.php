            <div id="kt_aside" class="aside pt-7 pb-4 pb-lg-7 pt-lg-17" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">
                <!--begin::Brand-->
                <div class="aside-logo flex-column-auto px-9 mb-9 mb-lg-17 mx-auto" id="kt_aside_logo">
                    <!--begin::Logo-->
                    <a href="index.php">
                        <img alt="Logo" src="assets/image/logo.png" class="h-40px logo" />
                    </a>
                    <!--end::Logo-->
                </div>
                <!--end::Brand-->
                <!--begin::Aside user-->
                <div class="aside-user mb-5 mb-lg-10" id="kt_aside_user">
                    <!--begin::User-->
                    <div class="d-flex align-items-center flex-column">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-75px mb-4">
                            <img src="assets/media/avatars/150-26.jpg" alt="" />
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Info-->
                        <div class="text-center">
                            <!--begin::Username-->
                            <a href="index.php" class="text-gray-900 text-hover-primary fs-4 fw-boldest"><?php echo $_SESSION['ses_name'] ?></a>
                            <!--end::Username-->
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::User-->
                </div>
                <!--end::Aside user-->


                <!--begin::Aside menu-->
                <div class="aside-menu flex-column-fluid ps-3 ps-lg-5 pe-1 mb-9" id="kt_aside_menu">
                    <!--begin::Aside Menu-->
                    <div class="w-100 hover-scroll-overlay-y pe-2 me-2" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_user, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu, #kt_aside_menu_wrapper" data-kt-scroll-offset="0">
                        <!--begin::Menu-->
                        <div class="menu menu-column menu-rounded fw-bold" id="#kt_aside_menu" data-kt-menu="true">
                            <div class="menu-item">
                                <a class="menu-link <?php ($_REQUEST['p'] == '') ? print 'active' : print ''; ?> " href="index.php">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->
                                        <span class="svg-icon svg-icon-5">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="black" />
                                                <path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title d-flex justify-content-center">หน้าหลัก</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a class="menu-link  <?php ($_REQUEST['p'] == 'user') ?  print 'active' : print ''; ?>" href="index.php?p=user">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->
                                        <span class="svg-icon svg-icon-5">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="black" />
                                                <path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title d-flex justify-content-center">สมาชิก</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a class="menu-link <?php ($_REQUEST['p'] == 'notify') ? print 'active' : print ''; ?>" href="index.php?p=notify">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->
                                        <span class="svg-icon svg-icon-5">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="black" />
                                                <path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title d-flex justify-content-center">แจ้งเตือน</span>

                                </a>
                            </div>





                        </div>
                        <!--end::Menu-->
                    </div>
                    <!--end::Aside Menu-->
                </div>
                <!--end::Aside menu-->


                <!--begin::Footer-->
                <div class="aside-footer flex-column-auto px-6 px-lg-9" id="kt_aside_footer">
                    <!--begin::User panel-->
                    <div class="d-flex flex-stack ms-7">
                        <!--begin::Link-->
                        <a href="Pages/signout.php" class="btn btn-sm btn-icon btn-active-color-primary btn-icon-gray-600 btn-text-gray-600">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr076.svg-->
                            <span class="svg-icon svg-icon-1 me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.3" width="12" height="2" rx="1" transform="matrix(-1 0 0 1 15.5 11)" fill="black" />
                                    <path d="M13.6313 11.6927L11.8756 10.2297C11.4054 9.83785 11.3732 9.12683 11.806 8.69401C12.1957 8.3043 12.8216 8.28591 13.2336 8.65206L16.1592 11.2526C16.6067 11.6504 16.6067 12.3496 16.1592 12.7474L13.2336 15.3479C12.8216 15.7141 12.1957 15.6957 11.806 15.306C11.3732 14.8732 11.4054 14.1621 11.8756 13.7703L13.6313 12.3073C13.8232 12.1474 13.8232 11.8526 13.6313 11.6927Z" fill="black" />
                                    <path d="M8 5V6C8 6.55228 8.44772 7 9 7C9.55228 7 10 6.55228 10 6C10 5.44772 10.4477 5 11 5H18C18.5523 5 19 5.44772 19 6V18C19 18.5523 18.5523 19 18 19H11C10.4477 19 10 18.5523 10 18C10 17.4477 9.55228 17 9 17C8.44772 17 8 17.4477 8 18V19C8 20.1046 8.89543 21 10 21H19C20.1046 21 21 20.1046 21 19V5C21 3.89543 20.1046 3 19 3H10C8.89543 3 8 3.89543 8 5Z" fill="#C4C4C4" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--begin::Major-->
                            <span class="d-flex flex-shrink-0 fw-bolder ">ออกจากระบบ</span>
                            <!--end::Major-->
                        </a>

                    </div>
                    <!--end::User panel-->
                </div>
                <!--end::Footer-->
            </div>