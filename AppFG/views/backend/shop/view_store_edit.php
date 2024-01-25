<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Store</h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url(); ?>backend/shop/store" class="btn btn-primary btn-sm">View All</a>
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

            <?php echo form_open_multipart(base_url() . 'backend/shop/store/edit/' . $store['id'], array('class' => 'form-horizontal')); ?>
            <div class="box box-info">
                <div class="box-body">
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Land Name <span>*</span></label>
                        <div class="col-sm-6">
                            <select name="land_name" class="form-control">
                                <?php foreach ($store_value as $row) : ?>
                                    <option value="<?php echo $row['store_value_id'] . "@" . $row['land_name']; ?>" <?php echo $store['land_name'] === $row['land_name'] ? 'selected' : '' ?>><?php echo $row['land_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Store Name <span>*</span></label>
                        <div class="col-sm-6">
                            <input type="text" autocomplete="off" class="form-control" name="store_name" value="<?php echo $store['store_name']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Currency Code <span>*</span></label>
                        <div class="col-sm-2">
                            <select name="currency_code" class="form-control">
                                <?php foreach ($store_value as $row) : ?>
                                    <option value="<?php echo $row['currency_code']; ?>" <?php echo $store['currency_code'] === $row['currency_code'] ? 'selected' : '' ?>><?php echo $row['currency_code']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Currency Icon <span>*</span></label>
                        <div class="col-sm-2">
                            <select name="currency_icon" class="form-control">
                                <?php foreach ($store_value as $row) : ?>
                                    <option value="<?php echo $row['currency_icon']; ?>" <?php echo $store['currency_icon'] === $row['currency_icon'] ? 'selected' : '' ?>><?php echo $row['currency_icon']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Tax % <span>*</span></label>
                        <div class="col-sm-2">
                            <input type="number" name="tax" class="form-control" placeholder="19" value="<?php echo $store['tax']; ?>" min="0" max="100">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Language Code <span>*</span></label>
                        <div class="col-sm-2">
                            <select name="lang_code" class="form-control">
                                <?php foreach ($store_value as $row) : ?>
                                    <option value="<?php echo $row['lang_code']; ?>" <?php echo $store['lang_code'] === $row['lang_code'] ? 'selected' : '' ?>><?php echo $row['lang_code']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Language Flag <span>*</span></label>
                        <div class="col-sm-2">
                            <select name="lang_flag" class="form-control">
                                <?php foreach ($store_value as $row) : ?>
                                    <option value="<?php echo $row['lang_flag']; ?>" <?php echo $store['lang_flag'] === $row['lang_flag'] ? 'selected' : '' ?>><?php echo $row['lang_flag']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Short Content</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="short_content" style="height:100px;"><?php echo $store['short_content']; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Content</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="content" id="editor1"><?php echo $store['content']; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Store Address</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="store_address" style="height:100px;"><?php echo $store['store_address']; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Store Email</label>
                        <div class="col-sm-6">
                            <input type="text" autocomplete="off" class="form-control" name="store_email" value="<?php echo $store['store_email']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Store Phone</label>
                        <div class="col-sm-6">
                            <input type="text" autocomplete="off" class="form-control" name="store_phone" value="<?php echo $store['store_phone']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Existing Photo</label>
                        <div class="col-sm-9" style="padding-top:5px">
                            <?php if (!empty($store['photo'])) : ?><?php endif; ?>
                            <img src="<?php echo base_url(); ?>public/uploads/store_photos/<?php echo $store['photo'] != '' ? $store['photo'] : 'coming_soon.jpg'; ?>" style="width:180px;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Photo </label>
                        <div class="col-sm-6" style="padding-top:5px">
                            <input type="file" name="photo">(Only jpg, jpeg, gif and png are allowed)
                        </div>
                    </div>

                    <!-- Status & Row -->
                    <h3 class="seo-info">Status & Row</h3>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-2">
                            <select name="store_status" class="form-control select2" style="width:auto;">
                                <option value="Show" <?php echo $store['status'] === 'Show' ? 'selected' : ''; ?>>Show</option>
                                <option value="Hide" <?php echo $store['status'] === 'Hide' ? 'selected' : ''; ?>>Hide</option>
                            </select>
                        </div>

                        <label for="" class="col-sm-2 control-label">Row</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="store_row" value="<?php echo $store['row']; ?>">
                        </div>
                    </div>
                    <!-- Status & Row End -->

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label"></label>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-success pull-left" name="form1">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>

</section>