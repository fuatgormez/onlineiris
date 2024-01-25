<section class="content-header">
    <div class="content-header-left">
        <h1>Add Coupon</h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url(); ?>backend/shop/coupon/add" class="btn btn-primary btn-sm">Add Coupon</a>
        <a href="<?php echo base_url(); ?>backend/shop/coupon" class="btn btn-primary btn-sm">View All</a>
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

            <?php echo form_open(base_url('backend/shop/coupon/edit/') . $coupon['id'], array('class' => 'form-horizontal')); ?>
            <div class="box box-info">
                <div class="box-body">
                    <div class="form-group">
                        <label for="coupon_code" class="col-sm-2 control-label">Code <span>*</span></label>
                        <div class="col-sm-3">
                            <input type="text" name="coupon_code" id="coupon_code" class="form-control" value="<?php echo $coupon['code']; ?>" required>
                        </div>
                        <div class="col-sm-2"><button class="btn ajax_generate_code cursor-pointer" data-type="edit"> Generate coupon code </button></div>
                    </div>
                    <div class="form-group">
                        <label for="discount_type" class="col-sm-2 control-label">Discount type <span>*</span></label>
                        <div class="col-sm-2">
                            <select class="form-control" name="discount_type" id="discount_type" required>
                                <option value="fixed_cart" <?php echo $coupon['discount_type'] === "fixed_cart" ? "selected" : ""; ?>>Fixed cart</option>
                                <option value="percentage" <?php echo $coupon['discount_type'] === "percentage" ? "selected" : ""; ?>>Percentage</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="amount_" style="<?php echo $coupon['discount_type'] === "percentage" ? "display:none" : ""; ?>">
                        <label for="amount" class="col-sm-2 control-label">Amount <span>*</span></label>
                        <div class="col-sm-2">
                            <input type="text" name="amount" id="amount" class="form-control" placeholder="10.99" value="<?php echo $coupon['amount']; ?>">
                        </div>
                    </div>
                    <div class="form-group" id="percent_" style="<?php echo $coupon['discount_type'] === "fixed_cart" ? "display:none" : ""; ?>">
                        <label for="percent" class="col-sm-2 control-label">Percent <span>*</span></label>
                        <div class="col-sm-2">
                            <input type="text" name="percent" id="percent" class="form-control" placeholder="10" value="<?php echo $coupon['percent']; ?>" minlength="1" maxlength="3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="valid_date_from" class="col-sm-2 control-label">Valid Date from <span>*</span></label>
                        <div class="col-sm-2">
                            <input type="date" name="valid_date_from" id="valid_date_from" class="form-control" value="<?php echo $coupon['valid_date_from']; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="valid_date_to" class="col-sm-2 control-label">Valid Date to <span>*</span></label>
                        <div class="col-sm-2">
                            <input type="date" name="valid_date_to" id="valid_date_to" class="form-control" value="<?php echo $coupon['valid_date_to']; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="max_limit" class="col-sm-2 control-label" data-toggle="tooltip" data-placement="right" title="Current Limit - <?php echo $coupon['current_limit']; ?>">Maximum limit</label>
                        <div class="col-sm-2">
                            <input type="text" name="max_limit" id="max_limit" class="form-control" placeholder="1000" value="<?php echo $coupon['max_limit']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="min_spend" class="col-sm-2 control-label">Minimum spend</label>
                        <div class="col-sm-2">
                            <input type="text" name="min_spend" id="min_spend" class="form-control" placeholder="10.99" value="<?php echo $coupon['min_spend']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="max_spend" class="col-sm-2 control-label">Maximum spend</label>
                        <div class="col-sm-2">
                            <input type="text" name="max_spend" id="max_spend" class="form-control" placeholder="20.99" value="<?php echo $coupon['max_spend']; ?>">
                        </div>
                    </div>

                    <!-- Title & Description  -->
                    <h3 class="seo-info">Title & Description</h3>
                    <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">Title</label>
                        <div class="col-sm-10">
                            <input type="text" name="title" class="form-control" value="<?php echo $coupon['title']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="editor1" name="description"><?php echo $coupon['description']; ?></textarea>
                        </div>
                    </div>
                    <!-- Title & Description End -->


                    <!-- Status  -->
                    <h3 class="seo-info">Status</h3>
                    <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-2">
                            <select name="status" id="status" class="form-control select2" style="width:auto;">
                                <option value="Active" <?php if ($coupon['status'] === 'Active') {
                                                            echo 'selected';
                                                        } ?>>Active</option>
                                <option value="Passive" <?php if ($coupon['status'] === 'Passive') {
                                                            echo 'selected';
                                                        } ?>>Passive</option>
                            </select>
                        </div>
                    </div>
                    <!-- Status End -->

                    <!-- Submit Button -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label"></label>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-success pull-left" name="form1">Submit</button>
                        </div>
                    </div>
                    <!-- Submit Button End -->

                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>

</section>