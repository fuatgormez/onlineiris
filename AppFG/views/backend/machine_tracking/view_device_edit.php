<section class="content-header">
	<div class="content-header-left">
		<h1>Edit Device</h1>
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

			<?php echo form_open(base_url() . 'backend/machine_tracking/device/edit/'.$device['id'], array('class' => 'form-horizontal')); ?>
			<div class="box box-info">
				<div class="box-body">
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Kiosk ID *</label>
						<div class="col-sm-6">
							<input type="text" autocomplete="off" class="form-control" name="kiosk_id" value="<?php echo $device['kiosk_id'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Latitude</label>
						<div class="col-sm-2">
							<input type="text" autocomplete="off" class="form-control" name="latitude" value="<?php echo $device['latitude'];?>">
						</div>
						<label for="" class="col-sm-2 control-label">Longitude</label>
						<div class="col-sm-2">
							<input type="text" autocomplete="off" class="form-control" name="longitude" value="<?php echo $device['longitude'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Location Name</label>
						<div class="col-sm-6">
							<input type="text" autocomplete="off" class="form-control" name="location_name" value="<?php echo $device['location_name'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Camera id</label>
						<div class="col-sm-6">
							<input type="text" autocomplete="off" class="form-control" name="camera_id" value="<?php echo $device['camera_id'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Simcard no</label>
						<div class="col-sm-6">
							<input type="text" autocomplete="off" class="form-control" name="sim_card_no" value="<?php echo $device['sim_card_no'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Imei no</label>
						<div class="col-sm-6">
							<input type="text" autocomplete="off" class="form-control" name="imei_no" value="<?php echo $device['imei_no'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Objective type</label>
						<div class="col-sm-6">
							<input type="text" autocomplete="off" class="form-control" name="objective_type" value="<?php echo $device['objective_type'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Contact</label>
						<div class="col-sm-6">
							<input type="text" autocomplete="off" class="form-control" name="contact" value="<?php echo $device['contact'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Email</label>
						<div class="col-sm-6">
							<input type="text" autocomplete="off" class="form-control" name="email" value="<?php echo $device['email'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Phone</label>
						<div class="col-sm-6">
							<input type="text" autocomplete="off" class="form-control" name="phone" value="<?php echo $device['phone'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Store</label>
						<div class="col-sm-6">
						<select class="form-control" name="store_id">
							<?php foreach($all_store as $row_store):?>
								<option value="<?php echo $row_store['id'];?>" <?php echo $row_store['id'] == $device['store_id'] ? 'selected' : '';?>><?php echo $row_store['store_name'];?></option>
							<?php endforeach;?>
						</select>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Start Time</label>
						<div class="col-sm-6">
							<input type="text" autocomplete="off" class="form-control" name="start_time" value="<?php echo $device['start_time'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Finish time</label>
						<div class="col-sm-6">
							<input type="text" autocomplete="off" class="form-control" name="finish_time" value="<?php echo $device['finish_time'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Software Update</label>
						<div class="col-sm-6">
								<select class="form-control" name="software_update">
									<option value="On" <?php echo $device['software_update'] === 'On' ? "selected" : '';?>>On</option>
									<option value="Off" <?php echo $device['software_update'] === 'Off' ? "selected" : '';?>>Off</option>
								</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">x_status: <?php echo $device['x_status'];?></label>
						<label class="col-sm-2 control-label">y_status: <?php echo $device['y_status'];?></label>
						<label class="col-sm-2 control-label">z_status: <?php echo $device['z_status'];?></label>
					</div>
					<div class="form-group">
                        <label for="" class="col-sm-2 control-label"></label>
                        <div class="col-sm-3">
                            <a href="<?php echo base_url(); ?>backend/machine_tracking/device/delete/<?php echo $device['id'];?>" class="btn btn-block btn-danger pull-left">DELETE</a>
                        </div>
                        <div class="col-sm-3">
                            <button type="submit" class="btn btn-block btn-success pull-left" name="form1">Edit</button>
                        </div>
                    </div>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</section>