<section class="content-header">
	<div class="content-header-left">
		<h1>View Notification</h1>
	</div>
	<div class="content-header-right">
		<a href="<?php echo base_url(); ?>backend/admin/notification/add" class="btn btn-primary btn-sm">Add notification</a>
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
				<div class="box-body table-responsive">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th width="30">id</th>
								<th>title</th>
								<th>photo</th>
								<th width="80">action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($notification as $key => $row):?>
							<tr>
								<td><?php echo $row['id'];?></td>
								<td><?php echo $row['title'];?></td>
								<td><img width="50px" src="<?php echo base_url("public/uploads/notification/".$row['photo']."?v=".time());?>"></td>
								<td>
								<a href="<?php echo base_url(); ?>backend/admin/notification/edit/<?php echo $row['id']; ?>" class="btn btn-primary btn-xs">Edit</a>
										<a href="<?php echo base_url(); ?>backend/admin/notification/delete/<?php echo $row['id']; ?>" class="btn btn-danger btn-xs" onClick="return confirm('Are you sure?');">Delete</a>  
								</td>
							</tr>
							<?php endforeach;?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>