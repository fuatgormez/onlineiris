<section class="content-header">
    <div class="content-header-left">
        <h1>View Ticket</h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url(); ?>backend/admin/ticket/close/<?php echo $ticket['id'];?>" class="btn btn-primary btn-sm">Close Ticket</a>
        <a href="<?php echo base_url(); ?>backend/admin/ticket" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>


<section class="content">
    <!-- new ticket answer -->
    <div class="row">
        <div class="col-md-12">
            <?php if ($ticket['status'] === "Close") : ?>
                <div class="callout callout-danger">
                    <p>This support request is closed. You can open it by replying to the support request again.</p>
                </div>
            <?php endif; ?>

            <?php echo form_open_multipart(base_url() . 'backend/admin/ticket/answer/' . $ticket['id'], array('class' => 'form-horizontal')); ?>
            <div class="box box-warning">
                <div class="box-body">
                    <details>
                        <summary class="text-success" style="cursor:pointer"><i class="fa fa-plus"></i> <strong>Answer - <?php echo $ticket['title']; ?> </strong></summary>
                        <div class="form-group" style="margin-top: 50px;">
                            <div class="col-sm-12">
                                <label for="" control-label">Your Answer *</label>
                                <textarea class="form-control" name="answer" id="editor1"></textarea>
                            </div>
                        </div>
                        <h3 class="seo-info">Attachments</h3>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Attachment <br>Allowed file types: .jpg, .gif, .jpeg, .png</label>
                            <div class="col-sm-6" style="padding-top:5px">
                                <table id="PhotosTable" style="width:100%;">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="upload-btn">
                                                    <input type="file" name="photos[]">
                                                </div>
                                            </td>
                                            <td style="width:28px;"><a href="javascript:void()" class="Delete btn btn-danger btn-xs">X</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-2" style="padding-top:5px">
                                <input type="button" id="btnAddNew" value="Add Item" style="margin-bottom:10px;border:0;color: #fff;font-size: 14px;border-radius:3px;" class="btn btn-warning btn-xs">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label"></label>
                            <div class="col-sm-8">
                                <button type="submit" class="btn btn-block btn-success pull-left" name="form1">Submit</button>
                            </div>
                        </div>
                    </details>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
    <!-- new ticket answer end -->

    <!-- ticket answer-->
    <?php foreach ($ticket_detail as $row_detail) : ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info form-horizontal">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-9">
                                <strong class="text-<?php echo $row_detail['user_id'] == 1 ? 'danger' : 'navy'; ?>">
                                    # <?php echo $row_detail['username']; ?>
                                </strong>
                            </div>
                            <div class="col-sm-3">
                                <span class="pull-right"><?php echo $row_detail['created_at']; ?></span>
                            </div>
                            <div class="col-sm-12" style="padding: 20px;">
                                <?php echo $row_detail['answer']; ?>
                            </div>
                        </div>
                        <?php foreach ($ticket_photos as $row_ticket_photo) : ?>
                            <?php if (!empty($row_ticket_photo['detail_id']) && $row_ticket_photo['detail_id'] == $row_detail['id']) : ?>
                                <hr>Existing Attachment
                                <div class="form-group">
                                    <div class="col-sm-12" style="padding-top:5px">
                                        <a href="<?php echo base_url('public/uploads/ticket_photos/' . date("d-m-Y", strtotime($ticket['created_at'])) . '/' . $row_ticket_photo['photo']); ?>" data-toggle="lightbox" data-gallery="for-photoshop-gallery">
                                            <img src="<?php echo base_url('public/uploads/ticket_photos/' . date("d-m-Y", strtotime($ticket['created_at'])) . '/' . $row_ticket_photo['photo']); ?>" style="width:120px;">
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <!-- ticket answer end -->


    <!-- first ticket -->
    <div class="row">
        <div class="col-md-12">
            <div class="box box-navy form-horizontal">
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-9">
                            <strong class="text-navy"># <?php echo $ticket['username']; ?></strong>
                        </div>
                        <div class="col-sm-3">
                            <span class="pull-right"><?php echo $ticket['created_at']; ?></span>
                        </div>
                        <div class="col-sm-12" style="padding: 20px;">
                            <?php echo $ticket['message']; ?>
                        </div>
                    </div>
                    <hr>Existing Attachment
                    <div class="form-group">
                        <div class="col-sm-12" style="padding-top:5px">
                            <?php foreach ($ticket_photos as $row_ticket_photo) : ?>
                                <?php if (empty($row_ticket_photo['detail_id'])) : ?>
                                    <a href="<?php echo base_url('public/uploads/ticket_photos/' . date("d-m-Y", strtotime($ticket['created_at'])) . '/' . $row_ticket_photo['photo']); ?>" data-toggle="lightbox" data-gallery="for-photoshop-gallery">
                                        <img src="<?php echo base_url('public/uploads/ticket_photos/' . date("d-m-Y", strtotime($ticket['created_at'])) . '/' . $row_ticket_photo['photo']); ?>" style="width:120px;">
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- first ticket end -->

</section>