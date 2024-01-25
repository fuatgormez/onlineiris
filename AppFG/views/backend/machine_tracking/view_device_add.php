<section class="content-header">
	<div class="content-header-left">
		<h1>Add Device</h1>
	</div>
	<div class="content-header-right">
		<a href="<?php echo base_url(); ?>backend/machine_tracking/device" class="btn btn-primary btn-sm">View All</a>
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

			<?php echo form_open(base_url() . 'backend/machine_tracking/device/add', array('class' => 'form-horizontal')); ?>
			<div class="box box-info">
				<div class="box-body">
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Kiosk ID *</label>
						<div class="col-sm-6">
							<input type="text" autocomplete="off" class="form-control" name="kiosk_id">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Latitude</label>
						<div class="col-sm-2">
							<input type="text" autocomplete="off" class="form-control" name="latitude">
						</div>
						<label for="" class="col-sm-2 control-label">Longitude</label>
						<div class="col-sm-2">
							<input type="text" autocomplete="off" class="form-control" name="longitude">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Location Name</label>
						<div class="col-sm-6">
							<input type="text" autocomplete="off" class="form-control" name="location_name">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Camera id</label>
						<div class="col-sm-6">
							<input type="text" autocomplete="off" class="form-control" name="camera_id">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Simcard no</label>
						<div class="col-sm-6">
							<input type="text" autocomplete="off" class="form-control" name="sim_card_no">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Imei no</label>
						<div class="col-sm-6">
							<input type="text" autocomplete="off" class="form-control" name="imei_no">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Objective type</label>
						<div class="col-sm-6">
							<input type="text" autocomplete="off" class="form-control" name="objective_type">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Contact</label>
						<div class="col-sm-6">
							<input type="text" autocomplete="off" class="form-control" name="contact">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Email</label>
						<div class="col-sm-6">
							<input type="text" autocomplete="off" class="form-control" name="email">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Phone</label>
						<div class="col-sm-6">
							<input type="text" autocomplete="off" class="form-control" name="phone">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Store</label>
						<div class="col-sm-6">
						<select class="form-control" name="store_id">
							<?php foreach($all_store as $row_store):?>
								<option value="<?php echo $row_store['id'];?>"><?php echo $row_store['store_name'];?></option>
							<?php endforeach;?>
						</select>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Startrunning</label>
						<div class="col-sm-6">
							<input type="text" autocomplete="off" class="form-control" name="start_running">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Stoprunning</label>
						<div class="col-sm-6">
							<input type="text" autocomplete="off" class="form-control" name="stop_running">
						</div>
					</div>
					<div class="form-group">
                        <label for="" class="col-sm-2 control-label"></label>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-block btn-success pull-left" name="form1">Add New Device</button>
                        </div>
                    </div>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</section>