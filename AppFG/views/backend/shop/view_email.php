<section class="content-header">
	<div class="content-header-left">
		<h1>View Email</h1>
	</div>
	<div class="content-header-right">
		<a href="<?php echo base_url(); ?>backend/shop/email/add" class="btn btn-primary btn-sm">Add New</a>
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
								<th>SL</th>
								<th>Subject</th>
								<th>Type</th>
								<th>Step</th>
								<th width="140">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($email as $row) : ?>
								<tr>
									<td><?php echo $row['id']; ?></td>
									<td><a href="<?php echo base_url(); ?>backend/shop/email/edit/<?php echo $row['sku']; ?>"><?php echo $row['subject']; ?></a></td>
									<td><a href="<?php echo base_url(); ?>backend/shop/email/edit/<?php echo $row['sku']; ?>"><?php echo $row['type']; ?></a></td>
									<td><a href="<?php echo base_url(); ?>backend/shop/email/edit/<?php echo $row['sku']; ?>"><?php echo $row['step']; ?></a></td>
									<td>
										<a href="<?php echo base_url(); ?>backend/shop/email/edit/<?php echo $row['sku']; ?>" class="btn btn-primary btn-xs">Edit</a>
										<a href="<?php echo base_url(); ?>backend/shop/email/delete/<?php echo $row['sku']; ?>" class="btn btn-danger btn-xs" onClick="return confirm('Are you sure?');">Delete</a>
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