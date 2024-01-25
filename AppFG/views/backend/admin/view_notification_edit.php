<section class="content-header">
	<div class="content-header-left">
		<h1>Edit notification</h1>
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

			<?php echo form_open_multipart(base_url() . 'backend/admin/notification/edit/' . $notification['id'], array('class' => 'form-horizontal')); ?>
			<div class="box box-info">
				<div class="box-body">
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Title <span>*</span></label>
						<div class="col-sm-6">
							<input type="text" autocomplete="off" class="form-control" name="title" value="<?php echo $notification['title']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Content </label>
						<div class="col-sm-6">
							<textarea id="editor1" class="form-control" name="content"><?php echo $notification['content']; ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">To User</label>
						<div class="col-sm-8">
							<select class="form-control select2" name="to_user[]" multiple>
								<?php foreach ($get_all_user as $row_user) : ?>
									<?php $explode_to_user = json_decode($notification['to_user']) ?>
									<option value="<?php echo $row_user['id'] . "@" . $row_user['username']; ?>" <?php echo in_array($row_user['id']."@".$row_user['username'], $explode_to_user) ? 'selected' : ''; ?>><?php echo $row_user['username']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">To Group</label>
						<div class="col-sm-8">
						<select class="form-control select2" name="to_group[]" multiple>
								<?php foreach ($get_all_user_group as $row_user_group) : ?>
									<?php $explode_to_user_group = json_decode($notification['to_group']) ?>
									<option value="<?php echo $row_user_group['id'] . "@" . $row_user_group['group_name']; ?>" <?php echo in_array($row_user_group['id']."@".$row_user_group['group_name'], $explode_to_user_group) ? 'selected' : ''; ?>><?php echo $row_user_group['group_name']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Existing Photo</label>
						<div class="col-sm-9" style="padding-top:5px">
							<img src="<?php echo base_url(); ?>public/uploads/notification/<?php echo $notification['photo']."?v=".time(); ?>" style="width:180px;">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Photo </label>
						<div class="col-sm-6" style="padding-top:5px">
							<input type="file" name="photo">(Only jpg, jpeg, gif and png are allowed)
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