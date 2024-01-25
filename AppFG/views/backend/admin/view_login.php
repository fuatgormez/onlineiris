<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title>Login</title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/admin/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/admin/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/admin/css/ionicons.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/admin/css/datepicker3.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/admin/css/all.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/admin/css/select2.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/admin/css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/admin/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/admin/css/_all-skins.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/admin/css/style.css">
	<style>
		.login-forgot-password {
			background: radial-gradient(circle, #E91E63 0, #E91E63 80%);
			padding: 10px;
			border-radius: 5px;
			color: #FFF;
		}
	</style>
</head>

<body class="hold-transition login-page sidebar-mini">
	<div class="login-box">
		<div class="login-logo">
			<b>MANAGER</b>
		</div>
		<div class="login-box-body">
			<p class="login-box-msg">Log in to start your session</p>
			<?php if ($this->session->flashdata('error')) : ?>
				<div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
			<?php endif; ?>
			<?php if ($this->session->flashdata('success')) : ?>
				<div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
			<?php endif; ?>

			<?php echo form_open(base_url() . 'backend/admin'); ?>
			<div class="form-group has-feedback">
				<input class="form-control" placeholder="Username" name="username" type="text" autocomplete="off" autofocus>
			</div>
			<div class="form-group has-feedback">
				<input class="form-control" placeholder="Password" name="password" type="password" autocomplete="off" value="">
			</div>
			<div class="form-group has-feedback">
				<input name="remember" type="checkbox" id="remember" value="1"> <label for="remember">Remember me?</label>
			</div>
			<div class="alert alert-warning" style="padding-top: 0px;">
				<h3>Select Your Store</h3>
				<select name="land_id" class="form-control">
					<?php foreach ($all_land as $row_all_land) : ?>
						<option value="<?php echo $row_all_land['store_value_id']; ?>"><?php echo $row_all_land['land_name'] . ' - ' . strtoupper($row_all_land['lang_code']); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="row">
				<div class="col-xs-8" style="padding-top:10px;"><a href="<?php echo base_url(); ?>backend/admin/forget-password" class="login-forgot-password">Forget Password?</a></div>
				<div class="col-xs-4">
					<input type="submit" class="btn btn-primary btn-block btn-flat login-button" name="form1" value="Login">
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>


	<script src="<?php echo base_url(); ?>public/backend/admin/js/jquery-2.2.3.min.js"></script>
	<script src="<?php echo base_url(); ?>public/backend/admin/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>public/backend/admin/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url(); ?>public/backend/admin/js/dataTables.bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>public/backend/admin/js/select2.full.min.js"></script>
	<script src="<?php echo base_url(); ?>public/backend/admin/js/jquery.inputmask.js"></script>
	<script src="<?php echo base_url(); ?>public/backend/admin/js/jquery.inputmask.date.extensions.js"></script>
	<script src="<?php echo base_url(); ?>public/backend/admin/js/jquery.inputmask.extensions.js"></script>
	<script src="<?php echo base_url(); ?>public/backend/admin/js/moment.min.js"></script>
	<script src="<?php echo base_url(); ?>public/backend/admin/js/bootstrap-datepicker.js"></script>
	<script src="<?php echo base_url(); ?>public/backend/admin/js/icheck.min.js"></script>
	<script src="<?php echo base_url(); ?>public/backend/admin/js/fastclick.js"></script>
	<script src="<?php echo base_url(); ?>public/backend/admin/js/jquery.sparkline.min.js"></script>
	<script src="<?php echo base_url(); ?>public/backend/admin/js/jquery.slimscroll.min.js"></script>
	<script src="<?php echo base_url(); ?>public/backend/admin/js/app.min.js"></script>
	<script src="<?php echo base_url(); ?>public/backend/admin/js/demo.js"></script>

</body>

</html>