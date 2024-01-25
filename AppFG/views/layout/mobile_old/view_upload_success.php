    <!-- Page Content -->
    <div class="page-content m-t70">
        <div class="container fb">
            <div class="row">
                <div class="col-12">
                    <div class="card bg-light">
                        <div class="card-header d-flex">
                            <h5 class="card-title">Success</h5>
                            <h5 class="card-title">Order Number #<?php echo $order['order_number'];?></h5>
                        </div>
                        <div class="card-body mb-0">
                            <p class="card-text">Your image has been uploaded successfully!</a>
                        </div>
                        <div class="card-footer bg-transparent border-0">-</div>
                    </div>
                    </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Uploaded Images </h4>
                </div>
                <div class="card-body">
                    <div class="dz-lightgallery row g-2" id="lightgallery">
                        <?php foreach($order_image as $image):?>
                            <a class="col-6" href="#">
                                <img src="<?php echo base_url($image['path'].'/'.$image['image']);?>" alt="image">
                            </a>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Content End -->