    <!-- Page Content -->
	<div class="page-content m-t100">
		<div class="container"> 
			<!-- MAKE PAYMENT -->
				<div class="box">
					<div class="payment-box">
						<div class="payment-successful">
							<i class="fa-solid fa-<?php echo $order_status ? 'check' : 'warning';?> mb-2"></i>
							<h1 class="text-white"><?php echo $message;?></h1>
							<?php if($order_status):?>
								<p>You've paid: <?php echo $get_order['total'];?></p>
							<?php endif;?>
						</div>
					</div>
					<?php if($order_status):?>
					<div class="text-center mt-3">
						<p class="text-dark mb-0">Receipt has been sent to your email address.</p>
						<a href="<?php echo base_url('mobile/order/billing/' . $get_order['order_number']);?>" class="btn-link">View Receipt <i class="fa-solid fa-angle-right ms-2"></i></a>
					</div>
					<div class="text-center mt-3">
						<p>Thank you for your order. The tutorial video and other essential information were sent through email.</p>
						<video class="w-100" height="300" controls>
							<source src="<?php echo base_url();?>public/uploads/how_do_it.mp4">
						</video>
					</div>
					<?php endif;?>
				</div>
			<!-- MAKE PAYMENT -->
		</div>
		<?php if($order_status):?>
		<div class="footer fixed m-b90">
			<div class="container">
				<p class="text-dark text-center">Your Order Number is <span class="font-w600 clipboard"><?php echo $get_order['order_number'];?></span></p>
				<div class="footer-btn d-flex align-items-center d-none">
					<a href="<?php echo base_url('mobile/order/tracking/' . $get_order['order_number']);?>" class="btn btn-primary flex-1 ms-2 direct-link">Order Delivery Status</a>
				</div>
			</div>
		</div>
		<?php endif;?>
	</div>
    <!-- Page Content End-->