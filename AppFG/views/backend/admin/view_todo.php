<section class="content-header">
    <div class="content-header-left">
        <h1>View TODOs</h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url(); ?>backend/admin/todo/add" class="btn btn-primary btn-sm">Add New</a>
    </div>
</section>


<section class="content">

    <div class="row">
        <div class="col-md-12">

            <?php
            if($this->session->flashdata('error')) {
                ?>
                <div class="callout callout-danger">
                    <p><?php echo $this->session->flashdata('error'); ?></p>
                </div>
                <?php
            }
            if($this->session->flashdata('success')) {
                ?>
                <div class="callout callout-success">
                    <p><?php echo $this->session->flashdata('success'); ?></p>
                </div>
                <?php
            }
            ?>


            <div class="box box-info">

                <div class="box-body table-responsive">
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th width="50">SL</th>
                            <th>TODO Title</th>
                            <th>Completed</th>
                            <th width="25%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i=0;
                        foreach ($todo as $row) {
                            $i++;
                            ?>
                            <tr class="<?php echo $row['is_completed'] == 1 ? 'lineThrough' : ''; ?>">
                                <td><?php echo $i; ?></td>
                                <td><a href="<?php echo base_url(); ?>backend/admin/todo/edit/<?php echo $row['todo_id']; ?>"><?php echo $row['todo_title']; ?></a></td>
                                <td><?php echo $row['is_completed'] == 1 ? '<span class="success">Completed</span>' : '<span class="error">Pending</span>'; ?></td>
                                <td>
                                    <a href="<?php echo base_url(); ?>backend/admin/todo/edit/<?php echo $row['todo_id']; ?>" class="btn btn-primary">Edit</a>
                                    <a href="<?php echo base_url(); ?>backend/admin/todo/delete/<?php echo $row['todo_id']; ?>" class="btn btn-danger" onClick="return confirm('Are you sure?');">Delete</a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

</section>