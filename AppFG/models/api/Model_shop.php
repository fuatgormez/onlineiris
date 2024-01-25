<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_shop extends CI_Model
{
    public function get_order($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order WHERE order_number = ?";
        $query = $this->db->query($sql, $order_number);
        return $query->first_row('array');
    }
    public function get_order_item($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_item WHERE order_number = ?";
        $query = $this->db->query($sql, $order_number);
        return $query->result_array('array');
    }

    public function get_order_item_upload($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_item_upload WHERE order_number = ? AND is_selected = ? AND item_id_duplicated = ? AND is_completed_uniqid = ?";
        // $sql = "SELECT * FROM tbl_shop_order_item_upload WHERE order_number = ?";
        $query = $this->db->query($sql, array($order_number, 1, 0 ,0));
        return $query->result_array('array');
    }
    
    public function get_order_item_updated($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_item_updated WHERE order_number = ? AND is_updated = ?";
        $query = $this->db->query($sql, array($order_number, "update"));
        return $query->result_array('array');
    }

    public function get_order_item_extra($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_item_updated WHERE order_number = ? AND is_updated = ?";
        $query = $this->db->query($sql, array($order_number, "extra"));
        return $query->result_array('array');
    }

    public function get_order_item_with_name($order_number)
    {
        // $sql = "SELECT SUM(with_name_price) as with_name_price FROM tbl_shop_order_item_upload WHERE order_number = ?";
        // $query = $this->db->query($sql, array($order_number));
        // return $query->result_array('array');


        // $this->db->select("COUNT(item_upload_id) as v_count, SUM(with_name_price) as v_sum");
        // $this->db->where('order_number', $order_number);
        // return $this->db->get('tbl_shop_order_item_upload')->row();


        $sql = "SELECT COUNT(item_upload_id) as v_count, SUM(with_name_price) as v_sum FROM tbl_shop_order_item_upload WHERE order_number = ?";
        $query = $this->db->query($sql, $order_number);
        return $query->first_row();
    }

    public function order($security_number)
    {
        $sql = "SELECT * FROM tbl_shop_order WHERE security_number = ?";
        $query = $this->db->query($sql, $security_number);
        return $query->first_row();
    }

    function all_data($land_id, $lang)
    {
        $sql = "SELECT * 
        FROM tbl_shop_product_category t1
        JOIN tbl_shop_product_category_lang t2
        ON t1.category_id = t2.product_category_id
        JOIN tbl_shop_product t3
        ON t3.category_id = t1.category_id
        JOIN tbl_shop_product_lang t4
        ON t4.product_id = t3.id AND t4.lang_code = t2.lang_code

        WHERE t2.land_id = ? AND t2.lang_code = ? AND t1.status = ? AND t1.block_the_sale = ?";

        $query = $this->db->query($sql, array($land_id, $lang, 'Show', 'Yes'));
        return $query->result_array('array');
    }


    function single_product($id, $land_id = 16, $lang_code = "de")
    {
        $sql = "SELECT * 
        FROM tbl_shop_product t1
        JOIN tbl_shop_product_lang t2
        ON t1.id = t2.product_id
        WHERE t2.land_id = ? AND t2.lang_code = ? AND t1.id = ? AND t1.status = ?";

        $query = $this->db->query($sql, array($land_id, $lang_code, $id, "Show"));

        return $query->first_row('array');
    }
    // function single_product($id, $land_id = 16, $lang_code = "de")
    // {
    //     $sql = "SELECT * 
    //     FROM tbl_shop_product_category t1
    //     JOIN tbl_shop_product_category_lang t2
    //     ON t1.category_id = t2.product_category_id
    //     JOIN tbl_shop_product t3
    //     ON t3.category_id = t1.category_id
    //     JOIN tbl_shop_product_lang t4
    //     ON t4.product_id = t3.id AND t4.lang_code = t2.lang_code
    //     WHERE t2.land_id = ? AND t2.lang_code = ? AND t3.id = ? AND t3.status = ?";

    //     $query = $this->db->query($sql, array($land_id, $lang_code, $id, "Show"));

    //     return $query->first_row('array');
    // }

    public function all_product($land_id, $lang)
    {
        // $sql = "SELECT * 
		// 		FROM tbl_shop_product t1
		// 		JOIN tbl_shop_product_lang t2
		// 		ON t1.id = t2.product_id
		// 		WHERE t2.land_id = ? AND t2.lang_code = ? AND t1.status = ?
		// 		";
        // $query = $this->db->query($sql, array($land_id, $lang, 'Show'));
        // return $query->result_array();
        
        $sql = "SELECT * 
				FROM tbl_shop_product t1
				JOIN tbl_shop_product_lang t2
				ON t1.id = t2.product_id
                JOIN tbl_shop_product_category t3
                ON t3.category_id = t1.category_id
                JOIN tbl_shop_product_category_lang t4
                ON t4.product_category_id = t3.category_id
				WHERE t2.land_id = ? AND t2.lang_code = ? AND t1.status = ?";
        $query = $this->db->query($sql, array($land_id, $lang, 'Show'));
        return $query->result_array();
    }

    public function updatable_product($product_id, $land_id)
    {
        // $sql = "SELECT * FROM tbl_shop_product_allow WHERE product_id = ? AND FIND_IN_SET(?,allow_store)";
        $sql = "SELECT * FROM tbl_shop_product_allow WHERE product_id = ? AND JSON_CONTAINS(`allow_store`,'\"$land_id\"')";
        $query = $this->db->query($sql, array($product_id));
        return $query->result_array('array');
    }
    
    public function is_completed_item($order_number, $item_id, $item_uniqid, $data)
    {
        $this->db->where('order_number', $order_number);
        $this->db->where('item_product_id', $item_id);
        $this->db->where('item_uniqid', $item_uniqid);
        $this->db->update('tbl_shop_order_item', $data);
        return $this->db->affected_rows();
    }

    public function all_category($land_id, $lang)
    {
        $sql = "SELECT * 
                FROM tbl_shop_product_category t1
                JOIN tbl_shop_product_category_lang t2
                ON t2.product_category_id = t1.category_id
                WHERE t2.land_id = ? AND t2.lang_code = ? AND t1.status = ?
                ORDER BY t1.row ASC";
        $query = $this->db->query($sql, array($land_id, $lang, 'Show'));
        return $query->result_array();
    }

    public function check_payment_order_status($order_number, $paid_field)
    {
        $sql = "SELECT * FROM tbl_shop_order WHERE order_number = ? AND ? = ?";
        $query = $this->db->query($sql, array($order_number, $paid_field, $paid_field));
        return $query->first_row('array');
    }
    
    public function check_payment_order_status_single($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order WHERE order_number = ? AND paid = ?";
        $query = $this->db->query($sql, array($order_number, "isPaid"));
        return $query->first_row('array');
    }

    public function get_ordered_products_by_security_number_order($security_number)
    {
        $sql = "SELECT * FROM tbl_shop_order WHERE security_number = $security_number";
        $query = $this->db->query($sql);
        return $query->first_row('array');
    }

    public function get_ordered_products_by_security_number_item($security_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_item WHERE security_number = ? AND is_completed_uniqid = ?";
        $query = $this->db->query($sql,array($security_number,0));
        return $query->result_array();
    }

    public function get_ordered_products_by_uniqid_item($security_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_item WHERE item_uniqid = ?";
        $query = $this->db->query($sql, array($security_number));
        return $query->result_array('array');
    }
    
    public function is_completed_uniqid_item($order_number, $item_uniqid)
    {
        $sql = "SELECT * FROM tbl_shop_order_item WHERE item_uniqid = ? AND order_number = ? ";
        $query = $this->db->query($sql, array($item_uniqid,$order_number));
        return $query->result_array('array');
    }
    
    public function check_single_payment_order_status($order_number,$item_uniqid)
    {
        $sql = "SELECT * FROM tbl_shop_order_item WHERE order_number = ? AND item_uniqid = ?";
        $query = $this->db->query($sql,array($order_number,$item_uniqid));
        return $query->first_row('array');
    }
    
    public function check_single_payment_order_updated_status($order_number,$item_uniqid)
    {
        $sql = "SELECT * FROM tbl_shop_order_item_updated WHERE order_number = ? AND item_uniqid = ?";
        $query = $this->db->query($sql,array($order_number,$item_uniqid));
        return $query->first_row('array');
    }

    function update_order($order_number,$data)
    {
        $this->db->where('order_number',$order_number);
        $this->db->update('tbl_shop_order',$data);

        return $this->db->affected_rows();
    }
    
    function update_item_comment($order_number, $item_id, $item_uniqid, $data)
    {
        $this->db->where('order_number',$order_number);
        $this->db->where('item_product_id',$item_id);
        $this->db->where('item_uniqid',$item_uniqid);
        $this->db->update('tbl_shop_order_item',$data);

        return $this->db->affected_rows();
    }

    public function get_store($store_id)
    {
        $sql = "SELECT * FROM tbl_shop_store WHERE id = ?";
        $query = $this->db->query($sql, array($store_id));
        return $query->first_row('array');
    }

    public function xml_all_product($land_id, $lang_code)
    {
        $sql = "SELECT * 
				FROM tbl_shop_product t1
				JOIN tbl_shop_product_lang t2
				ON t1.id = t2.product_id
                JOIN tbl_shop_product_category t3
                ON t3.category_id = t1.category_id
                JOIN tbl_shop_product_category_lang t4
                ON t4.product_category_id = t3.category_id
				WHERE t2.land_id = ? AND t2.lang_code = ? AND t1.status = ? AND t1.block_the_sale = ? AND t4.land_id = ? AND t4.lang_code = ? AND t3.status = ? AND t3.block_the_sale = ?";
        $query = $this->db->query($sql, array($land_id, $lang_code, 'Show', 'Yes', $land_id, $lang_code, 'Show', 'Yes'));
        return $query->result_array();
    }
}
