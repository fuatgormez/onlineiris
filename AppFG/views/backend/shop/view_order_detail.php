<?php if ($order_detail['storno'] == 1) : ?>
    <div class="cancelled"></div>
<?php endif; ?>
<section class="content-header">
    <div class="content-header-left">
        <h1>Detail Order</h1>
    </div>
    <div style="float:right !important;">
        <?php if (in_array($this->session->userdata('id'), [1])) : ?>
            <a href="<?php echo base_url(); ?>backend/shop/order/delete/<?php echo $order_detail['order_id'].'/'.$order_detail['order_number']; ?>/items_excluded" class="btn btn-danger" onClick="return confirm('Are you sure?');">Delete order products excluded!</a>
        <?php endif; ?>
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin', 'Seller'])) : ?>
            <a href="#" class="btn btn-success btn-sm confirm_paid" data-paid="paid" data-amount="<?php echo number_format($order_detail['total'] > 1 && $order_detail['paid'] !== 'isPaid' ? $order_detail['total'] : "0.00", 2); ?>" data-order-number="<?php echo $order_detail['order_number']; ?>">Paid</a>
            <a href="#" class="btn btn-danger btn-sm confirm_paid" data-paid="unpaid" data-amount="<?php echo number_format($order_detail['total'] > 1 && $order_detail['paid'] !== 'isPaid' ? $order_detail['total'] : "0.00", 2); ?>" data-order-number="<?php echo $order_detail['order_number']; ?>">unPaid</a>
            <a href="#" class="btn btn-success btn-sm confirm_paid" data-paid="paid_update" data-amount="<?php echo number_format($order_detail['total_update'] > 1 && $order_detail['paid_update'] !== 'isPaid'  ? $order_detail['total_update'] : "0.00", 2); ?>" data-order-number="<?php echo $order_detail['order_number']; ?>">Update Paid</a>
            <a href="#" class="btn btn-danger btn-sm confirm_paid" data-paid="unpaid_update" data-amount="<?php echo number_format($order_detail['total_update'] > 1 && $order_detail['paid_update'] !== 'isPaid'  ? $order_detail['total_update'] : "0.00", 2); ?>" data-order-number="<?php echo $order_detail['order_number']; ?>">Update unPaid</a>
            <a href="#" class="btn btn-danger btn-sm storno" data-action="1">Storno</a>
            <a href="#" class="btn btn-danger btn-sm storno" data-action="0">UnStorno</a>
        <?php endif; ?>
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
            <a href="<?php echo base_url('backend/shop/order/update/' . $order_detail['order_id'] . '/' . $order_detail['order_number']); ?>" class="btn btn-warning">Order Edit</a>
        <?php endif; ?>
        <a href="<?php echo base_url('backend/shop/order'); ?>" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">
    <div class="process_box" id="<?php echo $order_detail['status_process']; ?>">
        <!-- box box-info -->
        <div class="box box-info">
            <!-- invoice -->
            <div class="invoice">
                <!-- title row -->
                <div class="row">
                    <div class="col-md-6">
                        Date: <span id="f_u_date"><?php echo $order_detail['date_purchased']; ?></span> 
                        <?php if (in_array($this->session->userdata('id'), [1,20])):?>
                        <span><a href="<?php echo base_url('backend/shop/order/create_new_order_folder/'.$order_detail['order_id']) ;?>">Create new order folder</a></span>
                        <?php endif;?>
                    </div>
                    <div class="col-md-6">
                        <span class=" pull-right">
                            <a href="#" class="labelprint" data-order-number="<?php echo $order_detail['order_number']; ?>" data-security-number="<?php echo $order_detail['security_number']; ?>" data-expiry-date="<?php echo date('d-m-Y', strtotime('+1 year', strtotime($order_detail['date_purchased']))); ?>"><i class="fa fa-2x fa-barcode"></i></a>
                            <a href="<?php echo base_url('public/pdf/invoice/' . $order_detail['order_number'] . '.pdf'); ?>" title="Order Confirmation" target="_blank"><i class="fa fa-2x fa-file-pdf"></i></a>
                            <a href="<?php echo base_url('public/pdf/coupon/' . $order_detail['order_number'] . '.pdf'); ?>" title="Shooting-Voucher Coupon" target="_blank"><i class="fa fa-2x fa-tag"></i></a>
                            <a href="#" data-lang-code="<?php echo $order_detail['store_lang_code']; ?>" data-message-type="<?php echo $order_detail['payment_method'] === 'bankTransfer' ? 'bankTransfer' : 'mollie'; ?>" data-email="<?php echo $order_detail['billing_email']; ?>" data-order-number="<?php echo $order_detail['order_number']; ?>" title="Send e mail again"><i class="fa fa-2x fa-envelope re_send_email"></i></a>
                            <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
                                <a href="<?php echo base_url(); ?>backend/shop/order/delete/<?php echo $order_detail['order_id']; ?>/<?php echo $order_detail['order_number']; ?>" class="text-danger" onClick="return confirm('Are you sure?');"><i class="fa fa-2x fa-trash"></i></a>
                            <?php endif; ?>
                        </span>
                    </div>
                    <!-- /.col -->
                </div>
                <hr>
                <!-- info row -->
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        <p class="text-bold text-info">Invoice Address</p>
                        <address>
                            <p class="text-bold copyClipboard" data-clipboard-target="#billing_firstname">Name: <span id="billing_firstname"><?php echo $order_detail['billing_firstname'] . " " . $order_detail['billing_lastname']; ?></span></p>
                            <p class="copyClipboard" data-clipboard-target="#billing_phone"><b>Phone:</b> <span id="billing_phone"><?php echo $order_detail['billing_phone']; ?></span></p>
                            <p class="copyClipboard" data-clipboard-target="#billing_email"><b>Email:</b> <span id="billing_email"><?php echo $order_detail['billing_email']; ?></span></p>
                            <p class="copyClipboard" data-clipboard-target="#billing_comment"><b>Notes:</b> <span id="billing_comment"><?php echo $order_detail['billing_comment']; ?></span></p>
                            <hr>
                            <p class="copyClipboard" data-clipboard-target="#billing_street"><b>Street:</b> <span id="billing_street"><?php echo $order_detail['billing_street'] . " " . $order_detail['billing_street_no']; ?></span></p>
                            <p class="copyClipboard" data-clipboard-target="#billing_plz_city"><b>Plz/City:</b> <span id="billing_plz_city"><?php echo $order_detail['billing_postcode'] . ", " . $order_detail['billing_city']; ?></span></p>
                            <p class="copyClipboard" data-clipboard-target="#billing_country"><b>Country:</b> <span id="billing_country"><?php echo $order_detail['billing_country']; ?></span></p>
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        <p class="text-bold text-info">Shipping Address</p>
                        <address>
                            <p class="text-bold copyClipboard" data-clipboard-target="#shipping_firstname">Name: <span id="shipping_firstname"><?php echo $order_detail['shipping_firstname'] . " " . $order_detail['shipping_lastname']; ?></span></p>
                            <p class="copyClipboard" data-clipboard-target="#shipping_phone"><b>Phone:</b> <span id="shipping_phone"><?php echo $order_detail['shipping_phone']; ?></span></p>
                            <p class="copyClipboard" data-clipboard-target="#shipping_email"><b>Email:</b> <span id="shipping_email"><?php echo $order_detail['shipping_email']; ?></span></p>
                            <p class="copyClipboard" data-clipboard-target="#shipping_comment"><b>Notes:</b> <span id="shipping_comment"><?php echo $order_detail['shipping_comment']; ?></span></p>
                            <hr>
                            <p class="copyClipboard" data-clipboard-target="#shipping_street"><b>Street:</b> <span id="shipping_street"><?php echo $order_detail['shipping_street'] . " " . $order_detail['shipping_street_no']; ?></span></p>
                            <p class="copyClipboard" data-clipboard-target="#shipping_plz_city"><b>Plz/City:</b> <span id="shipping_plz_city"><?php echo $order_detail['shipping_postcode'] . ", " . $order_detail['shipping_city']; ?></span></p>
                            <p class="copyClipboard" data-clipboard-target="#shipping_country"><b>Country:</b> <span id="shipping_country"><?php echo $order_detail['shipping_country']; ?></span></p>
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        <p class="text-bold copyClipboard" data-clipboard-target="#order_number">Order Number: <span id="order_number"><span id="f_u_order_number"><?php echo $order_detail['order_number']; ?></span></span></p>
                        <p class="text-bold copyClipboard" data-clipboard-target="#security_number">Security Number: <span id="security_number"><span id="f_u_security_number"><?php echo $order_detail['security_number']; ?></span></span></p>
                        <hr>
                        <p class="text-bold">Land Name: <span id="f_u_land_name"><?php echo $order_detail['land_name']; ?></span></p>
                        <p class="text-bold">Store Name: <span id="f_u_store_name"><?php echo $order_detail['store_name']; ?></span></p>
                        <p class="text-bold">Store ID: <span id="f_u_store_id"><?php echo $order_detail['store_id']; ?></span></p>
                        <hr>
                        <b>Order ID:</b> <?php echo $order_detail['order_id']; ?><br>
                        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin', 'Meister', 'Production', 'Seller', 'Designer'])) : ?>
                            <b>Payment Method:</b> <?php echo $order_detail['payment_method']; ?> / <b>Paid:</b> <span id="f_u_paid"><?php echo $order_detail['paid']; ?></span><br>
                            <b>Payment Method Update:</b> <?php echo $order_detail['payment_method_update']; ?> / <b>Paid Update:</b> <?php echo $order_detail['paid_update']; ?><br>
                        <?php endif; ?>
                        <b>Status:</b> <?php echo $order_detail['status']; ?><br>
                        <b>Order From:</b> <?php echo $order_detail['order_type']; ?>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- Table row -->
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <hr>
                        <table class="content-table dataTable" id="table_product_items">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Item Price</th>
                                    <th>Is Updated</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order_item as $item) : ?>
                                    <tr style="background-color: rgb(151 199 222 / 40%); color: #000;">
                                        <td>
                                            <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin', 'Meister', 'Production'])) : ?>
                                                <input type="checkbox" class="is_printed" data-type="normal" data-item-id="<?php echo $item['item_product_id']; ?>" <?php echo $item['is_printed'] == 1 ? 'checked' : ''; ?>>
                                            <?php endif; ?>

                                            <?php echo $item['item_name']; ?> (<?php echo $item['item_product_id']; ?>)
                                            <?php echo $item['is_completed_uniqid'] == 1 ? '<span class="text-green">UNIQ</span>' : ''; ?>
                                            <?php echo !empty($item['item_uniqid']) ? "<br>Item Uniqid: " . $item['item_uniqid'] : ""; ?>
                                            <?php echo !empty($item['item_type']) ? "<br>Item Type: " . $item['item_type'] . "<br>" : ""; ?>
                                            <?php echo !empty($item['email']) ? $item['email'] . "<br>" : ""; ?>
                                            <?php echo $item['comment'] != NULL ? "<br>Address: " . $item['comment'] : ""; ?>
                                        </td>
                                        <td><?php echo $item['item_price']; ?></td>
                                        <td>current</td>
                                        <td><?php echo $item['item_qty']; ?></td>
                                        <td><?php echo $item['item_currency_icon']; ?> <?php echo $item['item_subtotal']; ?></td>
                                        <td><span class="pull-right">
                                                <?php echo $item['created_at']; ?>
                                                <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?> - <a href="<?php echo base_url('backend/shop/order/delete_order_item/' . $item['item_id'] . '/' . $item['order_number']); ?>"><i class="fa fa-trash text-danger"></i></a>
                                                <?php endif; ?> -
                                                <?php echo $item['is_completed'] == 1 ? '<i class="fa fa-check success" data-toggle="tooltip" data-placement="left" title="done"></i>' : '<i class="fa fa-times error" data-toggle="tooltip" data-placement="left" title="not done"></i>'; ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <?php foreach ($order_item_updated as $item_updated) : ?>
                                    <tr>
                                        <td><input type="checkbox" class="is_printed" data-type="update" data-item-id="<?php echo $item_updated['item_id']; ?>" <?php echo $item_updated['is_printed'] == 1 ? 'checked' : ''; ?>>
                                            <?php echo $item_updated['item_name']; ?> <?php echo $item_updated['item_id']; ?> => <?php echo $item_updated['item_id_old']; ?>
                                            <?php echo !empty($item_updated['item_uniqid']) ? "<br>Item Uniqid: " . $item_updated['item_uniqid'] . "<br>" : ""; ?>
                                            <?php echo $item_updated['comment'] != NULL ? "<br><br>" . $item_updated['comment'] : ""; ?>
                                        </td>
                                        <td><?php echo $item_updated['item_price']; ?></td>
                                        <td><?php echo $item_updated['is_updated']; ?></td>
                                        <td><?php echo $item_updated['item_qty']; ?></td>

                                        <td><?php echo $item_updated['item_currency_icon']; ?> <?php echo $item_updated['item_subtotal']; ?></td>
                                        <td>
                                            <span class="pull-right">
                                                <?php echo $item_updated['created_at']; ?>
                                                <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?> - <a href="<?php echo base_url('backend/shop/order/delete_order_item/' . $item_updated['item_id'] . '/' . $item_updated['order_number']); ?>"><i class="fa fa-trash text-danger"></i></a>
                                                <?php endif; ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <!-- accepted payments column -->

                    <div class="col-md-8">
                        <div class="row">

                            <div id="exTab3">
                                <ul class="nav nav-pills">
                                    <li class="active">
                                        <a href="#1b" data-toggle="tab">FOR PHOTOSHOP</a>
                                    </li>
                                    <li><a href="#2b" data-toggle="tab">FOR PRINTING</a></li>
                                    <li><a href="#3b" data-toggle="tab">NOTES</a></li>
                                    <li><a href="#4b" data-toggle="tab">CONFIRM</a></li>
                                </ul>

                                <div class="tab-content clearfix">
                                    <!--- for photoshop  start -->
                                    <div class="tab-pane active" id="1b">
                                        <?php
                                        $with_name_price = 0;
                                        foreach ($order_item_upload as $item_upload) :
                                            $with_name_price += $item_upload["with_name_price"];
                                            $item_img_explode = explode('.', $item_upload["image"]);
                                            if (strtoupper($item_img_explode[1]) !== "CR2") :
                                        ?>
                                                ​
                                                <div class="col-md-6" id="for_photoshop_img_<?php echo $item_upload["item_upload_id"]; ?>">
                                                    <div class="polaroid">
                                                        <div class="relative_img">
                                                            <a href="<?php echo base_url($item_upload["path"] . $item_upload["image"]); ?>" data-toggle="lightbox" data-gallery="for-photoshop-gallery">
                                                                <img class="img-responsive" width="100%" height="250" src="<?php echo base_url($item_upload["path"] . $item_upload["image"]); ?>" data-toggle="tooltip" data-placement="bottom" title="name: <?php echo $item_upload["with_name"]; ?> - Price: <?php echo $item_upload["with_name_price"]; ?>  - item id: <?php echo $item_upload["item_id"]; ?>">
                                                            </a>
                                                            <div class="is_extra">
                                                                <?php if ($item_upload["is_extra"] == 1) : ?>
                                                                    <small class="label bg-red">Extra</small>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="is_selected">
                                                                <?php if ($item_upload["is_selected"] == 1) : ?>
                                                                    <small class="label bg-green">Selected</small>
                                                                <?php endif; ?>
                                                            </div>
                                                            <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
                                                                <div class="order_img_delete">
                                                                    <small class="label bg-red"><i class="fa fa-trash for_photoshop_photo_delete" data-id="<?php echo $item_upload['item_upload_id']; ?>"></i></small>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <p class="mt-10">
                                                            <span class="text-yellow"> item id: <?php echo $item_upload["item_id"]; ?> <?php echo $item_upload["item_id_duplicated"] != 0 ? '- Duplicated' : ''; ?></span><br>
                                                            <span class="text-yellow"> item id old : <?php echo $item_upload["item_id_duplicated"]; ?></span><br>
                                                            <span class="text-yellow"> item uniqid : <?php echo $item_upload["item_uniqid"]; ?></span><br>
                                                            <span class="text-green">Owner: <?php echo $item_upload["image_owner"]; ?></span> <br>
                                                            <span class="text-blue">Text: <?php echo $item_upload["with_name"]; ?></span> <br>
                                                            <span class="text-danger">Price: <?php echo number_format($item_upload["with_name_price"], 2); ?></span> <br>
                                                            <span class="text-danger">Total: <?php echo number_format($item_upload["total"], 2); ?></span> <br>
                                                            <span class="text-blue" data-toggle="tooltip" data-placement="right" title="<?php echo $item_upload['image_dublicated_name'] !== NULL ? $item_upload['image_dublicated_name'] : $item_upload["image"]; ?>">Image</span><br>
                                                            <span>Date: <?php echo $item_upload["created_at"]; ?></span> <br>
                                                        </p>

                                                    </div>
                                                </div>

                                        <?php endif;
                                        endforeach; ?>

                                        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin', 'Designer'])) : ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="col-md-6">
                                                        <a href="#" data-order-number="<?php echo $order_detail['order_number']; ?>" class="btn btn-block btn-success mt-20 photoshop_download">
                                                            Download All Images
                                                        </a>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <?php if (in_array($this->session->userdata('role'), ['Superadmin'])) : ?>
                                                            <button type="button" class="btn btn-block btn-warning" data-toggle="modal" data-target=".new_manuel_image_upload">Manual image upload</button>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                    </div><!-- tabe-pane end 1b -->
                                    <!--- for photoshop  end -->
                                    <!--- for printer  start -->
                                    <div class="tab-pane" id="2b">
                                        <div id="uploaded_images">
                                            <?php foreach ($order_item_upload_done as $row_done_img) : ?>
                                                <div class="col-md-6" id="for_printing_img_<?php echo $row_done_img['image_id']; ?>">
                                                    <div class="polaroid">
                                                        <div class="relative_img">
                                                            <a href="<?php echo base_url() . $row_done_img["path"] . $row_done_img["image"]; ?>" data-toggle="lightbox" data-gallery="for-printer-gallery">
                                                                <img class="img-responsive" width="100%" height="250" src="<?php echo base_url() . $row_done_img["path"] . $row_done_img["image"]; ?>">
                                                            </a>
                                                            <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin', 'Meister', 'Designer'])) : ?>
                                                                <div class="is_extra">
                                                                    <small class="label bg-blue">Upload by <?php echo $row_done_img['user']; ?></small>
                                                                </div>
                                                            <?php endif; ?>
                                                            <div class="is_selected">
                                                                <small class="label bg-yellow"><?php echo date("d-m-Y H:i:s", strtotime($row_done_img['created_at'])); ?></small>
                                                            </div>
                                                            <?php if (array_intersect([$this->session->userdata('role'), $this->session->userdata('id')], ['Superadmin','Admin',20])) : //20 id li kullanici gulsum) : ?>
                                                                <div class="order_img_delete">
                                                                    <small class="label bg-red"><i class="fa fa-trash for_printing_photo_delete" data-id="<?php echo $row_done_img['image_id']; ?>"></i></small>
                                                                </div>
                                                            <?php endif; ?>
                                                            <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin', 'Meister', 'Production'])) : ?>
                                                                <div class="order_img_download">
                                                                    <small class="label bg-green"><i class="fa fa-download photoshop_done_download" data-id="<?php echo $row_done_img['image_id']; ?>"></i></small>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <span style="overflow: hidden;"><?php echo $row_done_img['image']; ?></span>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin', 'Designer'])) : ?>
                                            <div class="col-md-12">
                                                <input type="file" id='photos' name="photos[]" accept="image/* , application/tif" class="bg-red" style="display:block;width:100%;padding:10px" multiple /><br>
                                                <button id="photoshop_upload" class="btn btn-block btn-primary mt-20">Upload</button>
                                            </div>
                                        <?php endif; ?>
                                    </div><!-- tabe-pane end 2b -->
                                    <!--- for printer  end -->
                                    <!--- for notes  start -->
                                    <div class="tab-pane" id="3b">
                                        <p>NOTES</p>
                                        <hr>
                                        <div id="all_order_notes">
                                            <?php foreach ($get_order_note as $row_note) : ?>
                                                <div class="callout callout-info" id="note_id_<?php echo $row_note['id']; ?>">
                                                    <div class="box box-default">
                                                        <div class="box-header with-border">
                                                            <p><?php echo in_array($this->session->userdata('role'), ["Superadmin"]) ? '<i class="fa fa-trash delete_order_note" data-note-id="' . $row_note['id'] . '"></i>' : ''; ?> <span class="pull-right"><?php echo $row_note['user']; ?> - <?php echo $row_note['created_at']; ?></span></p>
                                                        </div>
                                                        <div class="box-body text-black">
                                                            <?php echo $row_note['note']; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <textarea id="editor2" class="order_note_text"></textarea>
                                        <button class="btn btn-block btn-primary add_oder_note">Add Note</button>
                                    </div><!-- tabe-pane end 3b -->
                                    <!--- for notes  end -->
                                    <!--- for notes  start -->
                                    <div class="tab-pane" id="4b">
                                        <p>FREIGABE</p>
                                        <?php foreach ($get_order_customer_process as $row_freigabe) : ?>
                                            <?php if (!empty($row_freigabe['comment'])) : ?>
                                                <div class="callout callout-<?php echo $row_freigabe['freigabe'] == 1 ? 'info' : 'danger'; ?>" id="freigabe<?php echo $row_freigabe['id']; ?>">
                                                    <div class="box box-default">
                                                        <div class="box-header with-border">
                                                            <p>Freigabe:<?php echo $row_freigabe['freigabe'] == 1 ? 'Verildi.' : 'Verilmedi'; ?>
                                                                <span class="pull-right">
                                                                    Customer - <?php echo $row_freigabe['created_at']; ?>
                                                                    <small class="label bg-red"><i class="fa fa-trash delete_freigabe" data-id="<?php echo $row_freigabe['id']; ?>"></i></small>
                                                                </span>
                                                            </p>
                                                        </div>
                                                        <div class="box-body text-black">
                                                            <?php echo $row_freigabe['comment']; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div><!-- tabe-pane end 3b -->
                                    <!--- for notes  end -->
                                </div>
                            </div>
                        </div><!-- row end -->
                    </div><!-- col-8 end -->
                    <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin', 'Meister', 'Seller', 'Designer'])) : ?>
                        <div class="col-md-4">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>With Name Price:</th>
                                            <td><?php echo $order_detail['store_currency_icon']; ?> <?php echo $with_name_price != 0 ? '<span class="text-danger">'. number_format($with_name_price, 2) .'</span>' : '0.00'; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Discount Amount:</th>
                                            <td><?php echo $order_detail['store_currency_icon']; ?> <?php echo $order_detail['discount_amount'] != 0 ? number_format($order_detail['discount_amount'], 2) : '0.00'; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Shipping total:</th>
                                            <td><?php echo $order_detail['store_currency_icon']; ?> <?php echo $order_detail['shipping_total'] != 0 ? number_format($order_detail['shipping_total'], 2) : '0.00'; ?></td>
                                        </tr>
                                        <tr>
                                            <th>&nbsp;</th>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <th>Order subtotal:</th>
                                            <td><?php echo $order_detail['store_currency_icon']; ?> <?php echo number_format($o_zwischensumme, 2); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Order ready paid: </th>
                                            <td><?php echo $order_detail['store_currency_icon']; ?> <?php echo number_format($o_bereit_bezahlt, 2); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Order to pay: </th>
                                            <td><?php echo $order_detail['store_currency_icon']; ?> <?php echo number_format($o_zu_zahlen, 2); ?></td>
                                        </tr>

                                        <tr>
                                            <th>&nbsp;</th>
                                            <td>&nbsp;</td>
                                        </tr>

                                        <tr>
                                            <th>Update subtotal:</th>
                                            <td><?php echo $order_detail['store_currency_icon']; ?> <?php echo number_format($u_zwischensumme, 2); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Update ready paid: </th>
                                            <td><?php echo $order_detail['store_currency_icon']; ?> <?php echo number_format($u_bereit_bezahlt, 2); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Update to pay: </th>
                                            <td><?php echo $order_detail['store_currency_icon']; ?> <?php echo number_format($u_zu_zahlen, 2); ?></td>
                                        </tr>
                                        <tr>
                                            <th>&nbsp;</th>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <th style="width:50%">Subtotal:</th>
                                            <td><?php echo $order_detail['store_currency_icon']; ?> <?php echo number_format($order_detail['total'] + $with_name_price + $order_detail['shipping_total'], 2); ?></td>
                                        </tr>
                                        <tr>
                                            <th>To pay in total: </th>
                                            <td><?php echo $order_detail['store_currency_icon']; ?> <?php echo number_format($zahlen, 2); ?></td>
                                        </tr>

                                        <tr>
                                            <th>&nbsp;</th>
                                            <td>&nbsp;</td>
                                        </tr>

                                        <?php foreach ($get_order_paid_process as $row_order_paid_process) : ?>
                                            <?php if ($row_order_paid_process['type_paid'] === 'paid' && $row_order_paid_process['amount'] > 1) : ?>
                                                <tr>
                                                    <th>Paid:</th>
                                                    <td><?php echo $order_detail['store_currency_icon'] . " " . number_format($row_order_paid_process['amount'], 2); ?> <?php echo $row_order_paid_process['user']; ?> </td>
                                                </tr>
                                            <?php endif; ?>

                                            <?php if ($row_order_paid_process['type_paid'] === 'paid_update' && $row_order_paid_process['amount'] > 1) : ?>
                                                <tr>
                                                    <th>Paid Update:</th>
                                                    <td><?php echo $order_detail['store_currency_icon'] . " " . number_format($row_order_paid_process['amount'], 2); ?> <?php echo $row_order_paid_process['user']; ?> </td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.col -->
                </div>
                <!-- /.row -->
            <?php endif; ?>

            </div>
            <!-- invoice end -->
        </div>
        <!-- box box-info end -->
    </div>
    <!-- process end -->


</section>

<section class="content">
    <div class="order_process" data-order-number="<?php echo $order_detail['order_number']; ?>">
        <?php foreach ($setting_shop_order_status as $key => $row_order_status) : ?>
            <div data-status-process="<?php echo $row_order_status['status']; ?>" class="status_process process-style" style="background-color:#<?php echo $row_order_status['color']; ?>"><?php echo $row_order_status['text']; ?></div>
        <?php endforeach; ?>
    </div>
</section>


<!-- Modal -->
<form id="photoshop_manual_upload_iptal">
    <div class="modal fade new_manuel_image_upload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title" id="exampleModalLabel">Manual image upload</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control m_item_id" placeholder="item_id">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control m_item_uniqid" placeholder="item_uniqid">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control m_item_id_extra" placeholder="item_id_extra">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control m_item_id_duplicated" placeholder="item_id_duplicated">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control m_is_extra" placeholder="is_extra">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control m_is_selected" placeholder="is_selected">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control m_is_completed_uniqid" placeholder="is_completed_uniqid">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control m_image_owner" placeholder="image_owner">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control m_qty" placeholder="qty">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control m_total" placeholder="total">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control m_with_name" placeholder="with_name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="m_with_name_price" placeholder="with_name_price">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
                                        <input type="file" name="photos" accept="image/* , application/tif" class="bg-red" style="display:block;width:100%;padding:10px" /><br>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="photoshop_manual_upload">Upload</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- #Modal -->