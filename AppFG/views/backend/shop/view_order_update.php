<section class="content-header">
    <div class="content-header-left">
        <h1>Detail Order</h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url('backend/shop/order'); ?>" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>
<section class="content">
    <!-- box box-info -->
    <div class="box box-info">
        <!-- invoice -->
        <div class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        <i class="fa fa-eye"></i> IRISSHOT, Inc.
                        <small class="pull-right">Date: <?php echo $order_detail['date_purchased']; ?></small>
                    </h2>
                </div>
                <!-- /.col -->
            </div>

            <?php echo form_open_multipart(base_url() . 'backend/shop/order/update/'.$order_detail['order_id'].'/'.$order_detail['order_number'], array('class' => 'form-horizontal', 'autocomplete' => 'off')); ?>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    <p class="text-bold text-info">Invoice Address</p>
                    <address>
                        <div class="row">
                            <div class="col-xs-6 mb-10"><input name="billing_firstname" class="form-control" value="<?php echo $order_detail['billing_firstname']; ?>" placeholder="Billing Firstname"></div>
                            <div class="col-xs-6 mb-10"><input name="billing_lastname" class="form-control" value="<?php echo $order_detail['billing_lastname']; ?>" placeholder="Billing Lastname"></div>
                            <div class="col-xs-12 mb-10"><input name="billing_phone" class="form-control" value="<?php echo $order_detail['billing_phone']; ?>" placeholder="Billing Phone"></div>
                            <div class="col-xs-12 mb-10"><input name="billing_email" class="form-control" value="<?php echo $order_detail['billing_email']; ?>" placeholder="Billing Email"></div>

                            <div class="col-xs-9"><input name="billing_street" class="form-control" value="<?php echo $order_detail['billing_street']; ?>" placeholder="Billing Street"></div>
                            <div class="col-xs-3"><input name="billing_street_no" class="form-control" value="<?php echo $order_detail['billing_street_no']; ?>" placeholder="No"></div>
                            <div class="col-xs-12"><input name="billing_postcode" class="form-control" value="<?php echo $order_detail['billing_postcode']; ?>" placeholder="Billing Postcode"></div>
                            <div class="col-xs-6 mt-10"><input name="billing_city" class="form-control" value="<?php echo $order_detail['billing_city']; ?>" placeholder="Billing City"></div>
                            <div class="col-xs-6 mt-10"><input name="billing_country" class="form-control" value="<?php echo $order_detail['billing_country']; ?>" placeholder="Billing Country"></div>

                            <hr>
                            <div class="col-xs-12 m-20"><?php echo $order_detail['billing_comment']; ?></div>
                        </div>
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <p class="text-bold text-info">Shipping Address</p>
                    <address>
                        <div class="row">
                            <div class="col-xs-6 mb-10"><input name="shipping_firstname" class="form-control" value="<?php echo $order_detail['shipping_firstname']; ?>" placeholder="Shipping Firstname"></div>
                            <div class="col-xs-6 mb-10"><input name="shipping_lastname" class="form-control" value="<?php echo $order_detail['shipping_lastname']; ?>" placeholder="Shipping Lastname"></div>
                            <div class="col-xs-12 mb-10"><input name="shipping_phone" class="form-control" value="<?php echo $order_detail['shipping_phone']; ?>" placeholder="Shipping Phone"></div>
                            <div class="col-xs-12 mb-10"><input name="shipping_email" class="form-control" value="<?php echo $order_detail['shipping_email']; ?>" placeholder="Shipping Email"></div>

                            <div class="col-xs-9"><input name="shipping_street" class="form-control" value="<?php echo $order_detail['shipping_street']; ?>" placeholder="Shipping Street"></div>
                            <div class="col-xs-3"><input name="shipping_street_no" class="form-control" value="<?php echo $order_detail['shipping_street_no']; ?>" placeholder="No"></div>
                            <div class="col-xs-12"><input name="shipping_postcode" class="form-control" value="<?php echo $order_detail['shipping_postcode']; ?>" placeholder="Shipping Postcode"></div>
                            <div class="col-xs-6 mt-10"><input name="shipping_city" class="form-control" value="<?php echo $order_detail['shipping_city']; ?>" placeholder="Shipping City"></div>
                            <div class="col-xs-6 mt-10"><input name="shipping_country" class="form-control" value="<?php echo $order_detail['shipping_country']; ?>" placeholder="Shipping Country"></div>

                            <hr>
                            <div class="col-xs-12 m-20"><?php echo $order_detail['shipping_comment']; ?></div>
                        </div>
                    </address>
                </div>
                <!-- /.col -->

                <div class="col-sm-4 invoice-col">
                    <p class="text-bold">Order Number #<?php echo $order_detail['order_number']; ?></p>
                    <p class="text-bold">Security Number #<?php echo $order_detail['security_number']; ?></p>
                    <br>
                    <b>Order ID:</b> <?php echo $order_detail['order_id']; ?>
                </div>
                <!-- /.col -->
            </div>
            <div class="row">
                <div class="col-sm-4 invoice-col">
                    <select class="form-control" name="status">
                        <option <?php echo $order_detail['status'] === "Active" ? 'selected' : '' ; ?> value="Active">Active</option>
                        <option <?php echo $order_detail['status'] === "Passive" ? 'selected' : '' ; ?> value="Passive">Passive</option>
                    </select>
                </div>
                <div class="col-sm-4 invoice-col">
                    <select class="form-control" name="order_type">
                        <option <?php echo $order_detail['order_type'] === "web" ? 'selected' : '' ; ?> value="web">web</option>
                        <option <?php echo $order_detail['order_type'] === "kiosk" ? 'selected' : '' ; ?> value="kiosk">kiosk</option>
                        <option <?php echo $order_detail['order_type'] === "irisshot" ? 'selected' : '' ; ?> value="irisshot">irisshot</option>
                        <option <?php echo $order_detail['order_type'] === "groupon" ? 'selected' : '' ; ?> value="groupon">groupon</option>
                        <option <?php echo $order_detail['order_type'] === "dein_deal" ? 'selected' : '' ; ?> value="dein_deal">Dein Deal</option>
                    </select>
                </div>
                <!-- /.col -->
                <div class="col-sm-12 invoice-col" style="margin-top:30px">
                    <input type="hidden" name="order_id" value="<?php echo $order_detail['order_id']; ?>">
                    <button type="submit" class="btn btn-block btn-success pull-left" name="form1">Update</button>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <?php echo form_close(); ?>

            <!-- Table row -->
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <hr>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Item Price</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order_item as $item) : ?>
                                <tr>
                                    <td><?php echo $item['item_name']; ?> (<?php echo $item['item_product_id']; ?>)</td>
                                    <td><?php echo $item['item_price']; ?></td>
                                    <td><?php echo $item['item_qty']; ?></td>
                                    <td><?php echo $item['item_currency_icon']; ?> <?php echo $item['item_subtotal']; ?></td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <!-- accepted payments column -->

                <div class="col-xs-4 col-xs-offset-8">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th style="width:50%">Subtotal:</th>
                                    <td><?php echo $order_detail['store_currency_icon']; ?> <?php echo $order_detail['total']; ?></td>
                                </tr>
                                <tr>
                                    <th>Tax (19%)</th>
                                    <td><?php echo $order_detail['store_currency_icon']; ?> <?php echo number_format($order_detail['total'] - ($order_detail['total'] / 1.19), 2); ?></td>
                                </tr>
                                <tr>
                                    <th>Shipping:</th>
                                    <td><?php echo $order_detail['store_currency_icon']; ?> 0.00</td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td><?php echo $order_detail['store_currency_icon']; ?> <?php echo $order_detail['total']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

        </div>
        <!-- invoice end -->
    </div>
    <!-- box box-info end -->
</section>