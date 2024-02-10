
    <!-- Footer -->
    <footer class="footer fixed">
        <div class="container">
            <a href="mobile/account" class="btn btn-transparent btn-rounded d-block">CREATE AN ACCOUNT</a>
        </div>
    </footer>
    <!-- Footer End -->

    <!-- Menubar -->
	<div class="menubar-area">
		<div class="toolbar-inner menubar-nav justify-content-between">
			
			<a href="<?php echo base_url('mobile/home/index/1/2');?>" class="nav-link direct-link <?php echo $this->router->fetch_class() === 'home' ? 'active' : '';?>">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns:v="https://vecta.io/nano"><path d="M21.44 11.035a.75.75 0 0 1-.69.465H18.5V19a2.25 2.25 0 0 1-2.25 2.25h-3a.75.75 0 0 1-.75-.75V16a.75.75 0 0 0-.75-.75h-1.5a.75.75 0 0 0-.75.75v4.5a.75.75 0 0 1-.75.75h-3A2.25 2.25 0 0 1 3.5 19v-7.5H1.25a.75.75 0 0 1-.69-.465.75.75 0 0 1 .158-.818l9.75-9.75A.75.75 0 0 1 11 .246a.75.75 0 0 1 .533.222l9.75 9.75a.75.75 0 0 1 .158.818z" fill="#bfc9da"/></svg>
			</a>
			<a href="<?php echo base_url('mobile/order/upload-view');?>" class="nav-link direct-link <?php echo $this->router->fetch_class() === 'upload' ? 'active' : '';?>">
                <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" fill="#bfc9da"><path d="M22 16V4c0-1.1-.9-2-2-2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2zm-10.6-3.47l1.63 2.18 2.58-3.22c.2-.25.58-.25.78 0l2.96 3.7c.26.33.03.81-.39.81H9c-.41 0-.65-.47-.4-.8l2-2.67c.2-.26.6-.26.8 0zM2 7v13c0 1.1.9 2 2 2h13c.55 0 1-.45 1-1s-.45-1-1-1H5c-.55 0-1-.45-1-1V7c0-.55-.45-1-1-1s-1 .45-1 1z"></path></svg>
			</a>
            <a href="javascript:void(0);" class="back-btn">
                <svg width="18" height="18" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.03033 0.46967C9.2966 0.735936 9.3208 1.1526 9.10295 1.44621L9.03033 1.53033L2.561 8L9.03033 14.4697C9.2966 14.7359 9.3208 15.1526 9.10295 15.4462L9.03033 15.5303C8.76406 15.7966 8.3474 15.8208 8.05379 15.6029L7.96967 15.5303L0.96967 8.53033C0.703403 8.26406 0.679197 7.8474 0.897052 7.55379L0.96967 7.46967L7.96967 0.46967C8.26256 0.176777 8.73744 0.176777 9.03033 0.46967Z" fill="#a19fa8"></path>
                </svg>
			</a>
		</div>
	</div>
	<!-- Menubar -->
    <!-- Theme Color Settings -->
	<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom">
        <div class="offcanvas-body small">
            <ul class="theme-color-settings">
                <li>
                    <input class="filled-in" id="primary_color_8" name="theme_color" type="radio" value="color-primary" />
					<label for="primary_color_8"></label>
                    <span>Default</span>
                </li>
                <li>
					<input class="filled-in" id="primary_color_2" name="theme_color" type="radio" value="color-green" />
					<label for="primary_color_2"></label>
                    <span>Green</span>
                </li>
                <li>
                    <input class="filled-in" id="primary_color_3" name="theme_color" type="radio" value="color-blue" />
					<label for="primary_color_3"></label>
                    <span>Blue</span>
                </li>
                <li>
                    <input class="filled-in" id="primary_color_4" name="theme_color" type="radio" value="color-pink" />
					<label for="primary_color_4"></label>
                    <span>Pink</span>
                </li>
                <li>
                    <input class="filled-in" id="primary_color_5" name="theme_color" type="radio" value="color-yellow" />
					<label for="primary_color_5"></label>
                    <span>Yellow</span>
                </li>
                <li>
                    <input class="filled-in" id="primary_color_6" name="theme_color" type="radio" value="color-orange" />
					<label for="primary_color_6"></label>
                    <span>Orange</span>
                </li>
                <li>
                    <input class="filled-in" id="primary_color_7" name="theme_color" type="radio" value="color-purple" />
					<label for="primary_color_7"></label>
                    <span>Purple</span>
                </li>
                <li>
					<input class="filled-in" id="primary_color_1" name="theme_color" type="radio" value="color-red" />
					<label for="primary_color_1"></label>
                    <span>Red</span>
                </li>
                <li>
					<input class="filled-in" id="primary_color_9" name="theme_color" type="radio" value="color-lightblue" />
					<label for="primary_color_9"></label>
                    <span>Lightblue</span>
                </li>
                <li>
                    <input class="filled-in" id="primary_color_10" name="theme_color" type="radio" value="color-teal" />
					<label for="primary_color_10"></label>
                    <span>Teal</span>
                </li>
                <li>
                    <input class="filled-in" id="primary_color_11" name="theme_color" type="radio" value="color-lime" />
					<label for="primary_color_11"></label>
                    <span>Lime</span>
                </li>
                <li>
                    <input class="filled-in" id="primary_color_12" name="theme_color" type="radio" value="color-deeporange" />
					<label for="primary_color_12"></label>
                    <span>Deeporange</span>
                </li>
            </ul>
        </div>
    </div>
	<!-- Theme Color Settings End -->
	<!-- CART -->
	<div class="offcanvas offcanvas-bottom rounded-0" tabindex="-1" id="offcanvasBottom2">
		<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
			<i class="fa-solid fa-xmark"></i>
		</button>
        <div class="offcanvas-body container fixed">
			<div class="item-list style-2">
                <ul class="cart_list_contents">
                </ul>
            </div>
			<div class="view-title">
                <div class="container">
					<ul>
						<li>
							<h5>Total</h5>
							<h5 id="cart_total"></h5>
						</li>
					</ul>
					<a href="<?php echo base_url('mobile/checkout');?>" class="btn btn-primary btn-rounded btn-block direct-link flex-1 ms-2">CONFIRM</a>
				</div>
            </div>
        </div>
    </div>
	<!-- /CART -->
	<?php if($this->router->fetch_class() === 'home1'):?>
	<!-- PWA Offcanvas -->
	<div class="offcanvas offcanvas-bottom pwa-offcanvas">
		<div class="container">
			<div class="offcanvas-body small">
				<img class="logo" src="<?php echo base_url();?>public/layout/mobile/assets/images/iris.png" alt="">
				<h5 class="title">Youririspartner on Your Home Screen</h5>
				<p>Install Youririspartner - Iris Picture on your home screen, and access it just like a regular app</p>
				<a href="javascrpit:void(0);" class="btn btn-sm btn-primary pwa-btn">Add to Home Screen</a>
				<a href="javascrpit:void(0);" class="btn btn-sm pwa-close light btn-secondary ms-2">Maybe later</a>
			</div>
		</div>
	</div>
	<div class="offcanvas-backdrop pwa-backdrop"></div>
	<!-- PWA Offcanvas End -->
	<?php endif;?>
</div>
<!--**********************************
    Scripts
***********************************-->
<script src="<?php echo base_url();?>public/layout/mobile/assets/js/jquery.js"></script>
<script src="<?php echo base_url();?>public/layout/mobile/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url();?>public/layout/mobile/assets/vendor/swiper/swiper-bundle.min.js"></script><!-- Swiper -->
<script src="<?php echo base_url();?>public/layout/mobile/assets/js/dz.carousel.js"></script><!-- Swiper -->
<script src="<?php echo base_url();?>public/layout/mobile/assets/vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script><!-- Swiper -->
<script src="<?php echo base_url();?>public/layout/mobile/assets/js/settings.js?v=<?php echo time();?>"></script>
<script src="<?php echo base_url();?>public/layout/mobile/assets/js/custom.js?v=<?php echo time();?>"></script>
<script src="<?php echo base_url();?>public/layout/mobile/assets/js/shop.js?v=<?php echo time();?>"></script>
<script src="<?php echo base_url();?>public/layout/mobile/assets/js/index.js?v=<?php echo time();?>" defer></script>
<?php if(in_array($this->router->fetch_class(), ['gallery'])):?>
<script src="<?php echo base_url();?>public/layout/mobile/assets/vendor/lightgallery/dist/lightgallery.umd.js"></script>
<script src="<?php echo base_url();?>public/layout/mobile/assets/vendor/lightgallery/dist/plugins/thumbnail/lg-thumbnail.umd.js"></script>
<script src="<?php echo base_url();?>public/layout/mobile/assets/vendor/lightgallery/dist/plugins/zoom/lg-zoom.umd.js"></script>
<?php endif;?>
<?php if(in_array($this->router->fetch_class(), ['aaa'])):?>
    <script src="<?php echo base_url();?>public/layout/mobile/assets/js/camera.js?v=<?php echo time();?>" defer></script>
<?php endif;?>
<?php if(!in_array($this->router->fetch_class(), ['checkout', 'contact', 'order', 'account'])):?>
    <?php if(in_array($this->router->fetch_class(), ['aaa'])):?>
    <script src="//unpkg.com/hammer-touchemulator@0.0.2/touch-emulator.js"></script>
    <script>TouchEmulator()</script>
    <?php endif;?>
<!-- Pull to Refresh-->
<script src="https://www.boxfactura.com/pulltorefresh.js/demos/pulltorefresh.js"></script>
<script>
    /* global PullToRefresh */
    PullToRefresh.init({
        mainElement: '#main',
        onRefresh: function() { location.reload() }
      });
</script>
<!-- / Pull to Refresh -->
<?php endif;?>
<script>
    $(".stepper").TouchSpin();

    <?php if($this->router->fetch_class() === 'home'):?>
        var wow = new WOW(
            {
                boxClass:     'wow',      // animated element css class (default is wow)
                animateClass: 'animated', // animation css class (default is animated)
                offset:       1,          // distance to the element when triggering the animation (default is 0)
                mobile:       true       // trigger animations on mobile devices (true is default)
            });
            wow.init();
    <?php endif;?>
</script>
</body>
</html>