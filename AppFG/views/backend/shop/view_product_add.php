<?php
if (!$this->session->userdata('id')) {
    redirect(base_url() . 'backend/admin/login');
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Product</h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url(); ?>backend/shop/product" class="btn btn-primary btn-sm">View All</a>
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

            <?php echo form_open_multipart(base_url('backend/shop/product/add'), array('class' => 'form-horizontal')); ?>
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

                                    <!-- Product Category -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Select Category *</label>
                                        <div class="col-sm-4">
                                            <select name="lang[<?php echo $row['store_value_id'] ?>][category_id]" class="form-control select2">
                                                <?php foreach ($all_product_category as $row_category) : ?>
                                                    <?php if ($row_category['land_id'] == $row['store_value_id']) : ?>
                                                        <option value="<?php echo $row_category['category_id']; ?>"><?php echo $row_category['category_name']; ?>
                                                            (<?php echo $row_category['category_id']; ?>)
                                                        </option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Product Category End -->

                                    <!-- Product Name -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Product Name *</label>
                                        <div class="col-sm-6">
                                            <input type="text" autocomplete="off" class="form-control" name="lang[<?php echo $row['store_value_id'] ?>][product_name]" value="<?php echo set_value('product_name'); ?>">
                                            <input type="hidden" name="lang[<?php echo $row['store_value_id'] ?>][lang_code]" value="<?php echo $row['lang_code']; ?>">
                                        </div>
                                    </div>
                                    <!-- Product Name End -->

                                    <!-- Product SubName -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Product Subname *</label>
                                        <div class="col-sm-6">
                                            <input type="text" autocomplete="off" class="form-control" name="lang[<?php echo $row['store_value_id'] ?>][product_subname]" value="<?php echo set_value('product_subname'); ?>">
                                            <input type="hidden" name="lang[<?php echo $row['store_value_id'] ?>][lang_code]" value="<?php echo $row['lang_code']; ?>">
                                        </div>
                                    </div>
                                    <!-- Product SubName End -->

                                    <!-- Short Content -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Short Content</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="lang[<?php echo $row['store_value_id'] ?>][short_content]" style="height:100px;"><?php if (isset($_POST['short_content'])) {
                                                                                                                                                                        echo $_POST['short_content'];
                                                                                                                                                                    } ?></textarea>
                                        </div>
                                    </div>
                                    <!-- Short Content End -->

                                    <!-- Content -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Content *</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="lang[<?php echo $row['store_value_id'] ?>][content]" id="<?php echo 'editor' . $editor; ?>">
                                                <?php if (isset($_POST['content'])) {
                                                    echo $_POST['content'];
                                                } ?>
                                            </textarea>
                                        </div>
                                    </div>
                                    <!-- Content End-->

                                    <!-- Product Price -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Product Price</label>
                                        <div class="col-sm-4">
                                            <input type="text" autocomplete="off" class="form-control check-negative" name="lang[<?php echo $row['store_value_id'] ?>][product_price]" value="<?php if (isset($_POST['product_price'])) {
                                                                                                                                                                                        echo $_POST['product_price'];
                                                                                                                                                                                    } ?>">
                                        </div>
                                    </div>
                                    <!-- Product Price End -->

                                    <!-- Product Old Price -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Product Old Price</label>
                                        <div class="col-sm-4">
                                            <input type="text" autocomplete="off" class="form-control check-negative" name="lang[<?php echo $row['store_value_id'] ?>][product_price_old]" value="<?php if (isset($_POST['product_price_old'])) {
                                                                                                                                                                                            echo $_POST['product_price_old'];
                                                                                                                                                                                        } ?>">
                                        </div>
                                    </div>
                                    <!-- Product Old Price End-->

                                    <!-- Product SEO Information -->
                                    <h3 class="seo-info">SEO Information</h3>
                                    <!-- Meta Title -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Meta Title</label>
                                        <div class="col-sm-6">
                                            <input type="text" autocomplete="off" class="form-control" name="lang[<?php echo $row['store_value_id'] ?>][meta_title]" value="<?php if (isset($_POST['meta_title'])) {
                                                                                                                                                                    echo $_POST['meta_title'];
                                                                                                                                                                } ?>">
                                        </div>
                                    </div>
                                    <!-- Meta Title End -->
                                    <!-- Meta Keyword -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Meta Keyword</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="lang[<?php echo $row['store_value_id'] ?>][meta_keyword]" style="height:100px;"><?php if (isset($_POST['meta_keyword'])) {
                                                                                                                                                            echo $_POST['meta_keyword'];
                                                                                                                                                        } ?></textarea>
                                        </div>
                                    </div>
                                    <!-- Meta Keyword End -->
                                    <!-- Meta Description -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Meta Description</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="lang[<?php echo $row['store_value_id'] ?>][meta_description]" style="height:100px;"><?php if (isset($_POST['meta_description'])) {
                                                                                                                                                                echo $_POST['meta_description'];
                                                                                                                                                            } ?></textarea>
                                        </div>
                                    </div>
                                    <!-- Meta Description End -->
                                    <!-- Product SEO Information End -->
                                </div>
                                <!-- Tab Pane End -->
                            <?php $count = 1;
                                $editor++;
                            endforeach; ?>

                        </div>
                        <!-- Tab Content End -->
                    </div>
                    <!-- Nav Tabs Custom End -->

                    <!-- Product Banner -->
                    <h3 class="seo-info">Banner</h3>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Banner</label>
                        <div class="col-sm-9" style="padding-top:5px">
                            <input type="file" name="banner">(Only jpg, jpeg, gif and png are allowed)
                        </div>
                    </div>
                    <!-- Product Banner End -->
                    <!-- Product Video -->
                    <h3 class="seo-info">Video</h3>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Video</label>
                        <div class="col-sm-9" style="padding-top:5px">
                            <input type="file" name="video">(Only webm,mkv,flv,ogv,ogg,mng,avi,mov,wmv,mp4,mpeg)
                        </div>
                    </div>
                    <!-- Product Video End -->

                    <!-- Product Thumbnail Photo -->
                    <h3 class="seo-info">Thumbnail Photo</h3>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Thumbnail Photo *</label>
                        <div class="col-sm-9" style="padding-top:5px">
                            <input type="file" name="photo" required>(Only jpg, jpeg, gif and png are allowed)
                        </div>
                    </div>
                    <!-- Product Thumbnail Photo End -->

                    <!-- Product Other Photos -->
                    <h3 class="seo-info">Other Photos</h3>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Other Photos</label>
                        <div class="col-sm-6" style="padding-top:5px">
                            <table id="PhotosTable" style="width:100%;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="upload-btn">
                                                <input type="file" name="photos[]" multiple>
                                            </div>
                                        </td>
                                        <td style="width:28px;"><a href="javascript:void()" class="Delete btn btn-danger btn-xs">X</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-2" style="padding-top:5px">
                            <input type="button" id="btnAddNew" value="Add Item" style="margin-bottom:10px;border:0;color: #fff;font-size: 14px;border-radius:3px;" class="btn btn-warning btn-xs">
                        </div>
                    </div>
                    <!-- Product Other Photos End-->

                    <!-- With Name - Price & eye Queantity -->
                    <h3 class="seo-info">Extras</h3>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">With Name</label>
                        <div class="col-sm-1">
                            <select name="with_name" class="form-control select2" style="width:auto;">
                                <option value="no" selected>No</option>
                                <option value="yes">Yes</option>
                            </select>
                        </div>

                        <label for="" class="col-sm-1 control-label">With Name Price</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control" name="with_name_price" placeholder="0.00">
                        </div>

                        <label for="" class="col-sm-1 control-label">Eye Quantity</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control" name="eye_quantity" placeholder="0">
                        </div>
                        
                        <label for="" class="col-sm-2 control-label">Name Allow (For Update & Extra)</label>
                        <div class="col-sm-1">
                        <select name="with_name_allow" class="form-control select2" style="width:auto;">
                                <option value="No" selected>No</option>
                                <option value="Yes">Yes</option>
                            </select>
                        </div>
                    </div>
                    <!-- With Name - Price & eye Queantity End -->

                    <!-- Product Type, Status & Row -->
                    <h3 class="seo-info">Product Type, Status & Row</h3>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Product Type</label>
                        <div class="col-sm-2">
                            <select name="product_type" class="form-control select2">
                                <?php foreach ($product_type as $type) : ?>
                                    <option value="<?php echo $type['type_value']; ?>"><?php echo $type['type_value']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <label for="" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-2">
                            <select name="product_status" class="form-control select2" style="width:auto;">
                                <option value="Show" selected>Show</option>
                                <option value="Hide">Hide</option>
                            </select>
                        </div>

                        <label for="" class="col-sm-2 control-label">Row</label>
                        <div class="col-sm-2">
                            <select name="product_row" class="form-control select2" style="width:auto;">
                                <?php for ($i = 1; $i <= 50; $i++) : ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <!-- Status & Row End -->

                    <!-- SKU -->
                    <h3 class="seo-info">SKU</h3>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Product SKU</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="product_sku">
                        </div>
                    </div>
                    <!-- SKU End -->

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