<section class="content-header">
    <div class="content-header-left">
        <h1>Settings Section</h1>
    </div>
</section>

<section class="content" style="min-height:auto;margin-bottom: -30px;">
    <div class="row">
        <div class="col-md-12">
            <?php if ($this->session->flashdata('error')) : ?>
                <div class="callout callout-danger">
                    <p><?php echo $this->session->flashdata('error'); ?></p>
                </div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('success')) : ?>
                <div class="callout callout-success">
                    <p><?php echo $this->session->flashdata('success'); ?></p>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<section class="content">

    <div class="row">
        <div class="col-md-12">

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_logo" data-toggle="tab">Logo</a></li>
                    <li><a href="#tab_favicon" data-toggle="tab">Favicon</a></li>
                    <li><a href="#tab_top_bar" data-toggle="tab">Top Bar</a></li>
                    <li><a href="#tab_head" data-toggle="tab">Head</a></li>
                    <li><a href="#tab_footer" data-toggle="tab">Footer</a></li>
                    <li><a href="#tab_email" data-toggle="tab">Email</a></li>
                    <li><a href="#tab_banner" data-toggle="tab">Banner</a></li>
                    <li><a href="#tab_sidebar" data-toggle="tab">Sidebar</a></li>
                    <li><a href="#tab_layout" data-toggle="tab">Layout</a></li>
                    <?php if ($this->session->userdata('role') === "Superadmin") : ?>
                        <li><a href="#tab_settings_order_status" data-toggle="tab">Order Status Settings</a></li>
                    <?php endif; ?>
                    <li><a href="#tab_payment_settings" data-toggle="tab">Payment Settings</a></li>
                    <li><a href="#tab_website_settings" data-toggle="tab">Website Settings</a></li>
                    <li><a href="#tab_frontend_shop_body" data-toggle="tab">Frontend Shop</a></li>
                    <li><a href="#tab_frontend_shop_advertisement" data-toggle="tab">Advertisement</a></li>
                </ul>

                <div class="tab-content">
                    <!-- Logo Start -->
                    <div class="tab-pane active" id="tab_logo">
                        <?php echo form_open_multipart(base_url() . 'backend/admin/setting/update', array('class' => 'form-horizontal')); ?>
                        <div class="box box-info">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">Existing Photo</label>
                                    <div class="col-sm-6" style="padding-top:6px;">
                                        <img src="<?php echo base_url(); ?>public/uploads/<?php echo $setting['logo']; ?>" class="existing-photo" style="height:80px;">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">New Photo</label>
                                    <div class="col-sm-6" style="padding-top:6px;">
                                        <input type="file" name="photo_logo">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-success pull-left" name="form_logo">Update Logo</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <!-- Logo End -->
                    <!-- Favicon Start -->
                    <div class="tab-pane" id="tab_favicon">
                        <?php echo form_open_multipart(base_url() . 'backend/admin/setting/update', array('class' => 'form-horizontal')); ?>
                        <div class="box box-info">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">Existing Photo</label>
                                    <div class="col-sm-6" style="padding-top:6px;">
                                        <img src="<?php echo base_url(); ?>public/uploads/<?php echo $setting['favicon']; ?>" class="existing-photo" style="height:40px;">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">New Photo</label>
                                    <div class="col-sm-6" style="padding-top:6px;">
                                        <input type="file" name="photo_favicon">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-success pull-left" name="form_favicon">Update Favicon</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <!-- Favicon End -->
                    <!-- Top Bar Start -->
                    <div class="tab-pane" id="tab_top_bar">
                        <?php echo form_open(base_url() . 'backend/admin/setting/update', array('class' => 'form-horizontal', 'name' => 'form_top_bar')); ?>
                        <div class="box box-info">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Sitename </label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="sitename" value="<?php echo $setting['sitename']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Top Bar Email </label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="top_bar_email" value="<?php echo $setting['top_bar_email']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Top Bar Email Text</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="top_bar_email_text" value="<?php echo $setting['top_bar_email_text']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Top Bar Phone Number </label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="top_bar_phone" value="<?php echo $setting['top_bar_phone']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Top Bar Phone Text </label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="top_bar_phone_text" value="<?php echo $setting['top_bar_phone_text']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-success pull-left ajax_request">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <!-- Top Bar End -->
                    <!-- Head Start -->
                    <div class="tab-pane" id="tab_head">
                        <?php echo form_open(base_url() . 'backend/admin/setting/update', array('class' => 'form-horizontal', 'name' => 'form_frontend_head')); ?>
                        <h3 class="sec_title" style="margin-top:0px;"> Head </h3>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Head Tags ... </label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="frontend_head" style="height:470px;"><?php echo $setting['frontend_head']; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left ajax_request">Update</button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <!-- Head End -->
                    <!-- Footer Start -->
                    <div class="tab-pane" id="tab_footer">
                        <?php echo form_open(base_url('backend/admin/setting/update'), array('class' => 'form-horizontal')); ?>
                        <h3 class="sec_title" style="margin-top:0px;">General Section</h3>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Column 1 Title </label>
                            <div class="col-sm-6">
                                <input class="form-control" type="text" name="footer_col1_title" value="<?php echo $setting['footer_col1_title']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Column 2 Title </label>
                            <div class="col-sm-6">
                                <input class="form-control" type="text" name="footer_col2_title" value="<?php echo $setting['footer_col2_title']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Column 3 Title </label>
                            <div class="col-sm-6">
                                <input class="form-control" type="text" name="footer_col3_title" value="<?php echo $setting['footer_col3_title']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Column 4 Title </label>
                            <div class="col-sm-6">
                                <input class="form-control" type="text" name="footer_col4_title" value="<?php echo $setting['footer_col4_title']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Footer - Copyright </label>
                            <div class="col-sm-6">
                                <input class="form-control" type="text" name="footer_copyright" value="<?php echo $setting['footer_copyright']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Footer Address </label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="footer_address" style="height:70px;"><?php echo $setting['footer_address']; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Footer Email </label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="footer_email" style="height:70px;"><?php echo $setting['footer_email']; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Footer Phone </label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="footer_phone" style="height:70px;"><?php echo $setting['footer_phone']; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Number of Recent News </label>
                            <div class="col-sm-6">
                                <input class="form-control" type="text" name="footer_recent_news_item" value="<?php echo $setting['footer_recent_news_item']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Number of Recent Portfolios </label>
                            <div class="col-sm-6">
                                <input class="form-control" type="text" name="footer_recent_portfolio_item" value="<?php echo $setting['footer_recent_portfolio_item']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form_footer_general">Update</button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>



                        <?php echo form_open_multipart(base_url() . 'backend/admin/setting/update', array('class' => 'form-horizontal')); ?>
                        <h3 class="sec_title">Newsletter Section</h3>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Newsletter Text </label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="newsletter_text" style="height:70px;"><?php echo $setting['newsletter_text']; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form_footer_newsletter">Update</button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>



                        <?php echo form_open_multipart(base_url() . 'backend/admin/setting/update', array('class' => 'form-horizontal')); ?>
                        <h3 class="sec_title">Call To Action Section</h3>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">CTA Text </label>
                            <div class="col-sm-6">
                                <textarea name="cta_text" class="form-control" cols="30" rows="10" style="height:80px;"><?php echo $setting['cta_text']; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">CTA Button Text </label>
                            <div class="col-sm-6">
                                <input type="text" name="cta_button_text" class="form-control" value="<?php echo $setting['cta_button_text']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">CTA Button URL </label>
                            <div class="col-sm-6">
                                <input type="text" name="cta_button_url" class="form-control" value="<?php echo $setting['cta_button_url']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form_footer_cta">Update</button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>




                        <?php echo form_open_multipart(base_url() . 'backend/admin/setting/update', array('class' => 'form-horizontal')); ?>
                        <h3 class="sec_title" style="margin-top:0px;">Call To Action Background Photo</h3>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Existing Photo 1300x868</label>
                            <div class="col-sm-6">
                                <img src="<?php echo base_url(); ?>public/uploads/<?php echo $setting['cta_background']; ?>" alt="" style="width:300px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">New Photo </label>
                            <div class="col-sm-6">
                                <input type="file" name="photo" style="padding-top:5px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form_footer_cta_background">Update</button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>


                        <?php echo form_open_multipart(base_url() . 'backend/admin/setting/update', array('class' => 'form-horizontal')); ?>
                        <h3 class="sec_title" style="margin-top:0px;">Footer Background Photo</h3>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Existing Photo 1680x484</label>
                            <div class="col-sm-6">
                                <img src="<?php echo base_url(); ?>public/uploads/<?php echo $setting['footer_background']; ?>" alt="" style="width:300px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">New Photo </label>
                            <div class="col-sm-6">
                                <input type="file" name="photo" style="padding-top:5px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form_footer_background">Update</button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>


                        <?php echo form_open_multipart(base_url() . 'backend/admin/setting/update', array('class' => 'form-horizontal')); ?>
                        <h3 class="sec_title" style="margin-top:0px;">Footer Zoho Live Chat</h3>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Live Zoho Chat Display</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="footer_zoho_live_chat_display">
                                    <option <?php echo $setting['footer_zoho_live_chat_display'] === "Show" ? 'selected' : ''; ?>>Show</option>
                                    <option <?php echo $setting['footer_zoho_live_chat_display'] === "Hide" ? 'selected' : ''; ?>>Hide</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Widgetcode </label>
                            <div class="col-sm-6">
                                <input class="form-control" name="footer_zoho_live_chat" value="<?php echo $setting['footer_zoho_live_chat']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form_footer_zoho_live_chat">Update</button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <!-- Footer End -->
                    <!-- Email Start -->
                    <div class="tab-pane" id="tab_email">
                        <?php echo form_open(base_url('backend/admin/setting/update'), array('class' => 'form-horizontal', 'name' => 'form_email')); ?>
                        <div class="box box-info">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Send Email From <span>*</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="send_email_from" maxlength="255" autocomplete="off" value="<?php echo $setting['send_email_from']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Receive Email To <span>*</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="receive_email_to" maxlength="255" autocomplete="off" value="<?php echo $setting['receive_email_to']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-success pull-left ajax_request">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <!-- Email End -->
                    <!-- Banner Start -->
                    <div class="tab-pane" id="tab_banner">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <?php echo form_open_multipart(base_url() . 'backend/admin/setting/update', array('class' => '')); ?>
                                        <td style="width:50%">
                                            <h4>Home Page</h4>
                                            <p>
                                                <img src="<?php echo base_url('public/uploads/') . $setting['banner_home']; ?>" alt="" style="width: 100%;height:auto;">
                                            </p>
                                        </td>
                                        <td style="width:50%">
                                            <h4>Change Banner</h4>
                                            Select Photo 1350x299px<input type="file" name="photo">
                                            <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form_banner_home">
                                        </td>
                                        <?php echo form_close(); ?>
                                    </tr>
                                    <tr>
                                        <?php echo form_open_multipart(base_url() . 'backend/admin/setting/update', array('class' => '')); ?>
                                        <td style="width:50%">
                                            <h4>Shop Page</h4>
                                            <p>
                                                <img src="<?php echo base_url('public/uploads/') . $setting['banner_shop']; ?>" alt="" style="width: 100%;height:auto;">
                                            </p>
                                        </td>
                                        <td style="width:50%">
                                            <h4>Change Banner</h4>
                                            Select Photo 1350x299px<input type="file" name="photo">
                                            <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form_banner_shop">
                                        </td>
                                        <?php echo form_close(); ?>
                                    </tr>
                                    <tr>
                                        <?php echo form_open_multipart(base_url() . 'backend/admin/setting/update', array('class' => '')); ?>
                                        <td style="width:50%">
                                            <h4>About Page</h4>
                                            <p>
                                                <img src="<?php echo base_url('public/uploads/') . $setting['banner_about']; ?>" alt="" style="width: 100%;height:auto;">
                                            </p>
                                        </td>
                                        <td style="width:50%">
                                            <h4>Change Banner</h4>
                                            Select Photo 1350x299px<input type="file" name="photo">
                                            <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form_banner_about">
                                        </td>
                                        <?php echo form_close(); ?>
                                    </tr>

                                    <tr>
                                        <?php echo form_open_multipart(base_url() . 'backend/admin/setting/update', array('class' => '')); ?>
                                        <td style="width:50%">
                                            <h4>Job Page</h4>
                                            <p>
                                                <img src="<?php echo base_url('public/uploads/') . $setting['banner_job']; ?>" alt="" style="width: 100%;height:auto;">
                                            </p>
                                        </td>
                                        <td style="width:50%">
                                            <h4>Change Banner</h4>
                                            Select Photo 1350x299px<input type="file" name="photo">
                                            <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form_banner_job">
                                        </td>
                                        <?php echo form_close(); ?>
                                    </tr>

                                    <tr>
                                        <?php echo form_open_multipart(base_url() . 'backend/admin/setting/update', array('class' => '')); ?>
                                        <td style="width:50%">
                                            <h4>Testimonial Page</h4>
                                            <p>
                                                <img src="<?php echo base_url('public/uploads/') . $setting['banner_testimonial']; ?>" alt="" style="width: 100%;height:auto;">
                                            </p>
                                        </td>
                                        <td style="width:50%">
                                            <h4>Change Banner</h4>
                                            Select Photo 1350x299px<input type="file" name="photo">
                                            <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form_banner_testimonial">
                                        </td>
                                        <?php echo form_close(); ?>
                                    </tr>
                                    <tr>
                                        <?php echo form_open_multipart(base_url() . 'backend/admin/setting/update', array('class' => '')); ?>
                                        <td style="width:50%">
                                            <h4>News Page</h4>
                                            <p>
                                                <img src="<?php echo base_url('public/uploads/') . $setting['banner_news']; ?>" alt="" style="width: 100%;height:auto;">
                                            </p>
                                        </td>
                                        <td style="width:50%">
                                            <h4>Change Banner</h4>
                                            Select Photo 1350x299px<input type="file" name="photo">
                                            <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form_banner_news">
                                        </td>
                                        <?php echo form_close(); ?>
                                    </tr>
                                    <tr>
                                        <?php echo form_open_multipart(base_url() . 'backend/admin/setting/update', array('class' => '')); ?>
                                        <td style="width:50%">
                                            <h4>Event Page</h4>
                                            <p>
                                                <img src="<?php echo base_url('public/uploads/') . $setting['banner_event']; ?>" alt="" style="width: 100%;height:auto;">
                                            </p>
                                        </td>
                                        <td style="width:50%">
                                            <h4>Change Banner</h4>
                                            Select Photo 1350x299px<input type="file" name="photo">
                                            <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form_banner_event">
                                        </td>
                                        <?php echo form_close(); ?>
                                    </tr>
                                    <tr>
                                        <?php echo form_open_multipart(base_url() . 'backend/admin/setting/update', array('class' => '')); ?>
                                        <td style="width:50%">
                                            <h4>Contact Page</h4>
                                            <p>
                                                <img src="<?php echo base_url('public/uploads/') . $setting['banner_contact']; ?>" alt="" style="width: 100%;height:auto;">
                                            </p>
                                        </td>
                                        <td style="width:50%">
                                            <h4>Change Banner</h4>
                                            Select Photo 1350x299px<input type="file" name="photo">
                                            <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form_banner_contact">
                                        </td>
                                        <?php echo form_close(); ?>
                                    </tr>
                                    <tr>
                                        <?php echo form_open_multipart(base_url() . 'backend/admin/setting/update', array('class' => '')); ?>
                                        <td style="width:50%">
                                            <h4>Search Page</h4>
                                            <p>
                                                <img src="<?php echo base_url('public/uploads/') . $setting['banner_search']; ?>" alt="" style="width: 100%;height:auto;">
                                            </p>
                                        </td>
                                        <td style="width:50%">
                                            <h4>Change Banner</h4>
                                            Select Photo 1350x299px<input type="file" name="photo">
                                            <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form_banner_search">
                                        </td>
                                        <?php echo form_close(); ?>
                                    </tr>

                                    <tr>
                                        <?php echo form_open_multipart(base_url() . 'backend/admin/setting/update', array('class' => '')); ?>
                                        <td style="width:50%">
                                            <h4>Privacy Page</h4>
                                            <p>
                                                <img src="<?php echo base_url('public/uploads/') . $setting['banner_privacy']; ?>" alt="" style="width: 100%;height:auto;">
                                            </p>
                                        </td>
                                        <td style="width:50%">
                                            <h4>Change Banner</h4>
                                            Select Photo 1350x299px<input type="file" name="photo">
                                            <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form_banner_privacy">
                                        </td>
                                        <?php echo form_close(); ?>
                                    </tr>
                                    <tr>
                                        <?php echo form_open_multipart(base_url() . 'backend/admin/setting/update', array('class' => '')); ?>
                                        <td style="width:50%">
                                            <h4>Verify Subscriber Page</h4>
                                            <p>
                                                <img src="<?php echo base_url('public/uploads/') . $setting['banner_verify_subscriber']; ?>" alt="" style="width: 100%;height:auto;">
                                            </p>
                                        </td>
                                        <td style="width:50%">
                                            <h4>Change Banner</h4>
                                            Select Photo 1350x299px<input type="file" name="photo">
                                            <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form_banner_verify_subscriber">
                                        </td>
                                        <?php echo form_close(); ?>
                                    </tr>

                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <?php echo form_open_multipart(base_url() . 'backend/admin/setting/update', array('class' => '')); ?>
                                        <td style="width:50%">
                                            <h4>FAQ Page</h4>
                                            <p>
                                                <img src="<?php echo base_url('public/uploads/') . $setting['banner_faq']; ?>" alt="" style="width: 100%;height:auto;">
                                            </p>
                                        </td>
                                        <td style="width:50%">
                                            <h4>Change Banner</h4>
                                            Select Photo 1350x299px<input type="file" name="photo">
                                            <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form_banner_faq">
                                        </td>
                                        <?php echo form_close(); ?>
                                    </tr>

                                    <tr>
                                        <?php echo form_open_multipart(base_url() . 'backend/admin/setting/update', array('class' => '')); ?>
                                        <td style="width:50%">
                                            <h4>Service Page</h4>
                                            <p>
                                                <img src="<?php echo base_url('public/uploads/') . $setting['banner_service']; ?>" alt="" style="width: 100%;height:auto;">
                                            </p>
                                        </td>
                                        <td style="width:50%">
                                            <h4>Change Banner</h4>
                                            Select Photo 1350x299px<input type="file" name="photo">
                                            <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form_banner_service">
                                        </td>
                                        <?php echo form_close(); ?>
                                    </tr>

                                    <tr>
                                        <?php echo form_open_multipart(base_url() . 'backend/admin/setting/update', array('class' => '')); ?>
                                        <td style="width:50%">
                                            <h4>Portfolio Page</h4>
                                            <p>
                                                <img src="<?php echo base_url('public/uploads/') . $setting['banner_portfolio']; ?>" alt="" style="width: 100%;height:auto;">
                                            </p>
                                        </td>
                                        <td style="width:50%">
                                            <h4>Change Banner</h4>
                                            Select Photo 1350x299px<input type="file" name="photo">
                                            <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form_banner_portfolio">
                                        </td>
                                        <?php echo form_close(); ?>
                                    </tr>
                                    <tr>
                                        <?php echo form_open_multipart(base_url() . 'backend/admin/setting/update', array('class' => '')); ?>
                                        <td style="width:50%">
                                            <h4>Team Page</h4>
                                            <p>
                                                <img src="<?php echo base_url('public/uploads/') . $setting['banner_team']; ?>" alt="" style="width: 100%;height:auto;">
                                            </p>
                                        </td>
                                        <td style="width:50%">
                                            <h4>Change Banner</h4>
                                            Select Photo 1350x299px<input type="file" name="photo">
                                            <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form_banner_team">
                                        </td>
                                        <?php echo form_close(); ?>
                                    </tr>
                                    <tr>
                                        <?php echo form_open_multipart(base_url() . 'backend/admin/setting/update', array('class' => '')); ?>
                                        <td style="width:50%">
                                            <h4>Pricing Page</h4>
                                            <p>
                                                <img src="<?php echo base_url('public/uploads/') . $setting['banner_pricing']; ?>" alt="" style="width: 100%;height:auto;">
                                            </p>
                                        </td>
                                        <td style="width:50%">
                                            <h4>Change Banner</h4>
                                            Select Photo 1350x299px<input type="file" name="photo">
                                            <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form_banner_pricing">
                                        </td>
                                        <?php echo form_close(); ?>
                                    </tr>
                                    <tr>
                                        <?php echo form_open_multipart(base_url() . 'backend/admin/setting/update', array('class' => '')); ?>
                                        <td style="width:50%">
                                            <h4>Photo Gallery Page</h4>
                                            <p>
                                                <img src="<?php echo base_url('public/uploads/') . $setting['banner_photo_gallery']; ?>" alt="" style="width: 100%;height:auto;">
                                            </p>
                                        </td>
                                        <td style="width:50%">
                                            <h4>Change Banner</h4>
                                            Select Photo 1350x299px<input type="file" name="photo">
                                            <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form_banner_photo_gallery">
                                        </td>
                                        <?php echo form_close(); ?>
                                    </tr>
                                    <tr>
                                        <?php echo form_open_multipart(base_url() . 'backend/admin/setting/update', array('class' => '')); ?>
                                        <td style="width:50%">
                                            <h4>Select Land Page</h4>
                                            <p>
                                                <img src="<?php echo base_url('public/uploads/') . $setting['banner_select_land']; ?>" alt="" style="width: 100%;height:auto;">
                                            </p>
                                        </td>
                                        <td style="width:50%">
                                            <h4>Change Banner</h4>
                                            Select Photo 1600x533px<input type="file" name="photo">
                                            <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form_banner_select_land">
                                        </td>
                                        <?php echo form_close(); ?>
                                    </tr>
                                    <tr>
                                        <?php echo form_open_multipart(base_url() . 'backend/admin/setting/update', array('class' => '')); ?>
                                        <td style="width:50%">
                                            <h4>Terms Page</h4>
                                            <p>
                                                <img src="<?php echo base_url('public/uploads/') . $setting['banner_terms']; ?>" alt="" style="width: 100%;height:auto;">
                                            </p>
                                        </td>
                                        <td style="width:50%">
                                            <h4>Change Banner</h4>
                                            Select Photo 1350x299px<input type="file" name="photo">
                                            <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form_banner_terms">
                                        </td>
                                        <?php echo form_close(); ?>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Banner End -->
                    <!-- Sidebar Start -->
                    <div class="tab-pane" id="tab_sidebar">
                        <?php echo form_open(base_url() . 'backend/admin/setting/update', array('class' => 'form-horizontal', 'name' => 'form_sidebar')); ?>
                        <div class="box box-info">
                            <div class="box-body">
                                <h3 class="sec_title" style="margin-top:0;">News Page - Sidebar Section</h3>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Total Recent Posts <span>*</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="sidebar_total_recent_post" maxlength="255" autocomplete="off" value="<?php echo $setting['sidebar_total_recent_post']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Heading - Category <span>*</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="sidebar_news_heading_category" maxlength="255" autocomplete="off" value="<?php echo $setting['sidebar_news_heading_category']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Heading - Recent Post <span>*</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="sidebar_news_heading_recent_post" maxlength="255" autocomplete="off" value="<?php echo $setting['sidebar_news_heading_recent_post']; ?>">
                                    </div>
                                </div>

                                <h3 class="sec_title">Event Page - Sidebar Section</h3>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Total Upcoming Events <span>*</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="sidebar_total_upcoming_event" maxlength="255" autocomplete="off" value="<?php echo $setting['sidebar_total_upcoming_event']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Total Past Events <span>*</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="sidebar_total_past_event" maxlength="255" autocomplete="off" value="<?php echo $setting['sidebar_total_past_event']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Heading - Upcoming Event <span>*</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="sidebar_event_heading_upcoming" maxlength="255" autocomplete="off" value="<?php echo $setting['sidebar_event_heading_upcoming']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Heading - Past Event <span>*</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="sidebar_event_heading_past" maxlength="255" autocomplete="off" value="<?php echo $setting['sidebar_event_heading_past']; ?>">
                                    </div>
                                </div>
                                <h3 class="sec_title">Service Single Page - Sidebar Section</h3>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Heading - Our Services <span>*</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="sidebar_service_heading_service" maxlength="255" autocomplete="off" value="<?php echo $setting['sidebar_service_heading_service']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Heading - Quick Contact <span>*</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="sidebar_service_heading_quick_contact" maxlength="255" autocomplete="off" value="<?php echo $setting['sidebar_service_heading_quick_contact']; ?>">
                                    </div>
                                </div>
                                <h3 class="sec_title">Portfolio Single Page - Sidebar Section</h3>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Heading - Project Detail <span>*</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="sidebar_portfolio_heading_project_detail" maxlength="255" autocomplete="off" value="<?php echo $setting['sidebar_portfolio_heading_project_detail']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Heading - Quick Contact <span>*</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="sidebar_portfolio_heading_quick_contact" maxlength="255" autocomplete="off" value="<?php echo $setting['sidebar_portfolio_heading_quick_contact']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-success pull-left ajax_request">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <!-- Sidebar End -->
                    <!-- Layout Start -->
                    <div class="tab-pane" id="tab_layout">
                        <?php echo form_open(base_url() . 'backend/admin/setting/update', array('class' => 'form-horizontal', 'name' => 'form_layout')); ?>
                        <div class="box box-info">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">Layout name</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="front_end_layout" class="form-control" value="<?php echo $setting['layout']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-success pull-left ajax_request">update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <!-- Layout End -->
                    <!-- Order Status Setting Start -->
                    <div class="tab-pane" id="tab_settings_order_status">
                        <?php echo form_open(base_url() . 'backend/admin/setting/update', array('class' => 'form-horizontal', 'name' => 'form_settings_order_status')); ?>
                        <div class="box box-info">
                            <div class="box-body">
                                <h3 class="sec_title">Order Status Setting</h3>
                                <?php foreach ($setting_shop_order_status as $row_setting_shop_order_status) : ?>
                                    <div class="form-group">
                                        <div class="col-sm-2">
                                            <input type="text" name="text[<?php echo $row_setting_shop_order_status['id']; ?>]" class="form-control" value="<?php echo $row_setting_shop_order_status['text']; ?>">
                                        </div>
                                        <label for="" class="col-sm-1 control-label">Color</label>
                                        <div class="col-sm-1">
                                            <input type="text" name="color[<?php echo $row_setting_shop_order_status['id']; ?>]" class="form-control jscolor" value="<?php echo $row_setting_shop_order_status['color']; ?>">
                                        </div>

                                        <label for="" class="col-sm-1 control-label">Status</label>
                                        <div class="col-sm-1">
                                            <input type="text" name="status[<?php echo $row_setting_shop_order_status['id']; ?>]" class="form-control" value="<?php echo $row_setting_shop_order_status['status']; ?>">
                                        </div>

                                        <label for="" class="col-sm-1 control-label">Row</label>
                                        <div class="col-sm-1">
                                            <input type="text" name="row[<?php echo $row_setting_shop_order_status['id']; ?>]" class="form-control" value="<?php echo $row_setting_shop_order_status['row']; ?>">
                                        </div>

                                        <label for="" class="col-sm-1 control-label">Role</label>
                                        <div class="col-sm-3">
                                            <?php $explode_roles = json_decode($row_setting_shop_order_status['role']); ?>
                                            <select name="role[<?php echo $row_setting_shop_order_status['id']; ?>][]" class="form-control select2" multiple="multiple">
                                                <?php $explode_roles = json_decode($row_setting_shop_order_status['role']); ?>

                                                <?php foreach ($user_group as $row_user_group) : ?>
                                                    <?php if (in_array($row_user_group['value'], $explode_roles)) : ?>
                                                        <option value="<?php echo $row_user_group['value']; ?>" selected> <?php echo $row_user_group['name']; ?></option>
                                                    <?php else : ?>
                                                        <option value="<?php echo $row_user_group['value']; ?>"> <?php echo $row_user_group['name']; ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                <?php endforeach; ?>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-block btn-success pull-left ajax_request">update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <!-- Order Status Setting End -->
                    <!-- Payment Settings Start -->
                    <div class="tab-pane" id="tab_payment_settings">
                        <?php echo form_open(base_url() . 'backend/admin/setting/update', array('class' => 'form-horizontal', 'name' => 'form_payment_settings')); ?>
                        <div class="box box-info">
                            <div class="box-body">
                                <h3 class="sec_title">Mollie</h3>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Description</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="mollie_description" class="form-control" value="<?php echo $setting_shop['mollie_description']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Test key</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="mollie_test_key" class="form-control" value="<?php echo $setting_shop['mollie_test_key']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Live key</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="mollie_live_key" class="form-control" value="<?php echo $setting_shop['mollie_live_key']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Current key</label>
                                    <div class="col-sm-4">
                                        <select name="mollie_current_key" class="form-control">
                                            <option value="test" <?php echo $setting_shop['mollie_current_key'] === "test" ? 'selected' : ''; ?>>Test</option>
                                            <option value="live" <?php echo $setting_shop['mollie_current_key'] === "live" ? 'selected' : ''; ?>>Live</option>
                                        </select>
                                    </div>
                                </div>
                                <h3 class="sec_title">Paypal</h3>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Paypal Email</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="paypal_email" class="form-control" value="<?php echo $setting_shop['paypal_email']; ?>">
                                    </div>
                                </div>
                                <h3 class="sec_title">Stripe</h3>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Public key</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="stripe_public_key" class="form-control" value="<?php echo $setting_shop['stripe_public_key']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Secret key</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="stripe_secret_key" class="form-control" value="<?php echo $setting_shop['stripe_secret_key']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Current key</label>
                                    <div class="col-sm-4">
                                        <select name="stripe_current_key" class="form-control">
                                            <option value="test" <?php echo $setting_shop['stripe_current_key'] === "test" ? 'selected' : ''; ?>>Test</option>
                                            <option value="live" <?php echo $setting_shop['stripe_current_key'] === "live" ? 'selected' : ''; ?>>Live</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-success pull-left ajax_request">update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <!-- Payment Setting End -->
                    <!-- Website Setting Start -->
                    <div class="tab-pane" id="tab_website_settings">
                        <?php echo form_open(base_url() . 'backend/admin/setting/update', array('class' => 'form-horizontal', 'name' => 'form_website_status')); ?>
                        <div class="box box-info">
                            <div class="box-body">
                                <h3 class="sec_title">Website Status Backend</h3>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Status</label>
                                    <div class="col-sm-4">
                                        <select name="website_status_backend" class="form-control">
                                            <option value="Active" <?php echo $setting['website_status_backend'] === "Active" ? 'selected' : ''; ?>>Active</option>
                                            <option value="Passive" <?php echo $setting['website_status_backend'] === "Passive" ? 'selected' : ''; ?>>Passive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Message</label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" name="website_status_backend_message" id="editor1" style="height:70px;"><?php echo $setting['website_status_backend_message']; ?></textarea>
                                    </div>
                                </div>

                                <h3 class="sec_title">Website Status Frontend</h3>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Status</label>
                                    <div class="col-sm-4">
                                        <select name="website_status_frontend" class="form-control">
                                            <option value="Active" <?php echo $setting['website_status_frontend'] === "Active" ? 'selected' : ''; ?>>Active</option>
                                            <option value="Passive" <?php echo $setting['website_status_frontend'] === "Passive" ? 'selected' : ''; ?>>Passive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Message</label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" name="website_status_frontend_message" id="editor2" style="height:70px;"><?php echo $setting['website_status_frontend_message']; ?></textarea>
                                    </div>
                                </div>
                                
                                <h3 class="sec_title">Website Status Mobile</h3>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Status</label>
                                    <div class="col-sm-4">
                                        <select name="website_status_mobile" class="form-control">
                                            <option value="Active" <?php echo $setting['website_status_mobile'] === "Active" ? 'selected' : ''; ?>>Active</option>
                                            <option value="Passive" <?php echo $setting['website_status_mobile'] === "Passive" ? 'selected' : ''; ?>>Passive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Message</label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" name="website_status_mobile_message" id="editor3" style="height:70px;"><?php echo $setting['website_status_mobile_message']; ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-success pull-left ajax_request">update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>

                        <?php echo form_open(base_url() . 'backend/admin/setting/update', array('class' => 'form-horizontal', 'name' => 'form_frontend_shop_countdown')); ?>
                        <div class="box box-info">
                            <div class="box-body">
                                <h3 class="sec_title">Frontend Shop Countdown</h3>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">id</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="frontend_shop_countdown_id" value="<?php echo $setting['frontend_shop_countdown_id']; ?>" placeholder="9dc65284_1562783100">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Link</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="frontend_shop_countdown_link" value="<?php echo $setting['frontend_shop_countdown_link']; ?>" placeholder="https://www.powr.io/powr.js?platform=jimdo">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Status</label>
                                    <div class="col-sm-4">
                                        <select name="frontend_shop_countdown_status" class="form-control">
                                            <option value="Show" <?php echo $setting['frontend_shop_countdown_status'] === "Show" ? 'selected' : ''; ?>>Show</option>
                                            <option value="Hide" <?php echo $setting['frontend_shop_countdown_status'] === "Hide" ? 'selected' : ''; ?>>Hide</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-success pull-left ajax_request">update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>

                        <?php echo form_open(base_url() . 'backend/admin/setting/update', array('class' => 'form-horizontal', 'name' => 'form_color')); ?>
                        <div class="box box-info">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Default color: #0050aa</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="front_end_color" class="form-control jscolor" value="<?php echo $setting['front_end_color']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Default Background color: #0050aa</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="front_end_background_color" class="form-control jscolor" value="<?php echo $setting['front_end_background_color']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-success pull-left ajax_request">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <!-- Website Setting End -->
                    <!-- Frontend Shop Body Start -->
                    <div class="tab-pane" id="tab_frontend_shop_body">
                        <?php echo form_open(base_url() . 'backend/admin/setting/update', array('class' => 'form-horizontal', 'name' => 'form_frontend_shop_body')); ?>
                        <div class="box box-info">
                            <div class="box-body">
                                <h3 class="sec_title">Frontend Shop body</h3>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <textarea class="form-control" name="frontend_shop_body" id="editor3"><?php echo $setting['frontend_shop_body']; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-block btn-success pull-left ajax_request">update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <!-- Frontend Shop Body End -->
                    <!-- Frontend Shop Advertisement Start -->
                    <div class="tab-pane" id="tab_frontend_shop_advertisement">
                        <?php echo form_open(base_url() . 'backend/admin/setting/update', array('class' => 'form-horizontal', 'name' => 'form_frontend_shop_advertisement')); ?>
                        <div class="box box-info">
                            <div class="box-body">
                                <h3 class="sec_title">Frontend Shop Advertisement Facebook</h3>
                                <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Facebook init (pixel id)</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="facebook_init" value="<?php echo $setting['facebook_init']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Facebook Access Token</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="facebook_access_token" value="<?php echo $setting['facebook_access_token']; ?>">
                                    </div>
                                </div>
                                <h3 class="sec_title">Frontend Shop Advertisement Tiktok</h3>
                                <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Tiktok Load</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="tiktok_load_code" value="<?php echo $setting['tiktok_load_code']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-block btn-success pull-left ajax_request">update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <!-- Frontend Shop Advertisement End -->
                </div>
            </div>
        </div>
    </div>
</section>