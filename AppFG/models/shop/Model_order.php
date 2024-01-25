<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_order extends CI_Model
{

    function mollie($data)
    {
        $this->db->insert('tbl_shop_order_mollie', $data);
        return $this->db->insert_id();
    }

    function add($data)
    {
        $this->db->insert('tbl_shop_order', $data);

        $this->add_payment_history($data);

        return $this->db->insert_id();
    }

    function add_payment_history($data)
    {
        $this->db->insert('tbl_shop_order_payment_history', $data);
        return $this->db->insert_id();
    }

    function add_order_item($item)
    {
        $this->db->insert('tbl_shop_order_item', $item);
        return $this->db->insert_id();
    }

    /**
     * customer order confirm
     *
     * @param [5] //resim bitmis ise musterinin onune getir(finished photoshop)
     * @return string
     */
    function check_order($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order WHERE order_number = ? AND status_process = ?";
        $query = $this->db->query($sql, array($order_number,5));
        return $query->first_row();
    }

    function get_order($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order WHERE order_number = ?";
        $query = $this->db->query($sql, array($order_number));
        return $query->first_row('array');
        // return $this->db->affected_rows();
    }

    function mollie_webhook($data)
    {
        $this->db->insert('ci_sessions', $data);
        return $this->db->insert_id();
    }

    function get_order_item($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_item WHERE order_number = ?";
        $query = $this->db->query($sql, array($order_number));
        return $query->result_array();
    }

    function all_get_order()
    {
        $sql = "SELECT * FROM tbl_shop_order";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function last_get_order($limit)
    {
        $this->db->from('tbl_shop_order');
        $this->db->order_by("order_id", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function check_order_item($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_item WHERE order_number = ?";
        $query = $this->db->query($sql, array($order_number));
        return $query->result_array();
    }
    
    function check_order_item_with_id_order_number($id, $order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_item WHERE item_product_id = ? AND order_number = ?";
        $query = $this->db->query($sql, array($id, $order_number));
        return $query->first_row('array');
    }

    function check_order_item_with_uniqid($item_uniqid)
    {
        $sql = "SELECT * FROM tbl_shop_order_item WHERE item_uniqid = ?";
        $query = $this->db->query($sql, array($item_uniqid));
        return $query->first_row('array');
    }
    
    function check_order_item_single($order_number, $item_id)
    {
        $sql = "SELECT * FROM tbl_shop_order_item WHERE order_number = ? AND item_product_id = ?";
        $query = $this->db->query($sql, array($order_number, $item_id));
        return $query->first_row('array');
    }

    function check_update_order_item_updated($item_id,$item_old_id,$item_price,$order_number)
    {
        $sql = 'SELECT * FROM tbl_shop_order_item_updated WHERE item_id = ? AND item_id_old = ? AND item_price = ? AND order_number = ?';
        $query = $this->db->query($sql,array($item_id,$item_old_id,$item_price,$order_number));
        return $query->first_row('array');
    }

    function update_order_item_updated($item)
    {
        $this->db->insert('tbl_shop_order_item_updated', $item);
        return $this->db->insert_id();
    }

    function update_order_item_update($item_uniqid, $data)
    {
        $this->db->where('item_uniqid',$item_uniqid);
        $this->db->update('tbl_shop_order_item',$data);

        return $this->db->affected_rows();
    }

    function update_order_item_delete($item_uniqid)
    {
        $this->db->where('item_uniqid',$item_uniqid);
        $this->db->delete('tbl_shop_order_item_updated');
    }

    function check_update_order_item_reset($item_id, $item_uniqid, $order_number,$data)
    {
        $this->db->where('item_id',$item_id);
        $this->db->where('item_uniqid',$item_uniqid);
        $this->db->where('order_number',$order_number);
        $this->db->update('tbl_shop_order_item',$data);

        return $this->db->affected_rows();
    }
    
    function get_order_image_upload($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_item_upload WHERE order_number = ?";
        $query = $this->db->query($sql, $order_number);
        return $query->result_array('array');
    }
    
    function get_order_image($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_item_upload_done WHERE order_number = ?";
        $query = $this->db->query($sql, $order_number);
        return $query->result_array('array');
    }

    function confirm_order($data)
    {
        $this->db->insert('tbl_shop_order_customer_process', $data);
        return $this->db->affected_rows();
    }
    
    function update_order($order_number, $data)
    {
        $this->db->where('order_number', $order_number);
        $this->db->update('tbl_shop_order', $data);
        return $this->db->affected_rows();
    }

    public function photoshop_upload($data)
    {
        $this->db->insert('tbl_shop_order_item_upload', $data);
        // $this->db->insert('tbl_shop_order_item_upload_done', $data);
        return $this->db->affected_rows();
    }

    public function daily_order_sum()
    {
        $this->db->select_sum('total');
        $this->db->where("date_purchased >", 'CURDATE()', FALSE);
        $query = $this->db->get('tbl_shop_order');
        return $query->row_array();
    }

    public function isPaid_order($order_number)
    {
        $sql = 'SELECT * FROM tbl_shop_order WHERE order_number = ? AND paid = ?';
        $query = $this->db->query($sql,array($order_number, 'paid'));
        return $query->first_row('array');
    }
}
