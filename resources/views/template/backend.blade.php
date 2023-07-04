<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="Keywords" content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4" />

    <!-- Title -->
    <title> @yield('title') </title>

    <!-- Favicon -->
    <link rel="icon" href="{{ url('templates-backend') }}/img/brand/favicon.png" type="image/x-icon" />

    <!-- Icons css -->
    <link href="{{ url('templates-backend') }}/css/icons.css" rel="stylesheet">

    <!--  Custom Scroll bar-->
    <link href="{{ url('templates-backend') }}/plugins/mscrollbar/jquery.mCustomScrollbar.css" rel="stylesheet" />

    <!--  Sidebar css -->
    <link href="{{ url('templates-backend') }}/plugins/sidebar/sidebar.css" rel="stylesheet">

    <!--- Style css --->
    <link href="{{ url('templates-backend') }}/css/style.css" rel="stylesheet">

    <!--- Dark-mode css --->
    <link href="{{ url('templates-backend') }}/css/style-dark.css" rel="stylesheet">

    <!---Skinmodes css-->
    <link href="{{ url('templates-backend') }}/css/skin-modes.css" rel="stylesheet" />

    @yield('style')

</head>

<body class="main-body">

    <!-- Loader -->
    <div id="global-loader">
        <img src="{{ url('templates-backend') }}/img/loader.svg" class="loader-img" alt="Loader">
    </div>
    <!-- /Loader -->

    <!-- Page -->
    <div class="page">

        <!-- main-header opened -->
        <div class="main-header nav nav-item hor-header">
            <div class="container">
                <div class="main-header-left ">
                    <a class="animated-arrow hor-toggle horizontal-navtoggle"><span></span></a><!-- sidebar-toggle-->
                    <a class="header-brand" href="index.html">
                        <img src="{{ url('templates-backend') }}/img/brand/logo-white.png" class="desktop-dark">
                        <img src="{{ url('templates-backend') }}/img/brand/logo.png" class="desktop-logo">
                        <img src="{{ url('templates-backend') }}/img/brand/favicon.png" class="desktop-logo-1">
                        <img src="{{ url('templates-backend') }}/img/brand/favicon-white.png" class="desktop-logo-dark">
                    </a>
                </div>
                <!-- search -->
                <div class="main-header-right">
                    <div class="nav nav-item  navbar-nav-right ml-auto">
                        <div class="nav-link" id="bs-example-navbar-collapse-1">
                            <form class="navbar-form" role="search">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search">
                                    <span class="input-group-btn">
                                        <button type="reset" class="btn btn-default">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <button type="submit" class="btn btn-default nav-link resp-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                            </svg>
                                        </button>
                                    </span>
                                </div>
                            </form>
                        </div>
                        <div class="dropdown main-profile-menu nav nav-item nav-link">
                            <a class="profile-user d-flex" href=""><img alt="" src="{{ url('templates-backend') }}/img/faces/6.jpg"></a>
                            <div class="dropdown-menu">
                                <div class="main-header-profile bg-primary p-3">
                                    <div class="d-flex wd-100p">
                                        <div class="main-img-user"><img alt="" src="{{ url('templates-backend') }}/img/faces/6.jpg" class=""></div>
                                        <div class="ml-3 my-auto">
                                            <h6>Petey Cruiser</h6><span>Premium Member</span>
                                        </div>
                                    </div>
                                </div>
                                <a class="dropdown-item" href=""><i class="bx bx-user-circle"></i>Profile</a>
                                <a class="dropdown-item" href=""><i class="bx bx-cog"></i> Edit Profile</a>
                                <a class="dropdown-item" href=""><i class="bx bxs-inbox"></i>Inbox</a>
                                <a class="dropdown-item" href=""><i class="bx bx-envelope"></i>Messages</a>
                                <a class="dropdown-item" href=""><i class="bx bx-slider-alt"></i> Account Settings</a>
                                <a class="dropdown-item" href="{{ route('login.logout') }}"><i class="bx bx-log-out"></i> Sign Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /main-header -->

        <!--Horizontal-main -->
        <div class="sticky">
            <div class="horizontal-main hor-menu clearfix side-header">
                <div class="horizontal-mainwrapper container clearfix">
                    <!--Nav-->
                    <nav class="horizontalMenu clearfix">
                        <?= menuBuilder() ?>
                    </nav>
                    <!--Nav-->
                </div>
            </div>
        </div>
        <!--Horizontal-main -->

        <!-- main-content opened -->
        <div class="main-content horizontal-content">

            @yield('content')

        </div>
        <!-- Container closed -->

        <!-- Footer opened -->
        <div class="main-footer ht-40">
            <div class="container-fluid pd-t-0-f ht-100p">
                <span>Copyright © 2021 <a href="#">Valex</a>. Designed by <a href="https://www.spruko.com/">Spruko</a> All rights reserved.</span>
            </div>
        </div>
        <!-- Footer closed -->

    </div>
    <!-- End Page -->

    <!-- Back-to-top -->
    <a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

    <!-- JQuery min js -->
    <script src="{{ url('templates-backend') }}/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Bundle js -->
    <script src="{{ url('templates-backend') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Ionicons js -->
    <script src="{{ url('templates-backend') }}/plugins/ionicons/ionicons.js"></script>

    <!--Internal Sparkline js -->
    <script src="{{ url('templates-backend') }}/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>

    <!-- Eva-icons js -->
    <script src="{{ url('templates-backend') }}/js/eva-icons.min.js"></script>

    <!-- Horizontalmenu js-->
    <script src="{{ url('templates-backend') }}/plugins/horizontal-menu/horizontal-menu-2/horizontal-menu.js"></script>

    <!-- custom js -->
    <script src="{{ url('templates-backend') }}/js/custom.js"></script>

    @yield('script')
</body>

</html>