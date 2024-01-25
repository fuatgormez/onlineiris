    <!-- Page Content -->
    <div class="page-content m-t90">
        <!-- Banner -->
        <div class="banner-wrapper shape-1">
            <div class="container inner-wrapper">
                <h2 class="dz-title">Forgot Password</h2>
                <p class="mb-0">Please Enter Your Mobile Number</p>
            </div>
        </div>
        <!-- Banner -->
        <div class="account-box">
            <div class="container">
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
                <div class="account-area">
					<?php echo form_open(base_url('mobile/account/sms-confirm'));?>
                        <div class="mb-3 input-group input-mini">
							<span class="input-group-text"><i class="fa-solid fa-mobile-screen-button"></i></span>
							<input type="text" class="form-control" name="phone" placeholder="17683136136" id="phone">
						</div>
						<div class="input-group">
							<button type="submit" class="btn mt-2 btn-primary w-100 btn-rounded">SEND SMS</button>
						</div>
					<?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Content End -->