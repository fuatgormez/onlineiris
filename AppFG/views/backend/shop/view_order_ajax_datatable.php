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
            <div class="box box-info">
                <div class="box-body table-responsive">
                    <table id="orderlist" class="content-table dataTable1">
                        <thead>
                            <tr>
                                <th width="10">SL</th>
                                <th>From</th>
                                <th>Order Number</th>
                                <th>Customer Name</th>
                                <th>Email</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tdbody>
                        </tdbody>
                    </table>
                </div>
            </div><!-- #box -->
            </div><!-- #box process -->
        </div>
    </div>
</section>