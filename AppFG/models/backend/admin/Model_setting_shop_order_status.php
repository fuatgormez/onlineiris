<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_setting_shop_order_status extends CI_Model 
{
    public function update($id, $data)
	{
        $this->db->where('id', $id);
        $this->db->update('tbl_settings_shop_order_status',$data);
    }
}