	<!-- Page Content -->
	<div class="page-content">
		<div class="container bottom-content"> 
			<div class="serach-area m-t90"> 
                <div class="order-status">
                    <h5 class="title mb-2">Order ID #<?php echo $order_number;?></h5>
                    <div class="tag-status">
                        <span class="badge text-secondary style-1">ON DELIVERY</span>
                        <a href="<?php echo base_url('mobile/order/tracking/'.$order_number);?>" class="btn-link text-underline">Track Location</a>
                    </div>
					<div class="mt-3 mb-5">
						<div class="saprater"></div>
						<p class="mt-3"><?php echo $order['billing_firstname'] .' '. $order['billing_lastname'];?></p>
					</div>
                </div>

				<div class="item-list style-2 recent-jobs-list">
					<ul>
						<?php foreach($order_item as $item):?>
						<li>
                            <div class="item-content">
                                <div class="item-media media media-60">
                                    <img src="<?php echo base_url('public/uploads/product_photos/thumbnail/'.$item['item_image']);?>" alt="">
                                </div>
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <h6 class="item-title"><a href="#"><?php echo $item['item_name'];?></a></h6>
                                    </div>
                                    <div class="item-footer">
                                        <div class="d-flex align-items-center">
                                            <h6 class="me-3">€ <?php echo $item['item_price'];?></h6>
                                        </div>
                                        <span><?php echo $item['item_qty'];?>x</span>
                                    </div>
                                </div>
                            </div>
                        </li>
						<?php endforeach;?>
                    </ul>
				</div>
				<!-- item List -->
				<div class="mt-3 text-end">
					<p class="title mt-3">Total: €<?php echo $order['total'];?></p>
				</div>
			</div>
		</div>
	</div>
    <!-- Page Content End-->