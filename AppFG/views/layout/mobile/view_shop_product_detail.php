<!-- Page Content -->
    <div class="page-content m-t100">
        <div class="content-body fb">
            <div class="swiper-btn-center-lr my-0">
                <div class="swiper-container demo-swiper">
                    <div class="swiper-wrapper">
                        <?php foreach($product_photo as $row):?>
                        <div class="swiper-slide">
                            <div class="dz-banner-heading">
                                <div class="overlay-black-light">
                                    <img src="<?php echo base_url('public/uploads/product_photos/'.$row['photo']);?>" class="bnr-img" alt="bg-image">
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                    <div class="swiper-btn">
                        <div class="swiper-pagination style-2 flex-1"></div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="company-detail">
                    <div class="detail-content">
                        <div class="flex-1">
                            <h4><?php echo $product['product_name'];?></h4>
                            <p><?php echo $product['content'];?></p>
                        </div>
                    </div>
                </div>
                <?php echo form_open(base_url('mobile/cart/add'), array('class' => 'form-horizontal', 'name' => 'basket')); ?>
                <div class="item-list-2">
                    <div class="price">
                        <span class="text-style">Preis</span>
                        <h3><?php echo $product['product_price'];?> <del><?php echo $product['product_price_old'] > 0 ? '€ '.$product['product_price_old'] : null;?></del></h3>
                    </div>
                    <div class="dz-stepper border-1 col-5 w-10">
                        <input type="hidden" name="product_id" value="<?php echo $product['id'];?>">
                        <button class="btn btn-danger btn-sm add-to-basket-button">Add to Cart</button>
                    </div>
                </div>
                <?php echo form_close();?>
            </div>
		</div>
    </div>
<!-- Page Content End -->

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