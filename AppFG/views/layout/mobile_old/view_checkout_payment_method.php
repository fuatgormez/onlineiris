    <!-- Page Content -->
    <div class="page-content m-t70 m-b90">
		<div class="container">
            <?php if ($this->session->flashdata('success')) : ?>
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-success solid alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>	
                        <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
                        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')) : ?>
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-danger solid alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
                        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php endif; ?>
			<div class="title-bar">
				<span class="font-14 title">Select Payment mode</span>
			</div>
            <?php echo form_open(base_url('mobile/checkout/payment'), array('class' => 'needs-validation', 'id' => 'checkout-submit', 'role' => 'form')); ?>
			<div class="accordion style-2" id="accordionExample">
				<div class="accordion-item">
					<h2 class="accordion-header" id="headingTwo">
						<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
							<i class="fa-solid fa-credit-card me-2"></i>
							Credit/Debit Card
						</button>
					</h2>
					<div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
						<div class="accordion-body">
							<small class="font-w600 mb-2"></small>
							<!-- Card Select -->
							<div class="d-flex align-items-center mb-3">
								<!-- Card Select -->
								<div class="short-tag style-3" role="group" aria-label="radio toggle button">
                                    <?php foreach ($methods as $key => $method) : ?>
                                        <div class="clearfix ">
                                            <input type="radio" class="btn-check" name="payment_method" id="btnradio<?php echo $key;?>" value="<?php echo $method->id;?>" <?php echo $key == 0 ? 'checked' : null;?>>
                                            <label class="btn btn-block ms-2 mb-0 tag-btn" for="btnradio<?php echo $key;?>">
                                                <img src="<?php echo htmlspecialchars($method->image->size2x); ?>" srcset="<?php echo htmlspecialchars($method->image->size2x); ?> 1x">
                                            </label>
                                        </div>
                                    <?php endforeach;?>
								</div>
							</div>
                            <h1 class="mt-5 d-none"><a href="<?php echo base_url('mobile/mollie/qrcode');?>">OR WITH QR CODE PAYMENT</a></h1>
						</div>
					</div>
				</div>
			</div>
            <input type="hidden" name="order_number" value="<?php echo $order->order_number;?>">
			<button type="submit" class="btn btn-primary btn-block direct-link make_payment">MAKE PAYMENT WITH <span class="selected_payment_method"><?php echo $methods[0]->description;?></span>: €<?php echo $order->order_total;?></button>
            <?php form_close();?>
		</div>
	</div>
    <!-- Page Content End-->