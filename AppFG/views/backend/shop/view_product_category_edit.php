<?php
if (!$this->session->userdata('id')) {
    redirect(base_url() . 'backend/admin/login');
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Product Category</h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url(); ?>backend/shop/product_category" class="btn btn-primary btn-sm">View All</a>
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

            <?php echo form_open_multipart(base_url() . 'backend/shop/product_category/edit/' . $product_category['category_id'], array('class' => 'form-horizontal')); ?>
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

                                    <!-- Product Category Name -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Category Name *</label>
                                        <div class="col-sm-6">
                                            <input type="text" autocomplete="off" class="form-control" name="lang[<?php echo $row['store_value_id'] ?>][category_name]" value="<?php echo @$product_category_lang[$key]['category_name']; ?>">
                                            <input type="hidden" name="lang[<?php echo $row['store_value_id'] ?>][lang_code]" value="<?php echo $row['lang_code']; ?>">
                                        </div>
                                    </div>
                                    <!-- Product Category Name End -->

                                    <!-- Product Category SubName -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Category Subname</label>
                                        <div class="col-sm-6">
                                            <input type="text" autocomplete="off" class="form-control" name="lang[<?php echo $row['store_value_id'] ?>][category_subname]" value="<?php echo @$product_category_lang[$key]['category_subname']; ?>">
                                        </div>
                                    </div>
                                    <!-- Product Category SubName End -->

                                    <!-- Product Category Short Description -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Short Description</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="lang[<?php echo $row['store_value_id'] ?>][short_description]" style="height:140px;"><?php echo @$product_category_lang[$key]['short_description']; ?></textarea>
                                        </div>
                                    </div>
                                    <!-- Product Category Short Description End -->

                                    <!-- Product Category Description -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Description</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control editor" name="lang[<?php echo $row['store_value_id'] ?>][description]"><?php echo @$product_category_lang[$key]['description']; ?></textarea>
                                        </div>
                                    </div>
                                    <!-- Product Category Description End -->

                                    <!-- Product SEO Information -->
                                    <h3 class="seo-info">SEO Information</h3>
                                    <!-- Meta Title -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Meta Title</label>
                                        <div class="col-sm-6">
                                            <input type="text" autocomplete="off" class="form-control" name="lang[<?php echo $row['store_value_id'] ?>][meta_title]" value="<?php echo @$product_category_lang[$key]['meta_title']; ?>">
                                        </div>
                                    </div>
                                    <!-- Meta Title End -->
                                    <!-- Meta Keyword -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Meta Keyword</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="lang[<?php echo $row['store_value_id'] ?>][meta_keyword]" style="height:80px;"><?php echo @$product_category_lang[$key]['meta_keyword']; ?></textarea>
                                        </div>
                                    </div>
                                    <!-- Meta Keyword End -->
                                    <!-- Meta Description -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Meta Description</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="lang[<?php echo $row['store_value_id'] ?>][meta_description]" style="height:80px;"><?php echo @$product_category_lang[$key]['meta_description']; ?></textarea>
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
                    <h3 class="seo-info">Banner for kiosk</h3>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Existing Banner</label>
                        <div class="col-sm-9" style="padding-top:5px">
                            <img src="<?php echo base_url(); ?>public/uploads/product_category_photos/banner/<?php echo $product_category['category_banner']; ?>?v=<?php echo time(); ?>" alt="" style="width:120px;">
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
                                <source src="<?php echo base_url(); ?>public/uploads/product_category_photos/video/<?php echo $product_category['category_video']; ?>" type="video/mp4">
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
                            <img src="<?php echo base_url(); ?>public/uploads/product_category_photos/thumbnail/<?php echo $product_category['thumbnail_photo']; ?>?v=<?php echo time(); ?>" alt="" style="width:120px;">
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
                                            <img src="<?php echo base_url(); ?>public/uploads/product_category_photos/<?php echo $row_photo['photo']; ?>?v=<?php echo time(); ?>" alt="" style="width:120px;">
                                        </td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>backend/shop/product_category/single-photo-delete/<?php echo $row_photo['id']; ?>/<?php echo $product_category['category_id']; ?>" class="btn btn-danger btn-xs" onClick="return confirm('Are you sure?');">Delete</a>
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

                    <!-- Status & Row -->
                    <h3 class="seo-info">Status & Row</h3>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-2">
                            <select name="product_category_status" class="form-control select2" style="width:auto;">
                                <option value="Show" <?php echo $product_category['status'] === 'Show' ? 'selected' : ''; ?>>Show</option>
                                <option value="Hide" <?php echo $product_category['status'] === 'Hide' ? 'selected' : ''; ?>>Hide</option>
                            </select>
                        </div>

                        <label for="" class="col-sm-2 control-label">Row</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="product_category_row" value="<?php echo $product_category['row']; ?>">
                        </div>
                    </div>
                    <!-- Status & Row End -->

                    <!-- SKU -->
                    <h3 class="seo-info">SKU</h3>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Product SKU</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="category_sku" value="<?php echo $product_category['category_sku']; ?>">
                        </div>
                    </div>
                    <!-- SKU End -->

                    <!-- Block The Sale -->
                    <h3 class="seo-info">BU KATEGORIDE URUN SATISINI ENGELLEMEK ISTIYORSANIZ BU KISMI KULLANIN KATEGORININ STATUS'UNU HIDE YAPMAYIN KIOSK TA O URUN CALISMAZ (MUSTERI FOTOGRAF CEKEMEZ)!!!</h3>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Should this category be sold?</label>
                        <div class="col-sm-2">
                            <select name="block_the_sale" class="form-control select2">
                                <option value="Yes" <?php echo $product_category['block_the_sale'] === 'Yes' ? 'selected' : ''; ?>>Yes</option>
                                <option value="No" <?php echo $product_category['block_the_sale'] === 'No' ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                    </div>
                    <!-- Block The Sale End -->

                    <!-- Submit Button -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label"></label>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-success pull-left" name="form1">Aktualisieren</button>
                        </div>
                    </div>
                    <!-- Submit Button End -->

                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>

</section>