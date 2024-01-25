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
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Panel</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/manager/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/manager/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/manager/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/manager/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/manager/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/manager/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/manager/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/manager/plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">



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

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-warning navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="<?php echo base_url(); ?>backend/manager/dashboard" class="nav-link">Home</a>
        </li>
      </ul>

      <!-- SEARCH FORM -->
      <form class="form-inline ml-2">
        <div class="input-group input-group-sm">
          <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-comments"></i>
            <span class="badge badge-danger navbar-badge">3</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    Brad Diesel
                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">Call me whenever you can...</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    John Pierce
                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">I got your message bro</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    Nora Silvester
                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">The subject goes here</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
          </div>
        </li>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">15</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">15 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i> 4 new messages
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-users mr-2"></i> 8 friend requests
              <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-file mr-2"></i> 3 new reports
              <span class="float-right text-muted text-sm">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar elevation-4 bg-navy sidebar-dark-warning">
      <!-- Brand Logo -->
      <a href="<?php echo base_url('backend/manager/dashboard'); ?>" class="brand-link text-center">
        <span class="brand-text font-weight-bold">IRISHOT</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <?php if ($this->session->userdata('photo') == '') : ?>
              <img src="<?php echo base_url(); ?>public/img/no-photo.jpg" class="img-circle elevation-2" alt="user photo">
            <?php else : ?>
              <img src="<?php echo base_url(); ?>public/uploads/<?php echo $this->session->userdata('photo'); ?>" class="img-circle elevation-2" alt="user photo">
            <?php endif; ?>
          </div>
          <div class="info accent-warning">
            <a href="#" class=""><?php echo $this->session->userdata('username'); ?></a>, 
            <a href="<?php echo base_url('backend/admin/login/logout');?>" class="pull-right">Logout</a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item has-treeview menu-open">
                        <a href="<?php echo base_url(); ?>backend/admin/dashboard" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                  <i class="right fas fa-angle-left"></i>
                </p>
                        </a>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="fa fa-bars"></i>
                            <p>Product
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item"><a href="<?php echo base_url(); ?>backend/shop/product_category" class="nav-link"><i class="fa fa-circle-o"></i> Product Category</a></li>
                            <li class="nav-item"><a href="<?php echo base_url(); ?>backend/shop/product" class="nav-link"><i class="fa fa-circle-o"></i>
                                    Product</a></li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="<?php echo base_url(); ?>backend/shop/store" class="nav-link">
                            <i class="fa fa-store"></i> <span>Store</span>
                        </a>
                    </li>

                    <?php if ($this->session->userdata('role') == 'Admin') : ?>
                        <li class="nav-item has-treeview">
                            <a href="<?php echo base_url(); ?>backend/admin/page" class="nav-link">
                                <i class="fa fa-pager"></i> <span>Page</span>
                            </a>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="<?php echo base_url(); ?>backend/admin/language" class="nav-link">
                                <i class="fa fa-language"></i> <span>Language</span>
                            </a>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="fa fa-newspaper"></i>
                                <p>
                                    News
                                    <i class="fa fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"><a href="<?php echo base_url(); ?>backend/admin/category" class="nav-link"><i class="fa fa-circle-o"></i>Category</a>
                                </li>
                                <li class="nav-item"><a href="<?php echo base_url(); ?>backend/admin/news" class="nav-link"><i class="fa fa-circle-o"></i> News</a>
                                </li>
                                <li class="nav-item"><a href="<?php echo base_url(); ?>backend/admin/comment" class="nav-link"><i class="fa fa-circle-o"></i> Comment</a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="<?php echo base_url(); ?>backend/admin/event" class="nav-link">
                                <i class="fa fa-calendar"></i> <span>Event</span>
                            </a>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="fa fa-comment"></i>
                                <p>Subscriber
                                    <i class="fa fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"><a href="<?php echo base_url(); ?>backend/admin/subscriber" class="nav-link"><i class="fa fa-circle-o"></i>All
                                        Subscribers</a></li>
                                <li class="nav-item"><a href="<?php echo base_url(); ?>backend/admin/subscriber/send_email" class="nav-link"><i class="fa fa-circle-o"></i>Email to Subscribers</a></li>
                            </ul>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="<?php echo base_url(); ?>backend/admin/team_member" class="nav-link">
                                <i class="fa fa-users"></i> <span>Team Member</span>
                            </a>
                        </li>

                        <li class="nav-item nav-treeview">
                            <a href="<?php echo base_url(); ?>backend/admin/slider" class="nav-link">
                                <i class="fa fa-images"></i> <span>Slider</span>
                            </a>
                        </li>

                        <li class="nav-item nav-treeview">
                            <a href="<?php echo base_url(); ?>backend/admin/testimonial" class="nav-link">
                                <i class="fa fa-user-plus"></i> <span>Testimonial</span>
                            </a>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="<?php echo base_url(); ?>backend/admin/photo" class="nav-link">
                                <i class="fa fa-camera"></i> <span>Photo Gallery</span>
                            </a>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="<?php echo base_url(); ?>backend/admin/pricing_table" class="nav-link">
                                <i class="fa fa-dollar-sign"></i> <span>Pricing Table</span>
                            </a>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="fa fa-bars"></i>
                                <p>Portfolio
                                    <i class="fa fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"><a href="<?php echo base_url(); ?>backend/admin/portfolio_category" class="nav-link"><i class="fa fa-circle-o"></i> Portfolio Category</a></li>
                                <li class="nav-item"><a href="<?php echo base_url(); ?>backend/admin/portfolio" class="nav-link"><i class="fa fa-circle-o"></i>
                                        Portfolio</a></li>
                            </ul>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="<?php echo base_url(); ?>backend/admin/client" class="nav-link">
                                <i class="fa fa-clone"></i> <span>Client</span>
                            </a>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="<?php echo base_url(); ?>backend/admin/service" class="nav-link">
                                <i class="fa fa-life-ring"></i> <span>Service</span>
                            </a>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="<?php echo base_url(); ?>backend/admin/feature" class="nav-link">
                                <i class="fa fa-cube"></i> <span>Feature</span>
                            </a>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="<?php echo base_url(); ?>backend/admin/why_choose" class="nav-link">
                                <i class="fa fa-question-circle"></i> <span>Why Choose Us</span>
                            </a>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="<?php echo base_url(); ?>backend/admin/how_we_works" class="nav-link">
                                <i class="fa fa-building"></i> <span>How We Works</span>
                            </a>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="<?php echo base_url(); ?>backend/admin/faq" class="nav-link">
                                <i class="fa fa-bolt"></i> <span>FAQ</span>
                            </a>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="<?php echo base_url(); ?>backend/admin/social_media" class="nav-link">
                                <i class="fa fa-address-book"></i> <span>Social Media</span>
                            </a>
                        </li>


                    <?php endif; ?>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">