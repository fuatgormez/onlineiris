<section class="content-header">
	<div class="content-header-left">
		<h1>View Users</h1>
	</div>
	<div class="content-header-right">
		<a href="<?php echo base_url(); ?>backend/admin/user/add" class="btn btn-primary btn-sm">Add New</a>
	</div>
</section>


<section class="content">

	<div class="row">
		<div class="col-md-12">

			<?php
			if ($this->session->flashdata('error')) {
			?>
				<div class="callout callout-danger">
					<p><?php echo $this->session->flashdata('error'); ?></p>
				</div>
			<?php
			}
			if ($this->session->flashdata('success')) {
			?>
				<div class="callout callout-success">
					<p><?php echo $this->session->flashdata('success'); ?></p>
				</div>
			<?php
			}
			?>


			<div class="box box-info">

				<div class="box-body table-responsive">
					<table id="example1" class="content-table dataTable">
						<thead>
							<tr>
								<th width="50">SL</th>
								<th>Username</th>
								<th>Email</th>
								<th>Role</th>
								<th>Status</th>
								<th width="100">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($all_users as $row) : ?>
								<tr>
									<td><?php echo $row['id']; ?></td>
									<td><?php echo $row['username']; ?></td>
									<td><?php echo $row['email']; ?></td>
									<td><?php echo $row['role']; ?></td>
									<td><?php echo $row['status']; ?></td>
									<td>
										<a href="<?php echo base_url(); ?>backend/admin/user/edit/<?php echo $row['id']; ?>" class="btn btn-primary btn-xs">Edit</a>
										<a href="<?php echo base_url(); ?>backend/admin/user/delete/<?php echo $row['id']; ?>" class="btn btn-danger btn-xs" onClick="return confirm('Are you sure?');">Delete</a>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>


</section>