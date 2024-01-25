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

            <?php echo form_open(base_url() . 'backend/shop/coupon/add', array('class' => 'form-horizontal')); ?>
            <div class="box box-info">
                <div class="box-body">
                    <div class="form-group">
                        <label for="coupon_code" class="col-sm-2 control-label">Code <span>*</span></label>
                        <div class="col-sm-3">
                            <input type="text" name="coupon_code" id="coupon_code" class="form-control" required>
                        </div>
                        <div class="col-sm-2"><button class="btn ajax_generate_code cursor-pointer" data-type="add"> Generate coupon code </button></div>
                    </div>
                    <div class="form-group">
                        <label for="discount_type" class="col-sm-2 control-label">Discount type <span>*</span></label>
                        <div class="col-sm-2">
                            <select class="form-control" name="discount_type" id="discount_type" required>
                                <option value="fixed_cart">Fixed cart</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="amount_">
                        <label for="amount" class="col-sm-2 control-label">Amount <span>*</span></label>
                        <div class="col-sm-2">
                            <input type="text" name="amount" id="amount" class="form-control" placeholder="10.99" required>
                        </div>
                    </div>
                    <div class="form-group" id="percent_" style="display:none">
                        <label for="percent" class="col-sm-2 control-label">Percent <span>*</span></label>
                        <div class="col-sm-2">
                            <input type="text" name="percent" id="percent" class="form-control" placeholder="10" value="0" minlength="1" maxlength="3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="valid_date_from" class="col-sm-2 control-label">Valid Date from<span>*</span></label>
                        <div class="col-sm-2">
                            <input type="date" name="valid_date_from" id="valid_date_from" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="valid_date_to" class="col-sm-2 control-label">Valid Date to<span>*</span></label>
                        <div class="col-sm-2">
                            <input type="date" name="valid_date_to" id="valid_date_to" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="max_limit" class="col-sm-2 control-label">Maximum limit</label>
                        <div class="col-sm-2">
                            <input type="text" name="max_limit" id="max_limit" class="form-control" placeholder="1000" value="1000">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="min_spend" class="col-sm-2 control-label">Minimum spend</label>
                        <div class="col-sm-2">
                            <input type="text" name="min_spend" id="min_spend" class="form-control" placeholder="10.99">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="max_spend" class="col-sm-2 control-label">Maximum spend</label>
                        <div class="col-sm-2">
                            <input type="text" name="max_spend" id="max_spend" class="form-control" placeholder="20.99">
                        </div>
                    </div>


                    <!-- Title & Description  -->
                    <h3 class="seo-info">Title & Description</h3>
                    <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">Title</label>
                        <div class="col-sm-10">
                            <input type="text" name="title" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="editor1" name="description"></textarea>
                        </div>
                    </div>
                    <!-- Title & Description End -->


                    <!-- Status  -->
                    <h3 class="seo-info">Status</h3>
                    <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-2">
                            <select name="status" id="status" class="form-control select2" style="width:auto;">
                                <option value="Active" selected>Active</option>
                                <option value="Passive">Passive</option>
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
<?php if (in_array($this->session->userdata('role'), ['Superadmin'])) : ?>
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-body">
                        <h1>Coupon Management</h1>
                        <hr>
                        <h3>Discount type</h3>
                        <ul>
                            <li>Percentage discount – A percentage discount for selected products only. For example, if the cart contains three (3) t-shirts @ €20 each = €60, a coupon for 10% off applies a discount of €6.</li>
                            <li>Fixed cart discount – A fixed total discount for the entire cart. For example, if the cart contains three (3) t-shirts @ €20 each = €60, a coupon for €10 off gives a discount of €10.</li>
                            <li>Fixed product discount – A fixed total discount for selected products only. Customer receives a set amount of discount per item. For example, three (3) t-shirts @ €20 each with a coupon for €10 off applies a discount of €30.</li>
                            <li>Coupon amount – Fixed value or percentage, depending on discount type you choose. Entered without a currency unit or a percent sign, which are added automatically, e.g., Enter ’10’ for £10 or 10%.</li>
                            <li>Allow free shipping – Removes shipping cost when coupon is used. Requires Free Shipping to be enabled.</li>
                            <li>Coupon expiry date – Date the coupon should expire and can no longer be used. Expiry happens at 12:00 am or 00:00 on the date chosen. If you want a coupon to be valid through Christmas Day but invalid the moment Christmas is over, set the expiration date to YYYY-12-26 as it will expire on YYYY-12-26 00:00.</li>
                        </ul>
                        <hr>
                        <h3>Usage Restriction</h3>
                        <ul>
                            <li>Minimum spend – Allows you to set the minimum subtotal needed to use the coupon. Note: The sum of the cart subtotal + tax is used to determine the minimum amount.</li>
                            <li>Maximum spend – Allows you to set the maximum subtotal allowed when using the coupon.</li>
                            <li>Individual use only – Tick the box if you don’t want this coupon to be used in combination with other coupons.</li>
                            <li>Exclude sale items – Tick the box if you don’t want this coupon to apply to products on sale. Per-cart coupons do not work if a sale item is added afterward.</li>
                            <li>Products – Products that the coupon will be applied to, or that need to be in the cart in order for the fixed or percentage discount to be applied.</li>
                            <li>Exclude products – Products that the coupon will not be applied to, or that cannot be in the cart in order for the “Fixed cart discount” to be applied.</li>
                            <li>Product categories – Product categories that the coupon will be applied to, or that need to be in the cart in order for the fixed or percentage discount to be applied.</li>
                            <li>Exclude categories – Product categories that the coupon will not be applied to, or that cannot be in the cart in order for the “Fixed cart discount” to be applied.</li>
                            <li>Allowed Emails/Email restrictions – Email address or addresses that can use a coupon. Verified against customer’s billing email. WooCommerce 3.4+ also allows you to include a wildcard character (*) to match multiple email addresses, for example, `*@gmail.com` would make any gmail address.</li>
                        </ul>
                        <hr>
                        <h3>Usage Limits</h3>
                        <ul>
                            <li>Usage limit per coupon – How many times a coupon can be used by all customers before being invalid.</li>
                            <li>Limit usage to X items – How many items the coupon can be applied to before being invalid. This field is only displayed if there is one or more products that the coupon can be used with, and is configured under the Usage Restrictions.</li>
                            <li>Usage limit per user – How many times a coupon can be used by each customer before being invalid for that customer.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>