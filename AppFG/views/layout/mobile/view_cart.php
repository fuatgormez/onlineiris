<!-- Page content -->
    <div class="page-content">
        <div class="container bottom-content m-t90"> 
            <div class="item-list style-2">
                <ul class="cart_list_contents">
                    <?php foreach($this->cart->contents() as $item):?>
                        <li>
                            <div class="item-content">
                                <div class="item-media media media-60">
                                    <img src="<?php echo base_url('/public/uploads/product_photos/thumbnail/'.$item['image']);?>">
                                </div>
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <h6 class="item-title"><a href="<?php echo base_url('mobile/shop/product-detail/'.$item['id']);?>"><?php echo $item['name'];?></a></h6>
                                    </div>
                                    <div class="item-footer">
                                        <div class="d-flex align-items-center">
                                            <h6 class="me-3">€ <?php echo $item['price'];?></h6>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="dz-stepper border-1 ">
                                                <div class="">
                                                <span class="input-group-btn input-group-prepend">
                                                    <button class="subtruct_itm_qty btn btn-primary bootstrap-touchspin-down" type="button" data-action="0" data-product-id="<?php echo $item['id'];?>" data-rowid="<?php echo $item['rowid'];?>">-</button>
                                                </span>
                                                <input class="stepper qty form-control" type="text" name="quantity" value="<?php echo $item['qty'];?>">
                                                <span class="input-group-btn input-group-append">
                                                    <button class="add_itm_qty btn btn-primary bootstrap-touchspin-up" type="button" data-action="1" data-product-id="<?php echo $item['id'];?>" data-rowid="<?php echo $item['rowid'];?>">+</button>
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
            <div class="view-title m-b90">
                <ul>
                    <li>
                        <h5>Total</h5>
                        <h5>€<?php echo $this->cart->total();?></h5>
                    </li>
                </ul>
            </div>
        </div>
		<div class="footer m-b90">
			<div class="container">
				<div class="footer-btn d-flex align-items-center">
					<a href="payment.html" class="btn btn-primary btn-rounded flex-1 ms-2">CONFIRM</a>
				</div>
			</div>
		</div>
    </div>
<!-- Page content End-->