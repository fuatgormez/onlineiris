<section class="content-header">
	<div class="content-header-left">
		<h1>View Contacts</h1>
	</div>
	<div class="content-header-right">
		<a href="<?php echo base_url('backend/contact'); ?>" class="btn btn-primary btn-sm">All Contact Message</a>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<?php if($this->session->flashdata('error')):?>
				<div class="callout callout-danger">
					<p><?php echo $this->session->flashdata('error'); ?></p>
				</div>
			<?php endif;?>
			<?php if($this->session->flashdata('success')):?>
				<div class="callout callout-success">
					<p><?php echo $this->session->flashdata('success'); ?></p>
				</div>
			<?php endif;?>

			<div class="box box-info">
				<div class="box-body table-responsive">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th width="10">SL</th>
								<th width="80">Name</th>
								<th width="80">Email</th>
								<th width="100">Subject</th>
								<th width="100">Message</th>
								<th width="10">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($contact_messages as $key => $row):?>
								<tr>
									<td><?php echo $key+1; ?></td>
									<td><?php echo $row['name']; ?></td>
									<td><?php echo $row['email']; ?></td>
									<td><?php echo $row['subject']; ?></td>
									<td><?php echo $row['message']; ?></td>
									<td>
										<a href="<?php echo base_url('backend/admin/contact/delete/'.$row['id']); ?>" class="btn btn-danger btn-xs" onClick="return confirm('Are you sure?');">Delete</a>
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