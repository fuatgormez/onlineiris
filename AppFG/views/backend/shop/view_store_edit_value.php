<?php
if(!$this->session->userdata('id')) {
    redirect(base_url().'backend/admin/login');
}
?>
<section class="content-header">
	<div class="content-header-left">
		<h1>Edit Store Value</h1>
	</div>
	<div class="content-header-right">
		<a href="<?php echo base_url(); ?>backend/shop/store/add_value" class="btn btn-primary btn-sm">Add New Value</a>
		<a href="<?php echo base_url(); ?>backend/shop/store/value" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>

<section class="content">

	<div class="row">
		<div class="col-md-12">

			<?php
			if($this->session->flashdata('error')) {
				?>
				<div class="callout callout-danger">
					<p><?php echo $this->session->flashdata('error'); ?></p>
				</div>
				<?php
			}
			if($this->session->flashdata('success')) {
				?>
				<div class="callout callout-success">
					<p><?php echo $this->session->flashdata('success'); ?></p>
				</div>
				<?php
			}
			?>

			<?php echo form_open_multipart(base_url().'backend/shop/store/edit_value/'.$store_value['store_value_id'],array('class' => 'form-horizontal')); ?>
				<div class="box box-info">
					<div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Land Name <span>*</span></label>
                            <div class="col-sm-6">
                                <input type="text" autocomplete="off" class="form-control" name="land_name" value="<?php echo $store_value['land_name']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Currency Code <span>*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="currency_code" value="<?php echo $store_value['currency_code']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Currency Icon <span>*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="currency_icon" value="<?php echo $store_value['currency_icon']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Language Code <span>*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="lang_code" value="<?php echo $store_value['lang_code']; ?>">
                            </div>
                        </div>

                        <!-- Store Flag -->
                        <h3 class="seo-info">Store Flag</h3>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Existing Flag</label>
                            <div class="col-sm-9" style="padding-top:5px">
                                <?php if(!empty($store_value['lang_flag'])):?><?php endif;?>
                                <img src="<?php echo base_url('public/uploads/store_photos/flag/'); ?><?php echo $store_value['lang_flag'] !='' ? $store_value['lang_flag'] : 'coming_soon.jpg'; ?>" style="width:50px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Flag </label>
                            <div class="col-sm-6" style="padding-top:5px">
                                <input type="file" name="lang_flag">(Only jpg, jpeg, gif and png are allowed)
                            </div>
                        </div>
                        <!-- Store Flag End -->

                        <!-- Status & Row -->
                        <h3 class="seo-info">Status & Row</h3>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-2">
                                <select name="store_value_status" class="form-control select2" style="width:auto;">
                                    <option value="Show" <?php echo $store_value['status'] === 'Show' ? 'selected' : '';?>>Show</option>
                                    <option value="Hide" <?php echo $store_value['status'] === 'Hide' ? 'selected' : '';?>>Hide</option>
                                </select>
                            </div>

                            <label for="" class="col-sm-2 control-label">Row</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="store_value_row">
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