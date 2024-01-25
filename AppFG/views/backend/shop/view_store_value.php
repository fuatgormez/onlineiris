<?php
if (!$this->session->userdata('id')) {
    redirect(base_url() . 'backend/admin/login');
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>View Stores</h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url(); ?>backend/shop/store/add_value" class="btn btn-primary btn-sm">Add Store Value</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <?php
            if ($this->session->flashdata('error')) {
                ?>
                <div class="callout callout-danger">
                    <p><?php echo $this->session->flashdata('error'); ?></p>
                </div>
                <?php
            }
            if ($this->session->flashdata('success')) {
                ?>
                <div class="callout callout-success">
                    <p><?php echo $this->session->flashdata('success'); ?></p>
                </div>
                <?php
            }
            ?>


            <div class="box box-info">
                <div class="box-body table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Land Name</th>
                            <th>Currency Code</th>
                            <th>Currency Icon</th>
                            <th>Lang Code</th>
                            <th>Lang Flag</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($store_value as $row): ?>
                            <tr>
                                <td><?php echo $row['store_value_id']; ?></td>
                                <td><?php echo $row['land_name']; ?></td>
                                <td><?php echo $row['currency_code']; ?></td>
                                <td><?php echo $row['currency_icon']; ?></td>
                                <td><?php echo $row['lang_code']; ?></td>
                                <td><img width="50" src="<?php echo base_url('public/uploads/store_photos/flag/');?><?php echo $row['lang_flag']; ?>"></td>
                                <td><?php echo $row['status']; ?></td>
                                <td>
                                    <a href="<?php echo base_url(); ?>backend/shop/store/edit_value/<?php echo $row['store_value_id']; ?>"
                                       class="btn btn-primary btn-xs">Edit</a>
                                    <a href="<?php echo base_url(); ?>backend/shop/store/delete_value/<?php echo $row['store_value_id']; ?>"
                                       class="btn btn-danger btn-xs"
                                       onClick="return confirm('Are you sure?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</section>