<?php
if (!$this->session->userdata('id')) {
    redirect(base_url() . 'backend/admin/login');
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>View Product Type</h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url(); ?>backend/shop/product/product_add_type" class="btn btn-primary btn-sm">Add Product Type</a>
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
                    <table id="example1" class="content-table dataTable">
                        <thead>
                        <tr>
                            <th>Row</th>
                            <th>Product Type</th>
                            <th style="width: 10%;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($product_type as $row): ?>
                            <tr>
                                <td><?php echo $row['row']; ?></td>
                                <td><?php echo $row['type_value']; ?></td>
                                <td>
                                    <a href="<?php echo base_url(); ?>backend/shop/product/product_edit_type/<?php echo $row['type_id']; ?>"
                                       class="btn btn-primary btn-xs">Edit</a>
                                    <a href="<?php echo base_url(); ?>backend/shop/product/product_delete_type/<?php echo $row['type_id']; ?>"
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