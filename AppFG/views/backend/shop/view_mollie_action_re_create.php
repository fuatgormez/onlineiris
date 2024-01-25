<section class="content-header">
    <div class="content-header-left">
        <h1>Mollie Re Create Order</h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url('backend/shop/mollie'); ?>" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">
    <div class="process_box">
        <!-- box box-info -->
        <div class="box box-info">
            <!-- box-body -->
            <div class="box-body">
                <!-- title row -->
                <div class="row">
                    <div class="col-xs-12">
                    <?php echo form_open_multipart(base_url('backend/shop/mollie/re_create'), array('class' => 'form-horizontal')); ?>
                        <div class="box box-info">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="tr_id" class="col-sm-2 control-label">Code <span>*</span></label>
                                    <div class="col-sm-3">
                                        <input type="text" name="tr_id" id="tr_id" class="form-control" required="">
                                    </div>
                                    <div class="col-sm-2"><button class="btn cursor-pointer" data-type="add"> Generate coupon code </button></div>
                                </div>
                                
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
                    <!-- /.col -->
                </div>
                <!-- info row -->
            </div>
            <!-- box-body end -->
        </div>
        <!-- box box-info end -->
    </div>
    <!-- process end -->
</section>