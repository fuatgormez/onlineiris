<section class="content-header">
	<div class="content-header-left">
		<h1>User Edit</h1>
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
						<?php echo form_open(base_url() . 'backend/admin/user/edit/' . $user->id, array('class' => 'form-horizontal', 'name' => 'form1')); ?>
						<div class="col-md-6">
							<div class="form-group">
								<label for="" class="col-sm-2 control-label">Username <span>*</span></label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="username" value="<?php echo $user->username; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-sm-2 control-label">Email <span>*</span></label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="email" value="<?php echo $user->email; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-sm-2 control-label">Phone <span>*</span></label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="phone" value="<?php echo $user->phone; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-sm-2 control-label">Password</label>
								<div class="col-sm-9">
									<input type="password" class="form-control" name="password">
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-sm-2 control-label">Status<span>*</span></label>
								<div class="col-sm-9">
									<select name="status" class="form-control select2">
										<option value="Active" <?php echo $user->status == 'Active' ? 'selected' : null ?>>Active</option>
										<option value="Passive" <?php echo $user->status == 'Passive' ? 'selected' : null ?>>Passive</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-sm-2 control-label">Role</label>
								<div class="col-sm-9">
									<select class="form-control select2" name="role">
										<?php if ($this->session->userdata('role') === "Superadmin") : ?>
											<option value="Superadmin" <?php echo $user->role === "Superadmin" ? 'selected' : ''; ?>>Super Admin</option>
										<?php endif; ?>
										<option value="Admin" <?php echo $user->role === "Admin" ? 'selected' : ''; ?>>Admin</option>
										<option value="Meister" <?php echo $user->role === "Meister" ? 'selected' : ''; ?>>Meister</option>
										<option value="Production" <?php echo $user->role === "Production" ? 'selected' : ''; ?>>Production</option>
										<option value="Designer" <?php echo $user->role === "Designer" ? 'selected' : ''; ?>>Designer</option>
										<option value="Seller" <?php echo $user->role === "Seller" ? 'selected' : ''; ?>>Seller</option>
										<option value="Ads" <?php echo $user->role === "Ads" ? 'selected' : ''; ?>>Ads</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-sm-2 control-label"></label>
								<div class="col-sm-9">
									<button type="submit" class="btn btn-block btn-success pull-left ajax_request">Submit</button>
								</div>
							</div>
						</div>
						<?php echo form_close(); ?>

						<?php echo form_open_multipart(base_url() . 'backend/admin/user/edit/' . $user->id, array('class' => 'form-horizontal')); ?>
						<div class="col-md-6">
							<!-- User Profil Photo -->
							<div class="form-group">
								<label for="" class="col-sm-4 control-label">Existing Profil Photo</label>
								<div class="col-sm-8" style="padding-top:5px">
									<img src="<?php echo base_url(); ?>public/uploads/user/<?php echo $user->photo; ?>?v=<?php echo time(); ?>" alt="" style="width:120px;">
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-sm-4 control-label">Change User Photo</label>
								<div class="col-sm-8" style="padding-top:5px">
									<input type="file" name="photo">(Only jpg, jpeg, gif and png are allowed)
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-sm-2 control-label"></label>
								<div class="col-sm-6">
									<button type="submit" class="btn btn-block btn-success pull-left" name="form2">Upload new Photo</button>
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