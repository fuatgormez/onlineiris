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
		<a href="<?php echo base_url(); ?>backend/shop/product/product_add_type" class="btn btn-primary btn-sm">Add New Product Type</a>
		<a href="<?php echo base_url(); ?>backend/shop/product/product_type" class="btn btn-primary btn-sm">View All</a>
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

			<?php echo form_open_multipart(base_url('backend/shop/product/product_edit_type/').$product_type['type_id'],array('class' => 'form-horizontal')); ?>
				<div class="box box-info">
					<div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Land Name <span>*</span></label>
                            <div class="col-sm-6">
                                <input type="text" autocomplete="off" class="form-control" name="product_type" value="<?php echo $product_type['type_value']; ?>">
                            </div>
                        </div>

                        <!-- Row -->
                        <h3 class="seo-info">Row</h3>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Row</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="row" value="<?php echo $product_type['row'];?>">
                            </div>
                        </div>
                        <!-- Row End -->

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