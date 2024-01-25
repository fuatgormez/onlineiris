<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_coupon extends CI_Model
{

    function check_coupon($coupon_code)
    {
        $sql = "SELECT * FROM tbl_shop_coupon WHERE coupon_code = ?";
        $query = $this->db->query($sql, array($coupon_code));
        return $query->first_row();
    }

    function add_coupon_spend($data) {
        $this->db->insert('tbl_shop_coupon_spend',$data);
        return $this->db->insert_id();
    }
    
    function update_coupon($coupon_code,$data)
    {
        $this->db->where('code', $coupon_code);
        $this->db->update('tbl_shop_coupon', $data);
        return $this->db->affected_rows();
    }
}
