<?php
if (!$this->session->userdata('id')) {
    redirect(base_url() . 'backend/admin/login');
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>View Product</h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url(); ?>backend/shop/product/add" class="btn btn-primary btn-sm">Add New</a>
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
                                <th>SL</th>
                                <th>Product Name</th>
                                <th>Product Category</th>
                                <th>Product Price</th>
                                <th width="140">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $key => $row) : ?>
                                <tr>
                                    <td style="width:100px;"><?php echo $row['id']; ?></td>

                                    <td>
                                        <a href="<?php echo base_url('backend/shop/product/edit/') . $row['id']; ?>"><?php echo $row['product_name']; ?></a>
                                    </td>
                                    <td>
                                        <?php echo $row['category_name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['product_price']; ?>
                                    </td>

                                    <td>
                                        <a href="<?php echo base_url('backend/shop/product/edit/') . $row['id']; ?>" class="btn btn-primary">Edit</a>
                                        <?php if (in_array($this->session->userdata('role'), ['Superadmin'])) : ?>
                                            <a href="<?php echo base_url('backend/shop/product/delete/') . $row['id']; ?>" class="btn btn-danger" onClick="return confirm('Are you sure?');">Delete</a>
                                        <?php endif; ?>
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