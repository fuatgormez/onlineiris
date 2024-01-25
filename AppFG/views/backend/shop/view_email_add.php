<section class="content-header">
    <div class="content-header-left">
        <h1>Add Product Category</h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url(); ?>backend/shop/email" class="btn btn-primary btn-sm">View All</a>
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

            <?php echo form_open_multipart(base_url() . 'backend/shop/email/add', array('class' => 'form-horizontal')); ?>
            <div class="box box-info">
                <div class="box-body">

                    <!-- Nav Tabs Custom -->
                    <div class="nav-tabs-custom">
                        <!-- Nav Nav Tabs -->
                        <ul class="nav nav-tabs">
                            <?php $count = 0;
                            foreach ($all_store_value as $row) : ?>
                                <li <?php echo $count == 0 ? 'class="active"' : '' ?>><a href="#<?php echo $row['store_value_id']; ?>" data-toggle="tab"><img src="<?php echo base_url('public/uploads/store_photos/flag/'); ?><?php echo $row['lang_flag']; ?>" width="50"></a></li>
                            <?php $count = 1;
                            endforeach; ?>
                        </ul>
                        <!-- Nav Nav Tabs End -->

                        <!-- Tab Content -->
                        <div class="tab-content">

                            <?php $count = 0;
                            $editor = 1;
                            foreach ($all_store_value as $key => $row) : ?>
                                <!-- Tab Pane -->
                                <div class="tab-pane <?php echo $count == 0 ? 'active' : ''; ?>" id="<?php echo $row['store_value_id']; ?>">

                                    <!-- Subject -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Subject *</label>
                                        <div class="col-sm-6">
                                            <input type="text" autocomplete="off" class="form-control" name="lang[<?php echo $row['store_value_id'] ?>][subject]">
                                            <input type="hidden" name="lang[<?php echo $row['store_value_id'] ?>][lang_code]" value="<?php echo $row['lang_code']; ?>">
                                        </div>
                                    </div>
                                    <!-- Subject End -->

                                    <!-- Message -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Message</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control editor" name="lang[<?php echo $row['store_value_id'] ?>][message]" style="height:140px;"></textarea>
                                        </div>
                                    </div>
                                    <!-- Message End -->
                                    
                                    <!-- Mollie Welcome Text -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Mollie Welcome Text</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control editor" name="lang[<?php echo $row['store_value_id'] ?>][mollie]" style="height:140px;"></textarea>
                                        </div>
                                    </div>
                                    <!-- Mollie Welcome text End -->
                                    
                                    <!-- Billing Welcome Text -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Billing Welcome Text</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control editor" name="lang[<?php echo $row['store_value_id'] ?>][billing]" style="height:140px;"></textarea>
                                        </div>
                                    </div>
                                    <!-- Billing Welcome text End -->

                                    <!-- Email Attachment -->
                                    <h3 class="seo-info">Attachment</h3>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Attachment</label>
                                        <div class="col-sm-9" style="padding-top:5px">
                                            <input type="file" name="lang[<?php echo $row['store_value_id'] ?>][attachment]">(Only jpg, jpeg, gif and png are allowed 600x400px)
                                        </div>
                                    </div>
                                    <!-- Email Attachment End -->

                                </div>
                                <!-- Tab Pane End -->
                            <?php $count = 1;
                                $editor++;
                            endforeach; ?>

                        </div>
                        <!-- Tab Content End -->
                    </div>
                    <!-- Nav Tabs Custom End -->




                    <!-- STATUS - TYPE & STEP -->
                    <h3 class="seo-info">STATUS - TYPE & STEP</h3>
                    <div class="form-group">
                        <label for="" class="col-sm-1 control-label">Status</label>
                        <div class="col-sm-1">
                            <select name="status" class="form-control select2" style="width:auto;">
                                <option value="Active" selected>Active</option>
                                <option value="Passive">Passive</option>
                            </select>
                        </div>

                        <label for="" class="col-sm-2 control-label">Type</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="type">
                        </div>
                        
                        <label for="" class="col-sm-2 control-label">Step</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="step">
                        </div>
                    </div>
                    <!-- STATUS - TYPE & STEP End -->

                    <!-- Submit Button -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label"></label>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-success pull-left" name="form1">Hinzufügen</button>
                        </div>
                    </div>
                    <!-- Submit Button End -->

                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>

</section>