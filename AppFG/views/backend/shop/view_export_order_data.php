<section class="content-header">
    <div class="content-header-left">
        <h1>Export Order Data with Order Process Id & Store Id</h1>
    </div>
    <div class="content-header-right">
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-body table-responsive">
                    <div class="row">
                        <div class="col-md-2">
                            <label>Order Process</label>
                            <select class="form-control status_id">
                                    <option value="0">All</option>
                                <?php foreach($setting_shop_order_status as $row_order_status):?>
                                    <option value="<?php echo $row_order_status['status'];?>"><?php echo $row_order_status['text'];?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Select Store</label>
                            <select class="form-control store_id">
                                <?php foreach($get_store_all as $row_store):?>
                                    <option value="<?php echo $row_store['id'];?>"><?php echo $row_store['store_name'];?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="product">Item</label>
                            <select class="form-control item_id" id="product">
                                    <option value="0">All</option>
                                <?php foreach($products as $row_product):?>
                                    <option value="<?php echo $row_product['product_id'];?>"><?php echo $row_product['product_name'];?> (<?php echo $row_product['product_id'];?>)</option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="start_date">Start Date</label>
                            <input type="date" id="start_date" class="form-control order_start_date" value="<?php echo date('Y-m-d');?>">
                        </div>
                        <div class="col-md-2">
                            <label for="end_date">End Date</label>
                            <input type="date" id="end_date" class="form-control order_end_date" value="<?php echo date('Y-m-d');?>">
                        </div>
                        <div class="col-md-12" style="margin-top:20px">
                            <a class="btn btn-block btn-primary export_order_data">Get Data</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-body table-responsive">
                <div class="loader" style="display:none">
                    <svg version="1.1" width="50" id="L9" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                        <path fill="#ddd" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                            <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="0.4s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
                        </path>
                    </svg>
                </div>
                    <div class="export_order_data_list" id="copyClipboardData"></div>
                    <p></p>
                    <button class="btn btn-warning copyClipboard" data-clipboard-target="#copyClipboardData">COPY ALL DATA</button>
                    <span class="btn btn-success total">Total Result: 0</span>
                </div>
            </div>
       </div>
    </div>
</section>


<div class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody class="export_order_data_list_detail">
                                    
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>