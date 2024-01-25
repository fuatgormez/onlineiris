<section class="content-header">
    <div class="content-header-left">
        <h1>Add TODO</h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url(); ?>backend/admin/todo" class="btn btn-primary btn-sm">View All</a>
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

            <?php echo form_open(base_url().'backend/admin/todo/edit/'.$todo['todo_id'],array('class' => 'form-horizontal', 'name' => 'form1')); ?>
            <div class="box box-info">
                <div class="box-body">
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">TODO Title <span>*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="todo_title" value="<?php echo $todo['todo_title']?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">TODO Content <span>*</span></label>
                        <div class="col-sm-9">
                            <textarea class="form-control editor" name="todo_content"><?php echo $todo['todo_content']?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label"></label>
                        <div class="col-sm-6">
                            <input type="checkbox" id="is_completed" name="is_completed" <?php echo $todo['is_completed'] == 1 ? 'checked' : '' ;?>>                            
                            <label for="is_completed" class="control-label">Completed</label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label"></label>
                        <div class="col-sm-6">
                            <button type="submit" name="form1" class="btn btn-success pull-left">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>