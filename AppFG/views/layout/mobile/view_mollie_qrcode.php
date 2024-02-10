    <!-- Page Content -->
    <div class="page-content m-t70">
        <div class="container fb">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-0 pb-0">
                            <h5 class="card-title">Please make the payment</h5>
                        </div>
                        <div class="card-body">
                            <img src="<?php echo $QRcode;?>" alt="payment">
                            <div class="me-2 mb-2 d-flex align-items-center text-primary">
                                PENDING PAYMENT
                                <span class="spinner-border m-l10 me-3 spinner-border-sm" role="status" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="card-footer border-0 pt-0">
                            <p class="card-text d-inline">Please scan the QR code with your phone's camera and pay</p>
                            <a href="<?php echo $link;?>" target="_blank" class="card-link float-end">link</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Content End -->


    <script>
        setInterval(() => {
            $.ajax({
                url: "<?php echo base_url('mobile/mollie/check-order/'.$order_number);?>",
                type: "GET",
                contentType: false, // Using FormData, no need to process data.

                beforeSend: function () {},
                success: function (res) {
                    var payment_id = JSON.parse(res).res.transaction_id;
                    if(payment_id) {
                        $.ajax({
                            url: "<?php echo base_url('mobile/mollie/check-payment/');?>"+payment_id,
                            type: "get",
                            success: function (res) {
                                if(JSON.parse(res).status === 'paid') {
                                    window.location.href = '<?php echo base_url('mobile/mollie/success/'.$order_number);?>';
                                }
                            }
                        });
                    } else {
                        console.log('error');
                        // window.location.href = 'mobile/home/';
                    }
                },
                complete: function (res) {
                    // window.location.href = base_url + "mobile/order/upload-success";
                },
                error: function () {
                    console.log("An error occurred, the files couldn't be sent!");
                },
            });
        }, 1000);

        
    </script>