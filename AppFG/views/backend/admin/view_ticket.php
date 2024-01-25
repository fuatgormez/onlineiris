<section class="content-header">
	<div class="content-header-left">
		<h1>View Ticket</h1>
	</div>
	<div class="content-header-right">
		<a href="<?php echo base_url(); ?>backend/admin/ticket/add" class="btn btn-primary btn-sm">Add New</a>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">

			<?php if ($this->session->flashdata('error')):?>
				<div class="callout callout-danger">
					<p><?php echo $this->session->flashdata('error'); ?></p>
				</div>
			<?php endif;?>
			<?php if ($this->session->flashdata('success')):?>
				<div class="callout callout-success">
					<p><?php echo $this->session->flashdata('success'); ?></p>
				</div>
			<?php endif; ?>

			<div class="box box-info">
				<div class="box-body table-responsive">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>SL</th>
								<th>Title</th>
								<th>Username</th>
								<th>Department</th>
								<th>Urgency</th>
								<th>Status</th>
								<th width="140">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 0;
							foreach ($ticket as $row) : $i++; ?>
								<tr>
									<td style="width:100px;"><?php echo $i; ?></td>
									<td><?php echo $row['title']; ?></td>
									<td><?php echo $row['username']; ?></td>
									<td><?php echo $row['department']; ?></td>
									<td><?php echo $row['urgency']; ?></td>
									<td><?php echo $row['status'] === 'Close' ? '<span class="text-danger">'.$row['status'].'</span>' : '<span class="text-primary">'.$row['status'].'</span>'; ?></td>
									<td>
										<a href="<?php echo base_url(); ?>backend/admin/ticket/read/<?php echo $row['id']; ?>" class="btn btn-success btn-xs">Read</a>
										<a href="<?php echo base_url(); ?>backend/admin/ticket/edit/<?php echo $row['id']; ?>" class="btn btn-primary btn-xs">Edit</a>
										<a href="<?php echo base_url(); ?>backend/admin/ticket/delete/<?php echo $row['id']; ?>" class="btn btn-danger btn-xs" onClick="return confirm('Are you sure?');">Delete</a>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>