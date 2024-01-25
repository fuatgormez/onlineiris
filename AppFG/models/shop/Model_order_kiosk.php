<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_order_kiosk extends CI_Model
{

    function get_store($store_id)
    {
        $sql = "SELECT * FROM tbl_shop_store WHERE id = ?";
        $query = $this->db->query($sql,$store_id);
        return $query->first_row('array');
    }

    function add_order($data)
    {
        $this->db->insert('tbl_shop_order', $data);
        // return $this->db->insert_id();
        return $this->db->affected_rows();
    }
    
    function add_order_item($items)
    {
        $this->db->insert('tbl_shop_order_item', $items);
        // return $this->db->insert_id();
        return $this->db->affected_rows(); 
    }
    
    function add_order_item_photo($data)
    {
        $this->db->insert('tbl_shop_order_item_upload', $data);
        return $this->db->affected_rows();
    }

    function update_order($order_number,$data)
    {
        $this->db->where('order_number',$order_number);
        $this->db->update('tbl_shop_order',$data);

        return $this->db->affected_rows();
    }
    
    function update_order_item_update($item_uniqid, $data)
    {
        $this->db->where('item_uniqid',$item_uniqid);
        $this->db->update('tbl_shop_order_item',$data);

        return $this->db->affected_rows();
    }

    function update_order_item_updated($item)
    {
        $this->db->insert('tbl_shop_order_item_updated', $item);
        return $this->db->insert_id();
    }

    function check_order_item($order_number)
    {
        $sql = 'SELECT * FROM tbl_shop_order_item WHERE order_number = ?';
        $query = $this->db->query($sql,$order_number);
        // return $query->first_row();
        return $this->db->affected_rows();
    }
    
    // function check_order_item_email($item_id, $order_number)
    // {
    //     $sql = 'SELECT item_id, order_number, email FROM tbl_shop_order_item WHERE item_id = ? AND order_number = ?';
    //     $query = $this->db->query($sql,array($item_id, $order_number));
    //     return $query->first_row('array');
    // }

    function check_order_item_uniqid($uniqid)
    {
        $sql = 'SELECT * FROM tbl_shop_order_item WHERE item_uniqid = ?';
        $query = $this->db->query($sql,$uniqid);
        return $query->first_row('array');
        // return $this->db->affected_rows();
    }
    
    function check_update_order_item_reset($item_id, $item_uniqid, $order_number,$data)
    {
        $this->db->where('item_id',$item_id);
        $this->db->where('item_uniqid',$item_uniqid);
        $this->db->where('order_number',$order_number);
        $this->db->update('tbl_shop_order_item',$data);

        return $this->db->affected_rows();
    }
    
    function check_update_order_item($item_uniqid)
    {
        $sql = 'SELECT * FROM tbl_shop_order_item WHERE item_uniqid = ?';
        $query = $this->db->query($sql,array($item_uniqid));
        return $query->first_row('array');
    }
    
    
    function check_update_order_item_updated($item_id,$item_old_id,$item_price,$order_number)
    {
        $sql = 'SELECT * FROM tbl_shop_order_item_updated WHERE item_id = ? AND item_id_old = ? AND item_price = ? AND order_number = ?';
        $query = $this->db->query($sql,array($item_id,$item_old_id,$item_price,$order_number));
        return $query->first_row('array');
    }

    function update_order_item_delete($item_uniqid)
    {
        $this->db->where('item_uniqid',$item_uniqid);
        $this->db->delete('tbl_shop_order_item_updated');
    }

    function update_order_item_upload_delete($item_uniqid, $image)
    {
        $this->db->where('item_uniqid',$item_uniqid);
        $this->db->where('image',$image);
        $this->db->delete('tbl_shop_order_item_upload');
    }

    // function update_order_item_with_name_price($data)
    // {
    //     $this->db->insert('tbl_shop_order_item_upload', $data);
    //     return $this->db->insert_id();
    // }
    
    function check_update_order_item_update_total($item_id_old,$order_number)
    {
        $sql = 'SELECT * FROM tbl_shop_order_item_updated WHERE item_id_old = ? AND order_number = ?';
        $query = $this->db->query($sql,array($item_id_old,$order_number));
        return $query->first_row('array');
    }
    
    function check_update_order_item_single_update_paid($item_uniqid ,$data)
    {
        $this->db->where('item_uniqid',$item_uniqid);
        $this->db->update('tbl_shop_order_item',$data);

        return $this->db->affected_rows();
    }

    function check_update_order_item_updated_single_update_paid($item_uniqid ,$data)
    {
        $this->db->where('item_uniqid',$item_uniqid);
        $this->db->update('tbl_shop_order_item_updated',$data);

        return $this->db->affected_rows();
    }


    function check_order($order_number)
    {
        //Bu kisma status eklenecek
        $sql = "SELECT * FROM tbl_shop_order WHERE order_number = ?";

        $query = $this->db->query($sql, array($order_number));
        return $query->first_row('array');
    }
    
    function confirmed_order($order_number,$data) {
        $this->db->trans_start();
        $this->db->where('order_number',$order_number);
        $this->db->update('tbl_shop_order',$data);
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

}