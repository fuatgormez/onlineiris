<section class="content-header">
	<div class="content-header-left">
		<h1>Database</h1>
	</div>
	<div class="content-header-right">
		<a href="<?php echo base_url(); ?>admin" class="btn btn-primary btn-sm">Dashboard</a>
	</div>
</section>

<section class="content">

	<div class="row">
		<div class="col-md-12">



			<?php echo form_open_multipart(base_url().'backend/admin/database/dbimport',array('class' => 'form-horizontal'));?>
				<div class="box box-info">
					<div class="box-body">						
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Select File *</label>
							<div class="col-sm-6">
								<input type="file" class="form-control" name="db_import">
							</div>
						</div>

						<div class="form-group">
							<label for="" class="col-sm-2 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">Import</button>
							</div>
						</div>
					</div>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>

</section>