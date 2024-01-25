<section class="content-header">
    <div class="order_process">
        <?php foreach ($setting_shop_order_status as $key => $row_order_status) : ?>
            <div class="<?php echo $row_order_status['status']; ?> process-style" style="background-color:#<?php echo $row_order_status['color']; ?>"><a href="<?php echo base_url('backend/shop/order/index/' . $row_order_status['status']); ?>"><?php echo $row_order_status['text']; ?> <br> [ <?php echo $count_status_process[$key][$row_order_status['status']]; ?> ]</a></div>
            <?php endforeach; ?>
            <div class="process-style" style="background-color:#ac2"><a href="<?php echo base_url('backend/shop/order/index/pending'); ?>">Gegen Vorkasse</a></div>
            <div class="process-style" style="background-color:#f04"><a href="<?php echo base_url('backend/shop/order/index/storno'); ?>">Storno</a></div>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <?php if ($this->session->flashdata('error')) : ?>
                <div class="callout callout-danger">
                    <p><?php echo $this->session->flashdata('error'); ?></p>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('success')) : ?>
                <div class="callout callout-success">
                    <p><?php echo $this->session->flashdata('success'); ?></p>
                </div>
            <?php endif; ?>

            <div class="process_box" style="background:#<?php echo $status_process_color;?>">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div class="input-group order-search-div">
                            <input type="text" name="" class="form-control order-search-input" placeholder="Search...">
                        </div>
                        <div class="order-search-bg hide">
                            <div class="row">
                                <div class="col-md-12" style="margin:30px auto;padding:25px">
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Results:<span id="quick_search_result"></span></h3>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="30">ID</th>
                                                        <th width="10">Order Number</th>
                                                        <th width="70">Customer name</th>
                                                        <th width="80">Customer Address</th>
                                                        <th width="80">Total</th>
                                                        <th width="80">Paid</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="quick_search">

                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- /.box-body -->
                                    </div>
                                    <!-- /.box -->
                                </div>
                            </div>
                        </div> <!-- order-search-bg hide end -->

                        <table id="example1" class="content-table">
                            <thead>
                                <tr>
                                    <th width="10">ID</th>
                                    <th width="20">From</th>
                                    <th width="10">Order Number</th>
                                    <th width="180">Customer name</th>
                                    <th width="180">Customer Address</th>
                                    <th width="70">Email</th>
                                    <th width="20">Total</th>
                                    <th width="30">Paid</th>
                                    <th width="180">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order as $row) : ?>
                                    <tr data-link="<?php echo base_url('backend/shop/order/detail/' . $row['order_id'] . '/' . $row['order_number']); ?>">
                                        <td><?php echo $row['order_id']; ?></td>
                                        <td><?php echo $row['order_type']; ?></td>
                                        <td><?php echo $row['order_number']; ?></td>
                                        <td>
                                            <a href="<?php echo base_url('backend/shop/order/detail/' . $row['order_id'] . '/' . $row['order_number']); ?>"><?php echo $row['billing_firstname'] . " " . $row['billing_lastname']; ?></a>
                                        </td>
                                        <td>
                                            <a href="<?php echo base_url('backend/shop/order/detail/' . $row['order_id'] . '/' . $row['order_number']); ?>">
                                                <?php echo $row['billing_street'] . " " . $row['billing_street_no']; ?>, <?php echo $row['billing_postcode']; ?> <?php echo $row['billing_city']; ?>
                                            </a>
                                        </td>
                                        <td><?php echo $row['billing_email']; ?></td>
                                        <td><?php echo $row['total']; ?></td>
                                        <td><?php echo $row['paid']; ?></td>
                                        <td>
                                            <?php echo $row['date_purchased']; ?>
                                            <br />
                                            <a href="#" class="labelprint" data-order-number="<?php echo $row['order_number']; ?>" data-security-number="<?php echo $row['security_number']; ?>" data-expiry-date="<?php echo date('d-m-Y', strtotime('+1 year', strtotime($row['date_purchased']))); ?>"><i class="fa fa-2x fa-barcode"></i></a>
                                            <a href="<?php echo base_url('public/pdf/invoice/' . $row['order_number'] . '.pdf'); ?>" title="Order Confirmation" target="_blank"><i class="fa fa-2x fa-file-pdf"></i></a>
                                            <a href="<?php echo base_url('public/pdf/coupon/' . $row['order_number'] . '.pdf'); ?>" title="Shooting-Voucher Coupon" target="_blank"><i class="fa fa-2x fa-tag"></i></a>
                                            <a href="#" data-lang-code="<?php echo $row['store_lang_code']; ?>" data-message-type="<?php echo $row['payment_method'] === 'bankTransfer' ? 'bankTransfer' : 'mollie'; ?>" data-email="<?php echo $row['billing_email']; ?>" data-order-number="<?php echo $row['order_number']; ?>" title="Send e mail again"><i class="fa fa-2x fa-envelope re_send_email"></i></a>
                                            <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
                                                <a href="<?php echo base_url(); ?>backend/shop/order/delete/<?php echo $row['order_id']; ?>/<?php echo $row['order_number']; ?>" class="text-danger" onClick="return confirm('Are you sure?');"><i class="fa fa-2x fa-trash"></i></a>
                                            <?php endif; ?>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div><!-- #box -->
            </div><!-- #box process -->
        </div>
    </div>
</section>


<style>
    .dataTables_filter,
    .dataTables_info {
        display: none;
    }

    /** datatable close search input */
</style>