<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_coupon extends CI_Model
{
    public function create($data)
    {
        $this->db->insert('tbl_shop_coupon', $data);
        // return $this->db->insert_id();
        return $this->db->affected_rows();
    }

    function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('tbl_shop_coupon', $data);
    }
    
    function update_current_limit($coupon_code)
    {
        $this->db->where('code', $coupon_code);
        $this->db->set('current_limit', 'current_limit+1', FALSE);
        $this->db->update('tbl_shop_coupon');
    }
    
    function update_order($order_number,$data)
    {
        $this->db->trans_start();
        $this->db->where('order_number', $order_number);
        $this->db->update('tbl_shop_order', $data);
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function check_order($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order WHERE order_number = ? AND status = ?";
        $query = $this->db->query($sql,array($order_number,"Active"));
        return $query->first_row('array');
    }

    public function get_coupon_code($coupon_code)
    {
        $sql = "SELECT * FROM tbl_shop_coupon WHERE code = ?";
        $query = $this->db->query($sql, $coupon_code);
        return $query->first_row('array');
    }
    
    public function get_coupon_code_spend($coupon_code)
    {
        $sql = "SELECT * FROM tbl_shop_coupon WHERE code = ?";
        $query = $this->db->query($sql, $coupon_code);
        return $query->first_row('array');
    }
    
    public function get_coupon_groupon()
    {
        $sql = "SELECT * FROM tbl_shop_coupon WHERE amount = 39.00";
        $query = $this->db->query($sql);
        return $query->result_array('array');
    }
}
