<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_email extends CI_Model
{
	
    function show($lang_code = 'de') {
        $sql = "SELECT * 
				FROM tbl_shop_email t1
				JOIN tbl_shop_email_lang t2
				ON t1.sku = t2.sku
				WHERE t2.lang_code = ?
                ORDER BY t1.id ASC";
        $query = $this->db->query($sql, $lang_code);
        return $query->result_array();
    }

    function get_all_photos_by_category_id($id)
    {
        $sql = "SELECT * 
    			FROM tbl_shop_email_photo 
    			WHERE product_category_id=?";
        $query = $this->db->query($sql,array($id));
        return $query->result_array();
    }

    function add($data) {
        $this->db->insert('tbl_shop_email',$data);
        return $this->db->insert_id();
    }

    function add_lang($data) {
        $this->db->insert('tbl_shop_email_lang',$data);
        return $this->db->insert_id();
    }

    function add_photos($data) {
        $this->db->insert('tbl_shop_email_photo',$data);
        return $this->db->insert_id();
    }

    function update($sku,$data) {
        $check_email = $this->email_check($sku);
        if($check_email > 0 ){
            $this->db->where('sku',$sku);
            $this->db->update('tbl_shop_email',$data);
        }
    }

    function update_lang($sku,$data,$store_id) {

        $check_email = $this->email_lang_check($sku,$store_id);
        if($check_email > 0 ){

            $array = array('sku' => $sku, 'store_id' => $store_id);
            $this->db->where($array);
            $this->db->update('tbl_shop_email_lang',$data);
        }else {
            $this->add_lang($data);
        }
    }

    function delete($sku)
    {
        $this->db->where('sku',$sku);
        $this->db->delete('tbl_shop_email');
        
        $this->db->where('sku',$sku);
        $this->db->delete('tbl_shop_email_lang');
    }

    function delete_photos($id)
    {
        $this->db->where('product_category_id',$id);
        $this->db->delete('tbl_shop_email_photo');
    }

    function getData($sku)
    {
        $sql = "SELECT *
                FROM tbl_shop_email t1
                JOIN tbl_shop_email_lang t2
                ON t1.sku = t2.sku
                WHERE t1.sku=?";
        $query = $this->db->query($sql,array($sku));
        return $query->first_row('array');
    }

    function getDataAll($sku)
    {
        $sql = "SELECT *
                FROM tbl_shop_email t1
                JOIN tbl_shop_email_lang t2
                ON t1.sku = t2.sku
                WHERE t1.sku=?";
        $query = $this->db->query($sql,array($sku));
        return $query->result_array();
    }

    function email_check($sku)
    {
        $sql = 'SELECT * FROM tbl_shop_email WHERE sku=?';
        $query = $this->db->query($sql,array($sku));
        return $query->num_rows();
    }

    function email_lang_check($sku,$store_id)
    {
        $sql = 'SELECT * FROM tbl_shop_email_lang WHERE sku = ? AND store_id = ?';
        $query = $this->db->query($sql,array($sku, $store_id));
        return $query->num_rows();
    }

    function email_photo_by_id($id)
    {
        $sql = 'SELECT * FROM tbl_shop_email_photo WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }
    
    function delete_email_photo($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('tbl_shop_email_photo');
    }
    
}