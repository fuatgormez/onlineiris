<section class="content-header">
    <div class="content-header-left">
        <h1>View Statistic</h1>
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
            <div class="box box-info">
                <div class="box-body table-responsive">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Select Store</label>
                            <select class="form-control select2 store_id select2-hidden-accessible" data-placeholder="Select a store" tabindex="-1" aria-hidden="true">
                                <?php foreach ($stores as $store) : ?>
                                    <option value="<?php echo $store['id']; ?>"><?php echo $store['store_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6" style="margin-top:30px">
                            <label>Start Date</label>
                            <input type="date" name="start_date" class="form-control start_date" value="<?php echo date('Y-m-d');?>"/>
                        </div>
                        <div class="col-md-6" style="margin-top:30px">
                            <label>End Date</label>
                            <input type="date" name="end_date" class="form-control end_date" value="<?php echo date('Y-m-d') ;?>"/>
                        </div>
                    </div>
                </div>


                <!-- row -->
                <div class="row" style="margin-top:30px">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box bg-aqua">
                            <span class="info-box-icon">€</span>
                            <div class="info-box-content">
                                <span class="info-box-text">Web Total</span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 50%"></div>
                                </div>
                                <span class="info-box-number web_total">0.00</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box bg-green">
                            <span class="info-box-icon">€</span>
                            <div class="info-box-content">
                                <span class="info-box-text">Web Total Update</span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 50%"></div>
                                </div>
                                <span class="info-box-number web_total_update">0.00</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box bg-yellow">
                            <span class="info-box-icon">€</span>
                            <div class="info-box-content">
                                <span class="info-box-text">Kiosk Total</span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 50%"></div>
                                </div>
                                <span class="info-box-number kiosk_total">0.00</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box bg-red">
                            <span class="info-box-icon">€</span>
                            <div class="info-box-content">
                                <span class="info-box-text">Kiosk Total Update</span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 50%"></div>
                                </div>
                                <span class="info-box-number kiosk_total_update">0.00</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /. box-info -->
        </div>
    </div>
</section>