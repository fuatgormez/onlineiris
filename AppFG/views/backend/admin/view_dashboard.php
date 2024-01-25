<section class="content-header">
    <h1>Dashboard</h1>
</section>

<?php if(in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])):?>
<!-- Dashboard Statistic -->
<section class="content">
    <div class="row">
        <!-- Total News Categories -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa fa-sitemap"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total News Categories</span>
                    <span class="info-box-number"><?php echo $this->global_variables->statistic()['total_category']; ?></span>
                </div>
            </div>
        </div>
        <!-- Total News Categories End -->
        <!-- Total News -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-newspaper"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total News</span>
                    <span class="info-box-number"><?php echo $this->global_variables->statistic()['total_news']; ?></span>
                </div>
            </div>
        </div>
        <!-- Total News End -->
        <!-- Total Event -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-orange"><i class="fa fa-calendar-week"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Events</span>
                    <span class="info-box-number"><?php echo $this->global_variables->statistic()['total_event']; ?></span>
                </div>
            </div>
        </div>
        <!-- Total Event End -->
        <!-- Total Tema Members -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-user-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Team Members</span>
                    <span class="info-box-number"><?php echo $this->global_variables->statistic()['total_team_member']; ?></span>
                </div>
            </div>
        </div>
        <!-- Total Tema Members End -->
        <!-- Total Clients  -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-teal"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Clients</span>
                    <span class="info-box-number"><?php echo $this->global_variables->statistic()['total_client']; ?></span>
                </div>
            </div>
        </div>
        <!-- Total Clients End -->
        <!-- Total Services  -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-maroon"><i class="fa fa-money-check"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Services</span>
                    <span class="info-box-number"><?php echo $this->global_variables->statistic()['total_service']; ?></span>
                </div>
            </div>
        </div>
        <!-- Total Services End -->
        <!-- Total Testimonials  -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-olive"><i class="fa fa-comment"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Testimonials</span>
                    <span class="info-box-number"><?php echo $this->global_variables->statistic()['total_testimonial']; ?></span>
                </div>
            </div>
        </div>
        <!-- Total Testimonials End -->
        <!-- Total Photos  -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-images"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Photos (Gallery)</span>
                    <span class="info-box-number"><?php echo $this->global_variables->statistic()['total_photo']; ?></span>
                </div>
            </div>
        </div>
        <!-- Total Photos End -->
        <!-- Total Pricing Table -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-navy"><i class="fa fa-dollar-sign"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Pricing Tables</span>
                    <span class="info-box-number"><?php echo $this->global_variables->statistic()['total_pricing_table']; ?></span>
                </div>
            </div>
        </div>
        <!-- Total Pricing Table End -->
    </div>
</section>
<!-- Dashboard Statistic End -->
<?php endif;?>

<?php if(in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])):?>
<section class="content">
    <!-- DB Row -->
    <div class="row">
        <!-- Clear Website Cache -->
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="box info-box">
                <h1 style="text-align: center"><a href="<?php echo base_url() ?>backend/admin/cache">Clear website
                        cache!</a></h1>
            </div>
        </div>
        <!-- Clear Website Cache End -->

        <!-- Database Import & Export -->
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="box info-box">
                <h1 style="text-align: center"><a href="<?php echo base_url() ?>backend/admin/database">Db Import </a> - <a href="<?php echo base_url() ?>backend/admin/database/dbexport" target="_blank">Backup
                        / Only Database</a></h1>
            </div>
        </div>
        <!-- Database Import & Export End -->
    </div>
    <!-- DB Row End -->

    <!-- Error logs - Todo's Row-->
    <div class="row">
        <!-- Error Log's -->
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="box info-box alert-danger">
                <div class="alert" style="padding:0;">
                    <a href="<?php echo base_url('backend/error_log'); ?>">
                        <h1 style="text-align: center"><i class="icon fa fa-ban"></i> Error Log!</h1>
                    </a>
                </div>
            </div>
        </div>
        <!-- Error Log's End -->
        <!-- Todo's -->
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="box info-box">
                <h1 style="text-align: center"><a href="<?php echo base_url('backend/admin/todo'); ?>">TODOs</a></h1>
            </div>
        </div>
        <!-- Todo's End -->
        <?php if (in_array($this->session->userdata('role'), ['Superadmin'])) :?>
        <!-- Check Unuploaded Order Item's -->
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="box info-box">
                <h1 style="text-align: center"><a href="<?php echo base_url('backend/shop/order/check_unuploaded_order_item'); ?>">Check Unuploated Order Items</a></h1>
                <p class="info-box-text" style="text-align: center">Bu islemin amaci yüklenemeyen order itemler icin istek olusturma kiosk tarafindan tekrar upload edilmesini saglamak</p>
                <p class="info-box-text text-danger" style="text-align: center">Bu islem uzun sürüyor ve sistemi kitliyor 3 dakika kadar bos zamanlarda yapilmasi daha iyi olur</p>
            </div>
        </div>
        <!-- Check Unuploaded Order Item's End-->
        <?php endif;?>
        <!-- Logs -->
        <div class="col-md-12 col-sm-12 col-xs-12">

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Activity</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <th>Comment</th>
                                    <th>Created By</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($logs, 0, 10) as $log) : ?>
                                    <tr>
                                        <td><?php echo $log['comment']; ?></td>
                                        <td><?php echo $log['created_by']; ?></td>
                                        <td><?php echo $log['type']; ?></td>
                                        <td><?php echo $log['created_on']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!-- logs End -->
    </div>
    <!-- Error logs - Todo's Row End -->
</section>
<?php endif;?>