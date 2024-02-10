    <!-- Page Content -->
    <div class="page-content m-t90">
        <!-- Banner -->
        <div class="banner-wrapper shape-1">
            <div class="container inner-wrapper">
                <h2 class="dz-title">SMS Verify</h2>
                <p class="mb-0">Please enter your OTP</p>
            </div>
        </div>
        <!-- Banner End -->
        <div class="account-box">
            <div class="container">
                <div class="account-area">
                    <?php echo form_open(base_url('mobile/account/sms-confirm'), array('name' => 'sms_confirm'));?>
                        <div method="get" id="otp" class="digit-group" data-group-name="digits" data-autosubmit="false" autocomplete="off">
                            <input class="form-control" type="text" id="digit-1" name="digit-1" placeholder="-" data-next="digit-2" />
                            <input class="form-control" type="text" id="digit-2" name="digit-2" placeholder="-" data-next="digit-3" data-previous="digit-1" />
                            <input class="form-control" type="text" id="digit-3" name="digit-3" placeholder="-" data-next="digit-4" data-previous="digit-2" />
                            <input class="form-control" type="text" id="digit-4" name="digit-4" placeholder="-" data-next="digit-5" data-previous="digit-3" />
                            <input class="form-control" type="text" id="digit-5" name="digit-5" placeholder="-" data-next="digit-6" data-previous="digit-4" />
                            <input class="form-control" type="text" id="digit-6" name="digit-6" placeholder="-" data-previous="digit-5" />
                        </div>
                        <div class="input-group">
                            <button type="submit" class="btn mt-3 btn-primary w-100 btn-rounded" id="sms_confirm">VERIFY & PROCEED</button>
                        </div>
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Content End -->