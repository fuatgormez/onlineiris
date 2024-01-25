<section class="content-header">
    <div class="content-header-left">
        <h1>View Ads Last 250 Log</h1>
    </div>
    <div class="content-header-right">
    </div>
</section>

<section class="content">
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

            <?php if ($this->session->flashdata('warning')) : ?>
                <div class="callout callout-warning">
                    <p><?php echo $this->session->flashdata('warning'); ?></p>
                </div>
            <?php endif; ?>


            <div class="box box-info">
                <div class="box-body table-responsive">
                    <?php foreach ($ads_logs as $key => $row) : ?>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-blue"><i class="fa fa-store"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?php echo $row['platform'];?></span>
                                    <span class="info-box-text">Event Name: <?php echo $row['event_name'] .' - '. $row['created_at'];?></span>
                                    <span class="info-box-text">Pixel: <?php echo $row['tracking_id'];?></span>
                                    <span class="info-box-text">Token: <?php echo $row['token'];?></span>
                                    <textarea rows="1" style="width: 429px; height: 129px;">Payload: <?php echo $row['payload'];?></textarea>
                                    
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>