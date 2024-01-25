<section class="content-header">
    <div class="content-header-left">
        <h1>Add Groupon Code</h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url(); ?>backend/shop/groupon/add" class="btn btn-primary btn-sm">Add Groupon Code</a>
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

            <?php echo form_open(base_url() . 'backend/shop/groupon/add', array('class' => 'form-horizontal', 'name' => 'form_groupon_add')); ?>
            <div class="box box-info">
                <div class="box-body">
                    <div class="form-group" id="amount_">
                        <label for="amount" class="col-sm-2 control-label">Amount <span>*</span></label>
                        <div class="col-sm-2">
                            <input type="text" name="amount" id="amount" class="form-control" placeholder="10.99" required>
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
                    <div class="box box-info">
                        <div class="box-body table-responsive">
                            <input type="file" name="groupon" class="bg-red" style="display:block;width:100%;padding:10px" />
                            <p></p>
                            <button type="submit" name="form_groupon_add" class="btn btn-block btn-warning">Add Groupon Code from file (csv) And Data Save</button>
                        </div>
                    </div>
                    <!-- Submit Button End -->

                </div>
            </div>
            <?php echo form_close(); ?>

        </div>
    </div>
</section>