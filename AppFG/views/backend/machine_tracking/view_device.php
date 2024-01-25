<section class="content-header">
    <div class="content-header-left">
        <h1>View Devices <small class="text-danger">(This page is automatically refreshed every thirty seconds!)</small></h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url(); ?>backend/machine_tracking/device/add" class="btn btn-primary btn-sm">Add Device</a>
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

            <div class="box box-info">
                <div class="box-body table-responsive">
                    <table id="devicelist" class="content-table dataTable">
                        <thead>
                            <tr>
                                <th>Kiosk ID</th>
                                <th width="30">id</th>
                                <th>Location</th>
                                <th>Request</th>
                                <th>Version</th>
                            </tr>
                        </thead>
                        <tdbody>
                        </tdbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>