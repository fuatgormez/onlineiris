<!-- Page Content -->
    <div class="page-content m-t100">
		<div class="container"> 
			<div class="serach-area"> 
                <div class="swiper-btn-center-lr">
                    <div class="swiper-container mt-4 categorie-swiper">
                        <div class="swiper-wrapper">
                            <?php foreach($all_category as $row):?>
                            <div class="swiper-slide">
                                <a href="<?php echo base_url('mobile/shop/product-category/'.$row['category_id']);?>" class="categore-box direct-link style-2 primary p-3">
                                    <span class="title"><?php echo $row['category_name'];?></span>
                                </a>
                            </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>

                <!-- TITLE -->
                <h4 class="title my-4"><?php echo $category['category_name'];?></h4>
                <!-- TITLE -->

				<div class="item-list recent-jobs-list p-b70">
					<ul>
                        <?php foreach($product_category as $row):?>
						<li onclick="location.href='<?php echo base_url('mobile/shop/product-detail/'.$row['id']);?>';" class="direct-link" style="cursor:pointer;">
							<div class="item-content">
								<div class="item-inner">
									<div class="item-title-row">
										<h6 class="item-title"><?php echo $row['product_name'];?></h6>
										<div class="item-subtitle"><?php echo $row['short_content'];?></div>
									</div>
                                    <div class="item-footer">
                                        <div class="d-flex align-items-center">
                                            <h6 class="me-3">€ <?php echo $row['product_price'];?></h6>
                                            <del class="off-text"><h6><?php echo $row['product_price_old'] > 0 ? '€ '.$row['product_price_old'] : null;?></h6></del>
                                        </div>
                                    </div>
								</div>
                                <div class="item-media media media-90"><img src="<?php echo base_url('public/uploads/product_photos/thumbnail/'.$row['thumbnail']);?>">
                                </div>
							</div>
						</li>
                        <?php endforeach;?>
                    </ul>
				</div>
				<!-- Job List -->
			</div>
		</div>
	</div>
    <!-- Page Content End-->