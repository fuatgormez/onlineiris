<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_setting_shop extends CI_Model 
{
    public function update($data)
	{
        $this->db->where('id',1);
        $this->db->update('tbl_settings_shop',$data);
    }
}