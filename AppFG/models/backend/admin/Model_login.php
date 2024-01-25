<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_login extends CI_Model 
{

    public function get_setting_data()
    {
        $query = $this->db->query("SELECT * from tbl_settings WHERE id=1");
        return $query->first_row('array');
    }

    function check_user($username)
	{
        $where = array(
            'username' => $username
		);
		$this->db->select('*');
		$this->db->from('tbl_user');
		$this->db->where($where);
		$query = $this->db->get();
		return $query->first_row('array');
    }

    function check_password($data)
    {        
        $this->db->select('*');
        $this->db->from('tbl_user');
        $this->db->where($data);
        $query = $this->db->get();
        return $query->first_row('array');
    }

    function check_land($land_id)
    {        
        $sql = 'SELECT * FROM tbl_shop_store_value WHERE store_value_id=?';
        $query = $this->db->query($sql,array($land_id));
        return $query->first_row('array');
    
    }
    
    function get_all_land()
    {        
        $this->db->select('*');
        $this->db->from('tbl_shop_store_value');
        $this->db->where(array('status' => 'Show'));
        $query = $this->db->get();
        return $query->result_array();
    }

}