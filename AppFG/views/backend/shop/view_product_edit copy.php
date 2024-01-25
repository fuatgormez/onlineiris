<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Product</h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url(); ?>backend/shop/product/add" class="btn btn-primary btn-sm">Add New</a>
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

            <?php echo form_open_multipart(base_url() . 'backend/shop/product/edit/' . $product['id'], array('class' => 'form-horizontal')); ?>
            <div class="box box-info">
                <div class="box-body">

                    <!-- Nav Tabs Custom -->
                    <div class="nav-tabs-custom">

                        <!-- Nav Nav Tabs -->
                        <ul class="nav nav-tabs">
                            <?php $count = 0;
                            foreach ($all_store as $row) : ?>
                                <li <?php echo $count == 0 ? 'class="active"' : '' ?>><a href="#<?php echo $row['id']; ?>" data-toggle="tab"><img src="<?php echo base_url('public/uploads/store_photos/flag/'); ?><?php echo $row['lang_flag']; ?>" width="50"></a></li>
                            <?php $count = 1;
                            endforeach; ?>
                        </ul>
                        <!-- Nav Nav Tabs End -->

                        <!-- Tab Content -->
                        <div class="tab-content">

                            <?php $count = 0;
                            $editor = 1;
                            foreach ($all_store as $key => $row) : ?>
                                <!-- Tab Pane -->
                                <div class="tab-pane <?php echo $count == 0 ? 'active' : ''; ?>" id="<?php echo $row['id']; ?>">

                                    <!-- Product Category -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Select Category *</label>
                                        <div class="col-sm-4">
                                            <select name="lang[<?php echo $row['id'] ?>][category_id]" class="form-control select2">
                                                <?php foreach ($all_product_category as $row_category) : ?>
                                                    <?php if ($row_category['lang_code'] === $row['lang_code']) : ?>
                                                        <option value="<?php echo $row_category['category_id']; ?>" <?php echo $row_category['product_category_id'] == $product['category_id'] ? 'selected' : ''; ?>><?php echo $row_category['category_name']; ?> (<?php echo $row_category['category_id']; ?>)</option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Product Category End -->

                                    <!-- Product Name -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Product Name *</label>
                                        <div class="col-sm-4">
                                            <input type="text" autocomplete="off" class="form-control" name="lang[<?php echo $row['id'] ?>][product_name]" value="<?php echo @$product_lang[$key]['product_name']; ?>">
                                            <input type="hidden" name="lang[<?php echo $row['id'] ?>][lang_code]" value="<?php echo $row['lang_code']; ?>">
                                        </div>
                                    </div>
                                    <!-- Product Name End -->

                                    <!-- Product SubName -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Product Subname *</label>
                                        <div class="col-sm-4">
                                            <input type="text" autocomplete="off" class="form-control" name="lang[<?php echo $row['id'] ?>][product_subname]" value="<?php echo @$product_lang[$key]['product_subname']; ?>">
                                            <input type="hidden" name="lang[<?php echo $row['id'] ?>][lang_code]" value="<?php echo $row['lang_code']; ?>">
                                        </div>
                                    </div>
                                    <!-- Product SubName End -->

                                    <!-- Short Content -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Short Content </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="lang[<?php echo $row['id'] ?>][short_content]" style="height:100px;"><?php echo @$product_lang[$key]['short_content']; ?></textarea>
                                        </div>
                                    </div>
                                    <!-- Short Content End -->

                                    <!-- Content -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Content *</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="lang[<?php echo $row['id'] ?>][content]" id="<?php echo 'editor' . $editor; ?>"><?php echo @$product_lang[$key]['content']; ?></textarea>
                                        </div>
                                    </div>
                                    <!-- Content End-->

                                    <!-- Product Price -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Product Price</label>
                                        <div class="col-sm-4">
                                            <input type="text" autocomplete="off" class="form-control check-negative" name="lang[<?php echo $row['id'] ?>][product_price]" value="<?php echo @$product_lang[$key]['product_price']; ?>">
                                        </div>
                                    </div>
                                    <!-- Product Price End -->

                                    <!-- Product Old Price -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Product Old Price</label>
                                        <div class="col-sm-4">
                                            <input type="text" autocomplete="off" class="form-control check-negative" name="lang[<?php echo $row['id'] ?>][product_price_old]" value="<?php echo @$product_lang[$key]['product_price_old']; ?>">
                                        </div>
                                    </div>
                                    <!-- Product Old Price End-->

                                    <!-- Product SEO Information -->
                                    <h3 class="seo-info">SEO Information</h3>
                                    <!-- Meta Title -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Meta Title</label>
                                        <div class="col-sm-6">
                                            <input type="text" autocomplete="off" class="form-control" name="lang[<?php echo $row['id'] ?>][meta_title]" value="<?php echo @$product_lang[$key]['meta_title']; ?>">
                                        </div>
                                    </div>
                                    <!-- Meta Title End -->
                                    <!-- Meta Keyword -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Meta Keyword</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="lang[<?php echo $row['id'] ?>][meta_keyword]" style="height:100px;"><?php echo @$product_lang[$key]['meta_keyword']; ?></textarea>
                                        </div>
                                    </div>
                                    <!-- Meta Keyword End -->
                                    <!-- Meta Description -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Meta Description</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="lang[<?php echo $row['id'] ?>][meta_description]" style="height:100px;"><?php echo @$product_lang[$key]['meta_description']; ?></textarea>
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
                        <label for="" class="col-sm-2 control-label">Existing Banner</label>
                        <div class="col-sm-9" style="padding-top:5px">
                            <img src="<?php echo base_url(); ?>public/uploads/product_photos/banner/<?php echo $product['banner']; ?>" alt="" style="width:120px;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Change Banner</label>
                        <div class="col-sm-9" style="padding-top:5px">
                            <input type="file" name="banner">(Only jpg, jpeg, gif and png are allowed)
                        </div>
                    </div>
                    <!-- Product Banner End -->

                    <!-- Product Video -->
                    <h3 class="seo-info">Video</h3>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Existing Video</label>
                        <div class="col-sm-9" style="padding-top:5px">
                            <video width="320" height="240" controls>
                                <source src="<?php echo base_url(); ?>public/uploads/product_photos/video/<?php echo $product['video']; ?>" type="video/mp4">
                            </video>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Change Video</label>
                        <div class="col-sm-9" style="padding-top:5px">
                            <input type="file" name="video">(Only webm,mkv,flv,ogv,ogg,mng,avi,mov,wmv,mp4,mpeg)
                        </div>
                    </div>
                    <!-- Product Video End -->

                    <!-- Product Thumbnail Photo -->
                    <h3 class="seo-info">Thumbnail Photo</h3>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Existing Thumbnail Photo</label>
                        <div class="col-sm-9" style="padding-top:5px">
                            <img src="<?php echo base_url(); ?>public/uploads/product_photos/thumbnail/<?php echo $product['thumbnail']; ?>" alt="" style="width:120px;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Change Featuerd Photo</label>
                        <div class="col-sm-9" style="padding-top:5px">
                            <input type="file" name="photo">(Only jpg, jpeg, gif and png are allowed)
                        </div>
                    </div>
                    <!-- Product Thumbnail Photo End -->

                    <!-- Product Other Photos -->
                    <h3 class="seo-info">Other Photos</h3>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Existing Other Photos</label>
                        <div class="col-sm-6" style="padding-top:5px">
                            <table class="table table-bordered">
                                <?php foreach ($all_photos_by_id as $row_photo) : ?>
                                    <tr>
                                        <td>
                                            <img src="<?php echo base_url(); ?>public/uploads/product_photos/<?php echo $row_photo['photo']; ?>" alt="" style="width:120px;">
                                        </td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>backend/shop/product/single-photo-delete/<?php echo $row_photo['id']; ?>/<?php echo $product['id']; ?>" class="btn btn-danger btn-xs" onClick="return confirm('Are you sure?');">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Add Other Photos</label>
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
                    <!-- Product Other Photos End -->

                    <!-- With Name - Price & eye Queantity -->
                    <h3 class="seo-info">Extras</h3>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">With name</label>
                        <div class="col-sm-2">
                            <select name="with_name" class="form-control select2" style="width:auto;">
                                <option value="no" <?php echo $product['with_name'] === "no" ? 'selected' : ''; ?>>No</option>
                                <option value="yes" <?php echo $product['with_name'] === "yes" ? 'selected' : ''; ?>>Yes</option>
                            </select>
                        </div>

                        <label for="" class="col-sm-2 control-label">With Name Price</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="with_name_price" value="<?php echo $product['with_name_price']; ?>">
                        </div>

                        <label for="" class="col-sm-2 control-label">Eye Quantity</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="eye_quantity" value="<?php echo $product['eye_quantity']; ?>">
                        </div>
                    </div>
                    <!-- With Name - Price & eye Queantity End -->

                    <!-- Status & Row -->
                    <h3 class="seo-info">Product Type, Status & Row</h3>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Product Type</label>
                        <div class="col-sm-2">
                            <select name="product_type" class="form-control select2">
                                <?php foreach ($product_type as $type) : ?>
                                    <?php if ($type['type_value'] == $product['product_type']) : ?>
                                        <option value="<?php echo $type['type_value']; ?>" selected><?php echo $type['type_value']; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $type['type_value']; ?>"><?php echo $type['type_value']; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <label for="" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-2">
                            <select name="product_status" class="form-control select2" style="width:auto;">
                                <option value="Show" <?php echo $product['status'] === 'Show' ? 'selected' : ''; ?>>Show</option>
                                <option value="Hide" <?php echo $product['status'] === 'Hide' ? 'selected' : ''; ?>>Hide</option>
                            </select>
                        </div>

                        <label for="" class="col-sm-2 control-label">Row</label>
                        <div class="col-sm-2">
                            <select name="product_row" class="form-control select2" style="width:auto;">
                                <?php for ($i = 1; $i <= 10; $i++) : ?>
                                    <option value="<?php echo $i; ?>" <?php echo $product['row'] == $i ? 'selected' : ''; ?>><?php echo $i; ?></option>
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
                            <input type="text" class="form-control" name="product_sku" value="<?php echo $product['product_sku']; ?>">
                        </div>
                    </div>
                    <!-- SKU End -->

                    <!-- Product Attribute -->
                    <h3 class="seo-info">Product attribute & Updatable for upgrade</h3>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Product Attribute</label>
                        <div class="col-sm-10">
                            <select name="product_attribute" class="form-control select2">
                                <option value="einzel" <?php echo $product['product_attribute'] === 'einzel' ? 'selected' : ''; ?>>Einzel</option>
                                <option value="paar_versetz" <?php echo $product['product_attribute'] === 'paar_versetz' ? 'selected' : ''; ?>>Paar Versetz</option>
                                <option value="paar_explosion" <?php echo $product['product_attribute'] === 'paar_explosion' ? 'selected' : ''; ?>>Paar Explosion</option>
                                <option value="paar_fusion" <?php echo $product['product_attribute'] === 'paar_fusion' ? 'selected' : ''; ?>>Paar Fusion</option>
                                <option value="familie" <?php echo $product['product_attribute'] === 'familie' ? 'selected' : ''; ?>>Familie</option>
                                <option value="familie_explosion" <?php echo $product['product_attribute'] === 'familie_explosion' ? 'selected' : ''; ?>>Familie Explosion</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Choose an updatable product!</label>
                        <div class="col-sm-10">
                            <select name="1product_updatable[]" class="form-control select2" multiple="multiple">
                                <?php foreach ($all_product as $product_attr) : ?>
                                    <?php if ($product_attr['product_price'] > $product['product_price']) : ?>
                                        <?php foreach ($all_product_category as $product_attr_cat) : ?>
                                            <?php if ($product_attr['category_id'] == $product_attr_cat['category_id'] && $product_attr_cat['store_id'] == 1) : ?>
                                                <?php $product_updatable = explode(',', $product['product_updatable']); ?>
                                                <option value="<?php echo $product_attr['product_id']; ?>" <?php echo in_array($product_attr['product_id'], $product_updatable) ? 'selected' : ''; ?>><?php echo $product_attr_cat['category_name'] . " - " . $product_attr['product_name']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Choose an extras product!</label>
                        <div class="col-sm-10">
                            <select name="1product_extras[]" class="form-control select2" multiple="multiple">
                                <?php foreach ($all_product as $product_attr) : ?>
                                    <?php foreach ($all_product_category as $product_attr_cat) : ?>
                                        <?php if ($product_attr['category_id'] == $product_attr_cat['category_id'] && $product_attr_cat['store_id'] == 1) : ?>
                                            <?php $product_extras = explode(',', $product['product_extras']); ?>
                                            <option value="<?php echo $product_attr['product_id']; ?>" <?php echo in_array($product_attr['product_id'], $product_extras) ? 'selected' : ''; ?>><?php echo $product_attr_cat['category_name'] . " - " . $product_attr['product_name']; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <!-- Product Attribute End -->

                    <h3 class="seo-info">Updatable <label class="pull-right"><input type="checkbox" class="select_all_data"> SELECT ALL</label></h3>
                    <div class="form-group">
                        
                        <?php foreach ($all_product as $allProductKey => $product_attr) : ?>
                            <?php if ($product_attr['product_price'] > $product['product_price']) : ?>
                                <?php foreach ($all_product_category as $product_attr_cat) : ?>
                                    <?php if ($product_attr['category_id'] == $product_attr_cat['category_id'] && $product_attr_cat['store_id'] == 1) : ?>
                                        <?php
                                        if(@$product_attr['id'] = @$product_allow[$allProductKey]['allow_product']){
                                            $checked_product = "checked";
                                            $fuat = @$product_allow[$allProductKey]['allow_product'];

                                            if($product_allow[$allProductKey]['updatable'] = 1){
                                                $checked_updatable = "checked";
                                            } else {
                                                $checked_updatable = "";
                                            }
                                            
                                            if($product_allow[$allProductKey]['extra'] = 1){
                                                $checked_extra = "checked";
                                            } else {
                                                $checked_extra = "";
                                            }
                                        } else {
                                            $checked_product = "";
                                        }

                                        ?>
                                        <div class="col-sm-12">
                                            <div class="checkbox">
                                                <label class="col-sm-5">
                                                    <input type="checkbox" name="allow_product[]" value="<?php echo $product_attr['product_id']; ?>" class="<?php echo $product_attr['product_id']; ?> toogle_select_data" 
                                                    <?php echo $checked_product.' fuat'.$fuat; ?>><?php echo $product_attr_cat['category_name'] . " <br> " . $product_attr['product_name'] ."key:".$allProductKey; ?>
                                                </label>
                                                <label class="col-sm-1 control-label">
                                                    <input type="checkbox" name="product_updatable" class="updatable toogle_select_data" <?php echo $checked_updatable;?>> Update
                                                </label>
                                                <label class="col-sm-1 control-label">
                                                    <input type="checkbox" name="product_extra" class="extras toogle_select_data" <?php echo $checked_extra;?>> Extras
                                                </label>
                                                <label class="col-sm-1 control-label">
                                                    <input type="checkbox" class="all_store toogle_select_data" data-all="<?php echo $product_attr['product_id']; ?>"> All Store
                                                </label>
                                                <label class="col-sm-4 control-label">
                                                    <select name="product_allow_store[]" class="form-control select2 <?php echo $product_attr['product_id']; ?> toogle_select_data" multiple="multiple" id="e1">
                                                        <?php foreach ($product_allow as $key => $row_allow) : $amk = explode(',', $row_allow['allow_store']); ?>
                                                        <?php if($product_attr['product_id'] = $row_allow[$key]['allow_product']):?>
                                                            <option value="<?php echo $all_store[$key]['id'] . " - " . $row_allow['allow_store'] ?>" <?php echo in_array($all_store[$key]['id'], $amk) ? 'selected' : ''; ?>><?php echo $all_store[$key]['store_name']; ?></option>
                                                            <?php endif;?>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </label>
                                            </div>
                                            <div style="margin:25px;border-bottom:1px solid#eee"></div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <!-- Product Attribute End -->

                    <!-- Submit Button -->
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-block btn-success pull-left" name="form1">Update</button>
                        </div>
                    </div>
                    <!-- Submit Button End -->

                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>

</section>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete this item?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>