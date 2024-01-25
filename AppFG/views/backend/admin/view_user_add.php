<section class="content-header">
	<div class="content-header-left">
		<h1>User Add</h1>
	</div>
	<div class="content-header-right">
		<a href="<?php echo base_url(); ?>backend/admin/user" class="btn btn-primary btn-sm">View All</a>
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

			<div class="box box-info">
				<div class="box-body">
					<div class="row">
						<?php echo form_open(base_url('backend/admin/user/add'), array('class' => 'form-horizontal', 'name' => 'form1')); ?>
						<div class="col-md-6">
							<div class="form-group">
								<label for="" class="col-sm-2 control-label">Username <span>*</span></label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="username">
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-sm-2 control-label">Password <span>*</span></label>
								<div class="col-sm-9">
									<input type="password" class="form-control" name="password">
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-sm-2 control-label">Email <span>*</span></label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="email">
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-sm-2 control-label">Phone <span>*</span></label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="phone" placeholder="17682136141">
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-sm-2 control-label">Status<span>*</span></label>
								<div class="col-sm-9">
									<select name="status" class="form-control select2">
										<option value="Active">Active</option>
										<option value="Passive">Passive</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-sm-2 control-label">Role</label>
								<div class="col-sm-9">
									<select class="form-control select2" name="role">
										<?php if ($this->session->userdata('role') === "Superadmin") : ?>
											<option value="Superadmin">Super Admin</option>
										<?php endif; ?>
										<option value="Admin">Admin</option>
										<option value="Meister">Meister</option>
										<option value="Production">Production</option>
										<option value="Designer">Designer</option>
										<option value="Seller">Seller</option>
										<option value="Ads">Ads</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-sm-2 control-label"></label>
								<div class="col-sm-9">
									<button type="submit" name="form1" class="btn btn-block btn-success pull-left">Submit</button>
								</div>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>