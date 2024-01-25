<section class="content-header">
    <div class="content-header-left">
        <h1>View Coupons</h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url(); ?>backend/shop/coupon/add" class="btn btn-primary btn-sm">Add Coupon</a>
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

            <?php if ($this->session->flashdata('warning')) : ?>
                <div class="callout callout-warning">
                    <p><?php echo $this->session->flashdata('warning'); ?></p>
                </div>
            <?php endif; ?>

            <div class="box box-info">
                <div class="box-body table-responsive">
                    <table id="couponlist" class="content-table dataTable">
                        <thead>
                            <tr>
                                <th width="10">SL</th>
                                <th>Code</th>
                                <th>Amount</th>
                                <th>Percent</th>
                                <th>Discount type</th>
                                <th>Valid Date</th>
                                <th>Limit</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tdbody>
                        </tdbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>