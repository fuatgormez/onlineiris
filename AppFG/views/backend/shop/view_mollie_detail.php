<section class="content-header">
    <div class="content-header-left">
        <h1>Detail Mollie Payment Detail</h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url('backend/shop/mollie'); ?>" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">
    <div class="process_box">
        <!-- box box-info -->
        <div class="box box-info">
            <!-- box-body -->
            <div class="box-body">
                <!-- title row -->
                <div class="row">

                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Zahlungsdetails</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                                <table class="table table-hover">
                                    <tr>
                                        <td width="50%">Beschreibung</td>
                                        <td>IRISPICTURE</td>
                                    </tr>
                                    <tr>
                                        <td width="50%">Betrag</td>
                                        <td><?php echo @$payment->amount->value .' '. $payment->amount->currency; ?> </td>
                                    </tr>
                                    <tr>
                                        <td width="50%">Verbleibender Rückerstattungsbetrag <a href="https://help.mollie.com/hc/de/articles/115000014489"><i class="fa fa-info" data-toggle="tooltip" data-placement="right" data-original-title="Für diese Zahlung können Sie 25,00 € zusätzlich zum max. Bestellwert rückerstatten. Lesen Sie mehr über zusätzliche Rückerstattung hier."></i></a></td>
                                        <td><?php echo @$payment->amountRemaining->value; ?> €</td>
                                    </tr>
                                    <tr>
                                        <td width="50%">Zahlungs ID</td>
                                        <td><?php echo @$payment->id; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%">Status</td>
                                        <td><?php echo @$payment->status; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%">Modus</td>
                                        <td><?php echo @$payment->mode; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%">Country Code</td>
                                        <td><?php echo @$payment->countryCode; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%">Erstellt am</td>
                                        <td><?php echo date('d-m-Y H:i:s', strtotime(@$payment->createdAt)); ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%">Bezahlt am</td>
                                        <td><?php echo date('d-m-Y H:i:s', strtotime(@$payment->paidAt)); ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%">URL-Umleitung</td>
                                        <td><?php echo @$payment->redirectUrl; ?></td>
                                    </tr>
                                    <tr>
                                        <td width=50%">Details</td>
                                        <td>
                                            <?php if(isset($payment->details)):?>
                                                <?php foreach($payment->details as $detail_key => $row_detail): ?>
                                                    <p><?php echo $detail_key .' : '.$row_detail;?></p>
                                                <?php endforeach;?>
                                            <?php endif;?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="50%">Metadata (ORDER INFO)</td>
                                        <td>
                                            <?php if(isset($payment->metadata)):?>
                                                <?php foreach($payment->metadata as $meta_key => $row_metadata): ?>
                                                    <?php if($meta_key === 'items'):?>
                                                        <p><?php echo $meta_key;?></p>
                                                        <?php $meta_items = (array) json_encode($row_metadata,true);?>
                                                        <?php foreach($meta_items as $keys => $item):?>
                                                            <p><?php echo $keys .' : '.$item;?></p>
                                                        <?php endforeach;?>            
                                                    <?php else:?>
                                                        <p><?php echo $meta_key .' : '.$row_metadata;?></p>
                                                    <?php endif;?>
                                                <?php endforeach;?>
                                            <?php endif;?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-header">
                                <hr>
                                <h3 class="box-title"><?php echo strtoupper(@$payment->method); ?></h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                                <table class="table table-hover">
                                    <?php if(isset($payment->details)):?>
                                    <?php foreach ($payment->details as $key => $row) : ?>
                                        <?php if (is_object($row)) : ?>
                                            <?php foreach($row as $sub_key => $sub_row) :?>
                                            <tr>
                                                <td><?php echo @$sub_key; ?></td>
                                                <td width="50%"><?php echo @$sub_row; ?></td>
                                            </tr>
                                            <?php endforeach;?>
                                        <?php else : ?>
                                            <tr>
                                                <td><?php echo @$key; ?></td>
                                                <td width="50%"><?php echo @$row; ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- info row -->
            </div>
            <!-- box-body end -->
        </div>
        <!-- box box-info end -->
    </div>
    <!-- process end -->
</section>