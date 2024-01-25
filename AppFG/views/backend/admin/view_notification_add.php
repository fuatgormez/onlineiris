<section class="content-header">
	<div class="content-header-left">
		<h1>Add Notification</h1>
	</div>
	<div class="content-header-right">
		<a href="<?php echo base_url(); ?>backend/admin/notification" class="btn btn-primary btn-sm">View All</a>
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

			<?php echo form_open_multipart(base_url() . 'backend/admin/notification/add', array('class' => 'form-horizontal')); ?>
			<div class="box box-info">
				<div class="box-body">
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Name <span>*</span></label>
						<div class="col-sm-8">
							<input type="text" autocomplete="off" class="form-control" name="title" value="">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Content </label>
						<div class="col-sm-8">
							<textarea id="editor1" class="form-control" name="content"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">To User</label>
						<div class="col-sm-8">
							<select class="form-control select2" name="to_user[]" multiple>
								<?php foreach ($get_all_user as $row_user) : ?>
									<option value="<?php echo $row_user['id']."@".$row_user['username'];?>"><?php echo $row_user['username'];?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">To Group</label>
						<div class="col-sm-8">
							<select class="form-control select2" name="to_group[]" multiple>
								<?php foreach ($get_all_user_group as $row_user_group) : ?>
									<option value="<?php echo $row_user_group['id']."@".$row_user_group['group_name'];?>"><?php echo $row_user_group['group_name'];?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Photo <span>*</span></label>
						<div class="col-sm-9" style="padding-top:5px">
							<input type="file" name="photo">(Only jpg, jpeg, gif and png are allowed 400x260px)
						</div>
					</div>
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