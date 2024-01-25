



    <!-- Page Content -->

    <div class="page-content m-t100">

        <div class="account-box">

            <div class="container">

                <div class="account-area m-b70">

					<form>

					   <div class="mb-3 input-group input-mini">

							<span class="input-group-text"><i class="fa-solid fa-mobile-screen-button"></i></span>

							<input type="text" class="form-control order_number" value="<?php echo $order_number;?>" placeholder="Enter Your Order Number">

						</div>

						<div class="input-group">

							<a href="#" class="btn mt-2 btn-primary w-100 btn-rounded find_order">Search</a>

						</div>

                        <?php if($this->session->userdata('id')):?>

						<div class="input-group">

                            <?php foreach($last_get_order as $row):?>

                            <a href="<?php echo base_url('mobile/order/upload-view/'.$row['order_number']);?>   " class="notification btn-block">

                                <div class="notification-content item-list">

                                    <div class="item-content">

                                        <div class="item-inner">

                                            <h6 class="title"><?php echo $row['billing_firstname'] .''. $row['billing_lastname'];?></h6>

                                            <p class="mb-0">Order number: <?php echo $row['order_number'];?></p>

                                        </div>

                                        <div class="ms-auto font-12 text-dark d-flex align-items-center">

                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">

                                                <path d="M6 11C8.76142 11 11 8.76142 11 6C11 3.23858 8.76142 1 6 1C3.23858 1 1 3.23858 1 6C1 8.76142 3.23858 11 6 11Z" stroke="#787878" stroke-linecap="round" stroke-linejoin="round"></path>

                                                <path d="M6 3V6L8 7" stroke="#787878" stroke-linecap="round" stroke-linejoin="round"></path>

                                            </svg>

                                            <?php echo $row['date_purchased'];?>

                                        </div>

                                    </div>

                                </div>

                            </a>

                            <?php endforeach;?>

						</div>

                        <?php endif;?>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <!-- Page Content End -->





    <div class="notification-for-upload"></div>



    <!-- Success Bar -->

    <div class="modal fade" tabindex="-1" id="exampleModal4"  aria-labelledby="exampleModal4" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-body text-center small p-4">

					<i class="fa fa-4x fa-check-circle text-success m-b15"></i>

					<h5 id="_order_number"></h5>

                    <p class="m-b0" id="_name"></p>

                </div>

            </div>

        </div>

    </div>