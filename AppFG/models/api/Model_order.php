<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_order extends CI_Model
{
    // public function get_order_status($land_id,$store_id)
    // {
    //     $sql = "SELECT * 
    //     FROM tbl_shop_order t1
    //     JOIN tbl_shop_order_item t2
    //     ON t1.order_number = t2.order_number
    //     WHERE t1.land_id = ? AND t1.store_id = ? AND t1.status = ?";

    //     $query = $this->db->query($sql, array($land_id, $store_id, 'Active'));
    //     return $query->result_array('array');
    // }

    public function get_order($land_id, $store_id)
    {
        $sql = "SELECT * FROM tbl_shop_order WHERE land_id = ? AND store_id = ? AND status = ?";
        $query = $this->db->query($sql,array($land_id, $store_id ,'Active'));
        return $query->result_array();
    }

    public function get_order_item($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_item WHERE order_number = ?";
        $query = $this->db->query($sql,array($order_number));
        return $query->result_array();
    }
}
