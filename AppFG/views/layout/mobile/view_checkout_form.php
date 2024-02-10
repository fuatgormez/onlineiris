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
            <?php echo form_open(base_url('mobile/checkout/form-save'), array('class' => 'needs-validation', 'id' => 'checkout_submit', 'role' => 'form')); ?>
			<div class="accordion style-2" id="accordionExample">
				<div class="accordion-item">
					<h2 class="accordion-header" id="headingThree">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#make_payment" aria-expanded="false" aria-controls="make_payment">
							<i class="fa-solid fa-money-check me-2"></i>
							Form
							<!-- <i class="fa-solid fa-building-columns me-2"></i> -->
						</button>
					</h2>
					<div id="make_payment" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
						<div class="accordion-body pt-0">
							<div class="form">
                                <div class="row">
                                    <div class="form-group col-md-6 mt-3">
                                        <label class="form-label" for="billingFirstName">Firstname <span class="text-color-danger">*</span></label>
                                        <input type="text" class="form-control" name="billingFirstName" id="billingFirstName" value="<?php echo $this->session->userdata['payment_form']['billing_firstname'] ?? null;?>"  required>
                                    </div>
                                    <div class="form-group col-md-6 mt-3">
                                        <label class="form-label" for="billingLastName">Lastname <span class="text-color-danger">*</span></label>
                                        <input type="text" class="form-control h-auto py-2" name="billingLastName" id="billingLastName" value="<?php echo $this->session->userdata['payment_form']['billing_lastname'] ?? null;?>"  required="">
                                    </div>
                                </div>
								<div class="row">
                                    <div class="form-group col-md-8 mt-3">
                                        <label class="form-label" for="billingStreet">Street <span class="text-color-danger">*</span></label>
                                        <input type="text" class="form-control h-auto py-2" name="billingStreet" id="billingStreet" value="<?php echo $this->session->userdata['payment_form']['billing_street'] ?? null;?>"  required="">
                                    </div>
                                    <div class="form-group col-md-4 mt-3">
                                        <label class="form-label" for="billingStreetNo">Nr. <span class="text-color-danger">*</span></label>
                                        <input type="text" class="form-control h-auto py-2" name="billingStreetNo" id="billingStreetNo" value="<?php echo $this->session->userdata['payment_form']['billing_street_no'] ?? null;?>"  required="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mt-3">
                                        <label class="form-label" for="billingPostCode">Postcode <span class="text-color-danger">*</span></label>
                                        <input type="text" class="form-control h-auto py-2" name="billingPostCode" id="billingPostCode" value="<?php echo $this->session->userdata['payment_form']['billing_postcode'] ?? null;?>"  required="">
                                    </div>
                                    <div class="form-group col-md-6 mt-3">
                                        <label class="form-label" for="billingCity">City <span class="text-color-danger">*</span></label>
                                        <input type="text" class="form-control h-auto py-2" name="billingCity" id="billingCity" value="<?php echo $this->session->userdata['payment_form']['billing_city'] ?? null;?>"  required="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mt-3">
                                        <label class="form-label" for="billingEmail">E-Mail Adress</label>
                                        <input type="text" class="form-control h-auto py-2" name="billingEmail" id="billingEmail" value="<?php echo $this->session->userdata['payment_form']['billing_email'] ?? null;?>"  required="">
                                    </div>
                                    <div class="form-group col-md-6 mt-3">
                                        <label class="form-label" for="billingPhone">Phone</label>
                                        <input type="text" class="form-control h-auto py-2" name="billingPhone" id="billingPhone" value="<?php echo $this->session->userdata['payment_form']['billing_phone'] ?? null;?>"  required="">
                                    </div>
                                </div>
                                <div class="row mt-3 d-none">
                                    <div class="form-group col">
                                        <label class="form-label" for="billingStoreId">Store Name Central</label>
                                        <select name="billingStoreId" id="billingStoreId" class="form-select form-control">
                                            <?php foreach($store as $row):?>
                                                <option value="<?php echo $row['id'];?>" <?php echo $order->store_id == $row['id'] ? 'selected' : null;?>><?php echo $row['land_name'] .' -> '. $row['store_name'];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="form-group col">
                                        <label class="form-label" for="billingComment">Comment</label>
                                        <textarea class="form-control h-auto py-2" name="billingComment" id="billingComment" rows="5" placeholder="..." ><?php echo $this->session->userdata['payment_form']['billing_comment'] ?? null;?></textarea>
                                        <input type="hidden" class="d-none" name="order_number"  value="<?php echo $order->order_number;?>">
                                        <input type="hidden" class="d-none" name="security_number"  value="<?php echo $order->security_number;?>">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <h6>Shipping price: €<?php echo $this->session->userdata('shipping_total');?></h6>
                                </div>
							</div>
						</div>
					</div>
				</div>
			</div>
            <a href="javascript:;" onclick="parentNode.submit();" class="btn btn-primary btn-block direct-link make_payment">NEXT STEP</a>
            <?php form_close();?> 
		</div>
	</div>
    <!-- Page Content End-->