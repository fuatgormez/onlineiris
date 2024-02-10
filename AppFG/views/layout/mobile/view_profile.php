    <!-- Page Content -->
    <div class="page-content bottom-content m-t90">
        <div class="container profile-area">
            <div class="profile">
                <div class="media media-100">
                    <img src="<?php echo base_url('public/uploads/'. $profile['photo'] ?? 'not-found.png');?>" alt="/">
                    <svg class="progress-style" height="100" width="100">
                        <circle id="round-1" cx="60" cy="60" r="50" stroke="#E8EFF3" stroke-width="7" fill="none" />
                        <circle id="round-2" cx="60" cy="60" r="50" stroke="#C3AC58" stroke-width="7" fill="none" />
                    </svg>
                </div>
                <div class="mb-2">
                    <h4><?php echo $profile['firstname'] .' '. $profile['lastname'];?></h4>
                    <h6 class="detail"><?php echo $profile['role'];?></h6>
                </div>
            </div>    
            <div class="contact-section">
                <div class="d-flex justify-content-between align-item-center">
                    <h5 class="title">Contacts</h5>
                    <a href="javascript:void(0);" class="btn-link">Edit</a>
                </div>
                <ul>
                    <li>
						<a href="messages.html">
							<div class="icon-box">
								<i class="fa-solid fa-phone"></i>
							</div> 
							<div class="ms-3">
								<div class="light-text">Mobile Phone</div>
								<p class="mb-0"><?php echo $profile['phone'];?></p>
							</div>
						</a>
					</li>
					<li>
						<a href="messages.html">
							<div class="icon-box">
								<i class="fa-solid fa-envelope"></i>
							</div> 
							<div class="ms-3">
								<div class="light-text">Email Address</div>
								<p class="mb-0"><?php echo $profile['email'];?></p>
							</div>
						</a>
					</li>
					<li>
						<a href="messages.html">
							<div class="icon-box">
								<i class="fa-solid fa-location-dot"></i>
							</div> 
							<div class="ms-3">
								<div class="light-text">Address</div>
								<p class="mb-0"><?php echo $profile['address'];?></p>
							</div>
						</a>
					</li>
				</ul>
            </div>
        </div>
    </div>
    <!-- Page Content End-->