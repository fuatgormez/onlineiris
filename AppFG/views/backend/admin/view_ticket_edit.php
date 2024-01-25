<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Ticket</h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url(); ?>backend/admin/ticket" class="btn btn-primary btn-sm">View All</a>
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

            <?php echo form_open_multipart(base_url() . 'backend/admin/ticket/edit/'.$ticket['id'], array('class' => 'form-horizontal')); ?>
            <div class="box box-info">
                <div class="box-body">

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Title *</label>
                        <div class="col-sm-8">
                            <input type="text" autocomplete="off" class="form-control" name="title" value="<?php echo $ticket['title']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Message *</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="message" id="editor1"><?php echo $ticket['message']; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Please select one of the departments below first *</label>
                        <div class="col-sm-4">
                            <select name="department_id" class="form-control select2">
                                <?php foreach ($department as $row) : ?>
                                    <option value="<?php echo $row['department_id']; ?>" <?php echo $row['department_name'] == $ticket['department'] ? 'selected' : ''; ?>><?php echo $row['department_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <label for="" class="col-sm-2 control-label">Urgency</label>
                        <div class="col-md-2">
                            <select name="urgency" class="form-control select2">
                                <option value="High" <?php echo $ticket['urgency'] === "High" ? 'selected' : ''; ?>>High</option>
                                <option value="Medium" <?php echo $ticket['urgency'] === "Medium" ? 'selected' : ''; ?>>Medium</option>
                                <option value="Low" <?php echo $ticket['urgency'] === "Low" ? 'selected' : ''; ?>>Low</option>
                            </select>
                        </div>
                    </div>
                    <h3 class="seo-info">Attachments</h3>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Existing Attachment</label>
                        <div class="col-sm-9" style="padding-top:5px">
                            <?php foreach ($ticket_photos as $row_ticket_photos) : ?>
                            <a href="<?php echo base_url('public/uploads/ticket_photos/'.date("d-m-Y" ,strtotime($ticket['created_at'])).'/'.$row_ticket_photos['photo']);?>" data-toggle="lightbox" data-gallery="for-photoshop-gallery">
                                <img src="<?php echo base_url('public/uploads/ticket_photos/'.date("d-m-Y" ,strtotime($ticket['created_at'])).'/'.$row_ticket_photos['photo']);?>" style="width:120px;">
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
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

                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>