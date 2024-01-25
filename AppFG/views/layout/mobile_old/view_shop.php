<!-- Page Content -->
    <div class="page-content">
        <div class="content-inner pt-0">
			<div class="container fb">
                <!-- Dashboard Area -->
                <div class="dashboard-area m-t90">
					<!-- Recent -->
					<div class="m-b10">
                        <div class="card add-banner bg-primary">
                            <div class="circle-1"></div>
                            <div class="circle-2"></div>
                            <div class="card-body" style="padding:5px">
                                <div class="card-info">
                                    <video width="100%" height="" controls autoplay>
                                        <source src="<?php echo base_url('public/uploads/shop_banner.mp4');?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            </div>
                        </div>
                    </div>
					<!-- Recent -->

                    <!-- ShowVideo -->
                    <div class="modal fade" tabindex="-1" id="showVideo"  aria-labelledby="showVideo" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">IRIS AND CAT</h5>
                                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                                </div>
                                <div class="modal-body">
                                    <div class="ctx embed-responsive">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ShowVideo End-->

					<!-- Recomended Start -->
                    <div class="contact-section">
                            <h1 class="title">How can I do that?</h1>
                            <p>After purchasing a voucher, you will receive a tutorial video.</p>
                            <p>Take a picture of your eyes with your smartphone and upload it. (You can take and upload pictures at any time.)</p>
                            <p>📢VERY IMPORTANT 📢If you don't follow the instruction video, your iris photo may not be of the highest quality.</p>
                            <p>In today's deal, each customer may purchase a maximum of 5 vouchers.</p>
                    </div>
					<!-- Recomended Start -->
                    <div class="title-bar">
                        <h5 class="title">YOUR EYES ARE UNIQUE, YOUR EYES ARE THE MIRROR OF YOUR SOUL</h5>
                        <a class="btn-link" href="<?php echo base_url('mobile/shop');?>)">-</a>
                    </div>
                    <div class="swiper-btn-center-lr">
                        <div class="swiper-container tag-group mt-4 recomanded-swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="recomended-list direct-link" onclick="location.href='#'">
                                        <div class="image-box">
                                            <video width="228" height="256" controls autoplay>
                                                <source src="<?php echo base_url('public/uploads/your_eye_photo.mp4');?>" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                        <div class="text-content">
                                            aaa
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="recomended-list direct-link" onclick="location.href='#'">
                                        <div class="image-box">
                                            <video width="228" height="256" controls autoplay>
                                                <source src="<?php echo base_url('public/uploads/personalized_amigurumi.mp4');?>" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                        <div class="text-content">
                                            aaa
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="recomended-list direct-link" onclick="location.href='#'">
                                        <div class="image-box">
                                            <video width="228" height="256" controls autoplay>
                                                <source src="<?php echo base_url('public/uploads/we.mp4');?>" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                        <div class="text-content">
                                            aaa
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<!-- Recomended Start -->
                    <div class="divider border-light mb-0"></div>
					<!-- text Start -->
                    <div class="title-bar text-center mt-5">
                        <h5 class="title">We reveal a detailed image of your eye using the special technology we created.</h5>
                    </div>
                    <div class="divider border-light mb-0"></div>
                    <!-- Item box Start -->
                    <div class="title-bar">
                        <h5 class="title">Categories & Products &#128293;</h5>
                    </div>
                    <?php foreach($product_category as $row):?>
                        <?php $buttom_price_old = '0.00'; $counter = 0;?>
                    <?php echo form_open(base_url('mobile/cart/add'), array('class' => 'form-horizontal', 'name' => 'basket')); ?>
                    <div class="item-box">
                        <div class="item-media">
                            <img src="<?php echo base_url('public/uploads/product_category_photos/thumbnail/'.$row['thumbnail_photo']);?>" alt="" width="500">
                        </div>
                        <div class="item-content" style="margin-left:10px">
                            <h6 class="mb-0"><?php echo $row['category_name']; ?></h6>
                            <select class="mt-4 select_box_product" name="product_id">
                                <?php foreach($products as $key => $product):?>
                                    <?php if($row['category_id'] == $product['category_id']):?>
                                        <?php if ($counter == 0) {$buttom_price_old = $product['product_price_old'];}?>
                                        <option value="<?php echo $product['id'];?>"><?php echo $product['product_name'].' €'. $product['product_price'];?></option>
                                        <?php $counter = $counter + 1; ?>
                                    <?php endif;?>
                                <?php endforeach;?>
                            </select>
                            <h1 class="mt-3" id="select_box_product<?php echo $row['category_id'];?>" style="text-decoration:line-through">€<?php echo @$buttom_price_old;?></h1>
                            <div class="item">
                                <div class="mt-5">
                                    <?php echo $row['short_description']; ?>
                                </div>
                                <div class="divider border-light mb-0"></div>
                                <div class="mt-5">
                                    <?php echo $row['description']; ?>
                                </div>
                                <button class="btn btn-danger btn-block btn-sm add-to-basket-button">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close();?>
                    <?php endforeach;?>
					<!-- Item box End -->
				</div>
			</div>
		</div>
    </div>
<!-- Page Content End-->

<!-- Cart Modal -->
<div class="modal fade" tabindex="-1" id="cartModal"  aria-labelledby="cartModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
				<h5 class="modal-title">CART</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body text-center small p-4">
				<i class="fa fa-4x fa-check-circle text-success m-b15"></i>
				<h5>THE ITEM HAS BEEN ADDED TO THE CART</h5>
                <button class="btn btn-block btn-primary m-b0 notify-cart" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom2" aria-controls="offcanvasBottom">Show your cart</button>
            </div>
        </div>
    </div>
</div>
<!-- Cart Modal End -->