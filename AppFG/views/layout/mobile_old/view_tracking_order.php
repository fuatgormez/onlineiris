    <!-- Page Content -->
	<div class="page-content m-t70">
		<div class="container bottom-content">
            <div class="location-area">
				<div class="d-flex align-items-center">
					<a href="javascript:void(0);" class="location-mark">
						<i class="fa-solid fa-location-dot"></i>
					</a>
					<div class="ms-3">
						<h6 class="title"><?php echo $get_order['land_name'];?></h6>
						<span class="font-14 font-w600"><?php echo $get_order['billing_street'] . ' '. $get_order['billing_street_no'].', '. $get_order['billing_city'] ;?></span>
					</div>
				</div>
				<div class="text-end">
					<div class="d-flex align-items-center">
						<i class="me-2 fa-solid fa-clock"></i>
						<small class="font-w600">Arrive time</small>
					</div>
					<span class="font-w900 font-14 text-dark d-block">6-7 Day</span>
				</div>
			</div>
			
				<div class="embed-responsive">
                	<iframe width="100%" height="100%" class="embed-responsive-item" frameborder="0" src="https://www.google.com/maps/embed/v1/place?q=<?php echo $get_order['billing_street'] . ' '. $get_order['billing_street_no'].', '. $get_order['billing_city'] ;?>&key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8"></iframe>
				</div>

			<div class="order-status m-5">
				<h6 class="title">Order Status</h6>
				<ul class="dz-timeline style-2">
					<li class="timeline-item process">
						<h6 class="timeline-tilte">Order Recived</h6>
						<p class="timeline-date"><?php echo $get_order['date_purchased'];?></p>
					</li>
					<li class="timeline-item <?php echo $get_order['status_process'] == 2 || $get_order['status_process'] > 1  ? 'process' : null;?>">
						<h6 class="timeline-tilte">PHOTOGRAPHED</h6>
						<p class="timeline-date">-</p>
					</li>
					<li class="timeline-item <?php echo $get_order['status_process'] == 3 || $get_order['status_process'] > 2 ? 'process' : null;?>">
						<h6 class="timeline-tilte process">FULLPHOTOGRAPHED</h6>
						<p class="timeline-date">-</p>
					</li>
					<li class="timeline-item <?php echo $get_order['status_process'] == 4 || $get_order['status_process'] > 3 ? 'process' : null;?>">
						<h6 class="timeline-tilte">IN PHOTOSHOP</h6>
						<p class="timeline-date">-</p>
					</li>
					<li class="timeline-item <?php echo $get_order['status_process'] == 5 || $get_order['status_process'] > 4 ? 'process' : null;?>">
						<h6 class="timeline-tilte">FINISHED PHOTOSHOP</h6>
						<p class="timeline-date">-</p>
					</li>
					<li class="timeline-item <?php echo $get_order['status_process'] == 6 || $get_order['status_process'] > 5 ? 'process' : null;?>">
						<h6 class="timeline-tilte">CUSTOMER CONFIRMED</h6>
						<p class="timeline-date">-</p>
					</li>
					<li class="timeline-item <?php echo $get_order['status_process'] == 7 || $get_order['status_process'] > 6 ? 'process' : null;?>">
						<h6 class="timeline-tilte">FINISHED PHOTOSHOP DATA</h6>
						<p class="timeline-date">-</p>
					</li>
					<li class="timeline-item <?php echo $get_order['status_process'] == 8 || $get_order['status_process'] > 7 ? 'process' : null;?>">
						<h6 class="timeline-tilte">PRINTED</h6>
						<p class="timeline-date">-</p>
					</li>
					<li class="timeline-item <?php echo $get_order['status_process'] == 9 || $get_order['status_process'] > 8 ? 'process' : null;?>">
						<h6 class="timeline-tilte">SHIPPED</h6>
						<p class="timeline-date">-</p>
					</li>
				</ul>
			</div>
			<div class="footer fixed m-t50 m-b70">
				<div class="container">
					<div class="footer-btn d-flex align-items-center">
						<a href="#" class="btn btn-primary btn-block disabled">CONFIRM DELIVERY</a>
					</div>
				</div>
			</div>
		</div>
	</div>
    <!-- Page Content End-->