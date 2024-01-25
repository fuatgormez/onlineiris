    <!-- Page Content -->
    <div class="page-content">
        
        <!-- Banner -->
        <div class="banner-wrapper m-t90">
            <div class="circle-1"></div>
            <div class="container inner-wrapper">
                <h1 class="dz-title">Login</h1>
                <p class="mb-0">-</p>
            </div>
        </div>
        <!-- Banner End -->
        <div class="account-box">
            <div class="container">
                <div class="account-area">
                    <?php if ($this->session->flashdata('error')) : ?>
                        <div class="alert alert-warning light alert-dismissible fade show">
                            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>	
                            <strong>Warning!</strong> <?php echo $this->session->flashdata('error'); ?>
                            <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('success')) : ?>
                        <div class="alert alert-success light alert-dismissible fade show">
                            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>	
                            <strong>Success!</strong> <?php echo $this->session->flashdata('error'); ?>
                            <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    <?php endif; ?>
                    <h3 class="title mt-4">Welcome back</h3>
                    <p>-</p>
					<?php echo form_open('mobile/account/login');?>
						<div class="input-group input-mini mb-3">
							<span class="input-group-text"><i class="fa fa-user"></i></span>
							<input type="text" name="username" class="form-control" placeholder="Username">
						</div>
						<div class="mb-3 input-group input-mini">
							<span class="input-group-text"><i class="fa fa-lock"></i></span>
							<input type="password" name="password" class="form-control dz-password" placeholder="Password">
							<span class="input-group-text show-pass">
								<i class="fa fa-eye-slash"></i>
								<i class="fa fa-eye"></i>
							</span>
						</div>
						<div class="input-group">
							<button type="submit" class="btn mt-2 btn-primary w-100 btn-rounded" name="form1">SIGN IN</button>
						</div>
						<div class="d-flex justify-content-between align-items-center">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
								<label class="form-check-label" for="flexCheckChecked">
									Keep Sign In
								</label>
							</div>
							<a href="<?php echo base_url('mobile/account/forgot-password');?>" class="btn-link">Forgot password?</a>
						</div>
					<?php echo form_close();?>
                    <div class="text-center mb-auto p-tb20">
                        <a href="signup.html" class="saprate">Don’t have an account?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Content End -->