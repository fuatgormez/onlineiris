<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_product_category extends CI_Model
{

	function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_shop_product_category'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_auto_increment_id1()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_shop_product_category_photo'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
	
    function show($lang_code) {
        $sql = "SELECT * 
				FROM tbl_shop_product_category t1
				JOIN tbl_shop_product_category_lang t2
				ON t1.category_id = t2.product_category_id
				WHERE t2.lang_code = ?
                ORDER BY t1.category_id ASC";
        $query = $this->db->query($sql, $lang_code);
        return $query->result_array();
    }

    function get_all_photos_by_category_id($id)
    {
        $sql = "SELECT * 
    			FROM tbl_shop_product_category_photo 
    			WHERE product_category_id=?";
        $query = $this->db->query($sql,array($id));
        return $query->result_array();
    }

    function add($data) {
        $this->db->insert('tbl_shop_product_category',$data);
        return $this->db->insert_id();
    }

    function add_lang($data) {
        $this->db->insert('tbl_shop_product_category_lang',$data);
        return $this->db->insert_id();
    }

    function add_photos($data) {
        $this->db->insert('tbl_shop_product_category_photo',$data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('category_id',$id);
        $this->db->update('tbl_shop_product_category',$data);
    }

    function update_lang($id,$data,$land_id) {

        $check_category = $this->product_category_lang_check($id,$land_id,$data['lang_code']);
        if($check_category){
            $this->db->where('product_category_id',$id);
            $this->db->where('land_id',$land_id);
            $this->db->update('tbl_shop_product_category_lang',$data);
        }else {
            $this->add_lang($data);
        }
    }

    function delete($id)
    {
        $this->db->where('category_id',$id);
        $this->db->delete('tbl_shop_product_category');
    }

    function delete_photos($id)
    {
        $this->db->where('product_category_id',$id);
        $this->db->delete('tbl_shop_product_category_photo');
    }

    function getData($id)
    {
        $sql = "SELECT *
                FROM tbl_shop_product_category t1
                JOIN tbl_shop_product_category_lang t2
                ON t1.category_id = t2.product_category_id
                WHERE t1.category_id=?";
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }

    function getDataAll($id)
    {
        $sql = "SELECT *
                FROM tbl_shop_product_category t1
                JOIN tbl_shop_product_category_lang t2
                ON t1.category_id = t2.product_category_id
                WHERE t1.category_id=?";
        $query = $this->db->query($sql,array($id));
        return $query->result_array();
    }

    function product_category_check($id)
    {
        $sql = 'SELECT * FROM tbl_shop_product_category WHERE category_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }
    function product_category_lang_check($category_id,$land_id,$lang_code)
    {
        $sql = 'SELECT * FROM tbl_shop_product_category_lang WHERE product_category_id = ? AND land_id=? AND lang_code=?';
        $query = $this->db->query($sql,array($category_id,$land_id,$lang_code));
        return $query->first_row('array');
    }

    function product_category_photo_by_id($id)
    {
        $sql = 'SELECT * FROM tbl_shop_product_category_photo WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }
    
    function delete_product_category_photo($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('tbl_shop_product_category_photo');
    }
    
}