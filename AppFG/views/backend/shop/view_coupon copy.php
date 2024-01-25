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
                    <table id="example1" class="content-table dataTable">
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
                        <tbody>
                            <?php foreach ($coupon as $row) : ?>
                                <tr class="<?php echo date('Y-m-d') > $row['valid_date_to'] ? 'blink_me' : ''; ?>">
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['code']; ?></td>
                                    <td><?php echo $row['amount']; ?></td>
                                    <td><?php echo $row['percent']; ?></td>
                                    <td><?php echo $row['discount_type']; ?></td>
                                    <td><?php echo $row['valid_date_from']; ?> | <?php echo $row['valid_date_to']; ?></td>
                                    <td><span data-toggle="tooltip" data-placement="top" title="Maximum Limit"><?php echo $row['max_limit']; ?></span> / <span data-toggle="tooltip" data-placement="top" title="Current Limit"><?php echo $row['current_limit']; ?></span></td>
                                    <td><?php echo $row['status']; ?></td>
                                    <td>
                                        <a href="<?php echo base_url(); ?>backend/shop/coupon/edit/<?php echo $row['id']; ?>" class="btn btn-primary btn-xs">Edit</a>
                                        <a href="<?php echo base_url(); ?>backend/shop/coupon/delete/<?php echo $row['id']; ?>" class="btn btn-danger btn-xs" onClick="return confirm('Are you sure?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>