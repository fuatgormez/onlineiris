<?php
$class_name = '';
$segment_2 = 0;
$segment_3 = 0;
$segment_4 = 0;
$class_name = $this->router->fetch_class();
$segment_2 = $this->uri->segment('2');
$segment_3 = $this->uri->segment('3');
$segment_4 = $this->uri->segment('4');

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Panel</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/shop/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/shop/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/shop/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/shop/css/datepicker3.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/shop/css/all.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/shop/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/shop/css/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/shop/css/jquery.fancybox.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/shop/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/shop/css/_all-skins.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/shop/css/summernote.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/shop/css/magnific-popup.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/shop/css/style.css?<?php echo uniqid();?>">


    <style>
        .skin-blue .wrapper,
        .skin-blue .main-header .logo,
        .skin-blue .main-header .navbar,
        .skin-blue .main-sidebar,
        .content-header .content-header-right a,
        .content .form-horizontal .btn-success {
            background-color: #004a6b !important;
            background-image: linear-gradient(to bottom, transparent, rgba(0, 0, 0, .3));
        }

        .content-header .content-header-right a,
        .content .form-horizontal .btn-success {
            border-color: #4172a5 !important;
        }

        .content-header>h1,
        .content-header .content-header-left h1,
        h3 {
            color: #4172a5 !important;
        }

        .box.box-info {
            border-top-color: #4172a5 !important;
        }

        .skin-blue .sidebar a {
            color: #fff !important;
        }

        .skin-blue .sidebar-menu>li>.treeview-menu {
            margin: 0 !important;
        }

        .skin-blue .sidebar-menu>li>a {
            border-left: 0 !important;
        }
    </style>


</head>

<body class="hold-transition fixed skin-blue sidebar-mini">

    <div class="wrapper">

        <header class="main-header">

            <a href="<?php echo base_url(); ?>backend/admin/dashboard" class="logo">
                <span class="logo-lg">FG CMS</span>
            </a>

            <!-- Navbar -->
            <nav class="navbar navbar-static-top">

                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>

                <a href="<?php echo base_url('backend/admin/dashboard');?>" class="btn btn-danger" style="margin-top:7px">ADMIN</a>
                <a href="<?php echo base_url('backend/manager/dashboard');?>" class="btn btn-warning" style="margin-top:7px">MANAGER</a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="<?php echo base_url(); ?>" target="_blank">Visit Website</a>
                        </li>

                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <?php if ($this->session->userdata('photo') == '') : ?>
                                    <img src="<?php echo base_url(); ?>public/img/no-photo.jpg" class="user-image" alt="user photo">
                                <?php else : ?>
                                    <img src="<?php echo base_url(); ?>public/uploads/<?php echo $this->session->userdata('photo'); ?>" class="user-image" alt="user photo">
                                <?php endif; ?>

                                <span class="hidden-xs"><?php echo $this->session->userdata('username'); ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-footer">
                                    <div>
                                        <a href="<?php echo base_url(); ?>backend/admin/profile" class="btn btn-default btn-flat">Edit
                                            Profile</a>
                                    </div>

                                    <?php if ($this->session->userdata('role') == 'Admin') : ?>
                                        <div class="m-10">
                                            <a href="<?php echo base_url(); ?>backend/admin/setting" class="btn btn-default btn-flat">
                                                Settings <i class="fa fa-cog"></i>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <div>
                                        <a href="<?php echo base_url(); ?>backend/admin/login/logout" class="btn btn-default btn-flat">
                                            Log out <i class="fa fa-times-circle"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>

            </nav>
            <!-- Navbar End -->
        </header>

        <aside class="main-sidebar">
            <section class="sidebar">


                <ul class="sidebar-menu">

                    <li class="treeview <?php if ($class_name == 'dashboard') {
                                            echo 'active';
                                        } ?>">
                        <a href="<?php echo base_url(); ?>backend/admin/dashboard">
                            <i class="fa fa-laptop"></i> <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="treeview <?php if (($class_name == 'product') || ($class_name == 'product_category')) {
                                            echo 'active';
                                        } ?>">
                        <a href="#">
                            <i class="fa fa-bars"></i>
                            <span>Product</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo base_url(); ?>backend/shop/product_category"><i class="fa fa-circle-o"></i> Product Category</a></li>
                            <li><a href="<?php echo base_url(); ?>backend/shop/product"><i class="fa fa-circle-o"></i>
                                    Product</a></li>
                        </ul>
                    </li>

                    <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
                        <li class="treeview <?php if (($class_name == 'order')) {
                                                echo 'active';
                                            } ?>">
                            <a href="<?php echo base_url(); ?>backend/shop/order">
                                <i class="fa fa-store"></i> <span>Order</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="treeview <?php if (($class_name == 'store')) {
                                            echo 'active';
                                        } ?>">
                        <a href="<?php echo base_url(); ?>backend/shop/store">
                            <i class="fa fa-store"></i> <span>Store</span>
                        </a>
                    </li>

                    <li class="treeview <?php if (($class_name == 'coupon')) {
                                            echo 'active';
                                        } ?>">
                        <a href="<?php echo base_url(); ?>backend/shop/coupon">
                            <i class="fa fa-tag"></i> <span>Coupon</span>
                        </a>
                    </li>

                    <?php if ($this->session->userdata('role') == 'Admin') : ?>
                        <li class="treeview <?php if (($class_name == 'page')) {
                                                echo 'active';
                                            } ?>">
                            <a href="<?php echo base_url(); ?>backend/admin/page">
                                <i class="fa fa-pager"></i> <span>Page</span>
                            </a>
                        </li>

                        <li class="treeview <?php if (($class_name == 'language')) {
                                                echo 'active';
                                            } ?>">
                            <a href="<?php echo base_url(); ?>backend/admin/language">
                                <i class="fa fa-language"></i> <span>Language</span>
                            </a>
                        </li>

                        <li class="treeview <?php if (($class_name == 'category') || ($class_name == 'news') || ($class_name == 'comment')) {
                                                echo 'active';
                                            } ?>">
                            <a href="#">
                                <i class="fa fa-newspaper"></i>
                                <span>News</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url(); ?>backend/admin/category"><i class="fa fa-circle-o"></i>Category</a>
                                </li>
                                <li><a href="<?php echo base_url(); ?>backend/admin/news"><i class="fa fa-circle-o"></i> News</a>
                                </li>
                                <li><a href="<?php echo base_url(); ?>backend/admin/comment"><i class="fa fa-circle-o"></i> Comment</a>
                                </li>
                            </ul>
                        </li>

                        <li class="treeview <?php if (($class_name == 'event')) {
                                                echo 'active';
                                            } ?>">
                            <a href="<?php echo base_url(); ?>backend/admin/event">
                                <i class="fa fa-calendar"></i> <span>Event</span>
                            </a>
                        </li>

                        <li class="treeview <?php if (($class_name == 'subscriber')) {
                                                echo 'active';
                                            } ?>">
                            <a href="#">
                                <i class="fa fa-comment"></i>
                                <span>Subscriber</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url(); ?>backend/admin/subscriber"><i class="fa fa-circle-o"></i>All
                                        Subscribers</a></li>
                                <li><a href="<?php echo base_url(); ?>backend/admin/subscriber/send_email"><i class="fa fa-circle-o"></i>Email to Subscribers</a></li>
                            </ul>
                        </li>

                        <li class="treeview <?php if (($class_name == 'team_member')) {
                                                echo 'active';
                                            } ?>">
                            <a href="<?php echo base_url(); ?>backend/admin/team_member">
                                <i class="fa fa-users"></i> <span>Team Member</span>
                            </a>
                        </li>

                        <li class="treeview <?php if (($class_name == 'slider')) {
                                                echo 'active';
                                            } ?>">
                            <a href="<?php echo base_url(); ?>backend/admin/slider">
                                <i class="fa fa-images"></i> <span>Slider</span>
                            </a>
                        </li>

                        <li class="treeview <?php if (($class_name == 'testimonial')) {
                                                echo 'active';
                                            } ?>">
                            <a href="<?php echo base_url(); ?>backend/admin/testimonial">
                                <i class="fa fa-user-plus"></i> <span>Testimonial</span>
                            </a>
                        </li>

                        <li class="treeview <?php if (($class_name == 'photo')) {
                                                echo 'active';
                                            } ?>">
                            <a href="<?php echo base_url(); ?>backend/admin/photo">
                                <i class="fa fa-camera"></i> <span>Photo Gallery</span>
                            </a>
                        </li>

                        <li class="treeview <?php if (($class_name == 'pricing_table')) {
                                                echo 'active';
                                            } ?>">
                            <a href="<?php echo base_url(); ?>backend/admin/pricing_table">
                                <i class="fa fa-dollar-sign"></i> <span>Pricing Table</span>
                            </a>
                        </li>

                        <li class="treeview <?php if (($class_name == 'portfolio') || ($class_name == 'portfolio_category')) {
                                                echo 'active';
                                            } ?>">
                            <a href="#">
                                <i class="fa fa-bars"></i>
                                <span>Portfolio</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url(); ?>backend/admin/portfolio_category"><i class="fa fa-circle-o"></i> Portfolio Category</a></li>
                                <li><a href="<?php echo base_url(); ?>backend/admin/portfolio"><i class="fa fa-circle-o"></i>
                                        Portfolio</a></li>
                            </ul>
                        </li>

                        <li class="treeview <?php if (($class_name == 'client')) {
                                                echo 'active';
                                            } ?>">
                            <a href="<?php echo base_url(); ?>backend/admin/client">
                                <i class="fa fa-clone"></i> <span>Client</span>
                            </a>
                        </li>

                        <li class="treeview <?php if (($class_name == 'service')) {
                                                echo 'active';
                                            } ?>">
                            <a href="<?php echo base_url(); ?>backend/admin/service">
                                <i class="fa fa-life-ring"></i> <span>Service</span>
                            </a>
                        </li>

                        <li class="treeview <?php if (($class_name == 'feature')) {
                                                echo 'active';
                                            } ?>">
                            <a href="<?php echo base_url(); ?>backend/admin/feature">
                                <i class="fa fa-cube"></i> <span>Feature</span>
                            </a>
                        </li>

                        <li class="treeview <?php if (($class_name == 'why_choose')) {
                                                echo 'active';
                                            } ?>">
                            <a href="<?php echo base_url(); ?>backend/admin/why_choose">
                                <i class="fa fa-question-circle"></i> <span>Why Choose Us</span>
                            </a>
                        </li>

                        <li class="treeview <?php if (($class_name == 'how_we_works')) {
                                                echo 'active';
                                            } ?>">
                            <a href="<?php echo base_url(); ?>backend/admin/how_we_works">
                                <i class="fa fa-building"></i> <span>How We Works</span>
                            </a>
                        </li>

                        <li class="treeview <?php if (($class_name == 'faq')) {
                                                echo 'active';
                                            } ?>">
                            <a href="<?php echo base_url(); ?>backend/admin/faq">
                                <i class="fa fa-bolt"></i> <span>FAQ</span>
                            </a>
                        </li>

                        <li class="treeview <?php if (($class_name == 'social_media')) {
                                                echo 'active';
                                            } ?>">
                            <a href="<?php echo base_url(); ?>backend/admin/social_media">
                                <i class="fa fa-address-book"></i> <span>Social Media</span>
                            </a>
                        </li>


                    <?php endif; ?>
                </ul>
            </section>
        </aside>

        <div class="content-wrapper">