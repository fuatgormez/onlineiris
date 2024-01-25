    <div class="page-content">  
        <div class="container fb">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" style="padding-left:20px">Light Gallery</h4>
                </div>
                <div class="card-body">
                    <div class="dz-lightgallery row g-2" id="lightgallery">
                        <?php foreach($photo as $row):?>
                        <a class="col-6" href="<?php echo base_url('public/uploads/photos/'.$row['photo_name']);?>">
                            <img src="<?php echo base_url('public/uploads/photos/'.$row['photo_name']);?>" alt="image">
                        </a>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>