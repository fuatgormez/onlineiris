<section class="content-header">
    <div class="content-header-left">
        <h1>View Mollie Last 50 Payments</h1>
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
                    <table id="example1" class="content-table dataTable">
                        <thead>
                            <tr>
                                <th>Datum</th>
                                <th>Methode</th>
                                <th>Betrag</th>
                                <th>Status</th>
                                <th>Details</th>
                                <th>Transaktion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($payments as $key => $row) : ?>
                                <?php if ($row->description === "IRISPICTURE") : ?><?php endif; ?>
                                    <tr onclick="window.location='<?php echo base_url('backend/shop/mollie/detail/'.$row->id);?>';" style="cursor:pointer">
                                        <td><?php echo date('d-m-Y H:i:s', strtotime($row->createdAt)); ?></td>
                                        <td><?php echo $row->method; ?></td>
                                        <td><?php echo $row->amount->value; ?></td>
                                        <td><?php echo $row->status; ?></td>
                                        <td><?php echo !empty($row->details->consumerName) ? $row->details->consumerName : '' ; ?></td>
                                        <td><?php echo $row->id; ?></td>
                                    </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="content-header">
    <div class="content-header-left">
        <h1>Next set of Payments if applicable</h1>
    </div>
    <div class="content-header-right">
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-body table-responsive">
                    <table id="example3" class="content-table dataTable">
                        <thead>
                            <tr>
                                <th>Datum</th>
                                <th>Methode</th>
                                <th>Betrag</th>
                                <th>Status</th>
                                <th>Details</th>
                                <th>Transaktion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($next_payments as $key => $row) : ?>
                                    <tr onclick="window.location='<?php echo base_url('backend/shop/mollie/detail/'.$row->id);?>';" style="cursor:pointer">
                                        <td><?php echo date('d-m-Y H:i:s', strtotime($row->createdAt)); ?></td>
                                        <td><?php echo $row->method; ?></td>
                                        <td><?php echo $row->amount->value; ?></td>
                                        <td><?php echo $row->status; ?></td>
                                        <td><?php echo !empty($row->details->consumerName) ? $row->details->consumerName : '' ; ?></td>
                                        <td><?php echo $row->id; ?></td>
                                    </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>