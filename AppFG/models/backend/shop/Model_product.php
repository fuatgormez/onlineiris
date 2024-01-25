<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_product extends CI_Model
{

    function get_auto_increment_id(){
        $sql = "SHOW TABLE STATUS LIKE 'tbl_shop_product'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_auto_increment_id1(){
        $sql = "SHOW TABLE STATUS LIKE 'tbl_shop_product_photo'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function show($lang="de") {
        $this->db->select("*");
        $this->db->from('tbl_shop_product t1');
        $this->db->join('tbl_shop_product_lang t2', 't1.id = t2.product_id');
        $this->db->join('tbl_shop_product_category t3', 't3.category_id = t1.category_id');
        $this->db->join('tbl_shop_product_category_lang t4', 't4.product_category_id = t3.category_id');
        $this->db->where('t2.lang_code', $lang);
        $this->db->where('t4.lang_code', $lang);

        $query = $this->db->get();
        return $query->result_array();

    }

    function get_all_photos_by_category_id($id){
        $sql = "SELECT * 
    			FROM tbl_shop_product_photo 
    			WHERE product_id=?";
        $query = $this->db->query($sql,array($id));
        return $query->result_array();
    }

    function get_all_product_category($land_id) {
        $sql = "SELECT * 
				FROM tbl_shop_product_category t1
				JOIN tbl_shop_product_category_lang t2
				ON t1.category_id = t2.product_category_id
                WHERE t2.land_id = ?
				ORDER BY t2.product_category_id ASC";
        $query = $this->db->query($sql,$land_id);
        return $query->result_array();
    }

    function add($data) {
        $this->db->insert('tbl_shop_product',$data);
        return $this->db->insert_id();
    }

    function add_lang($data) {
        $this->db->insert('tbl_shop_product_lang',$data);
        return $this->db->insert_id();
    }

    function add_photos($data) {
        $this->db->insert('tbl_shop_product_photo',$data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('id',$id);
        $this->db->update('tbl_shop_product',$data);
    }

    function update_lang($id,$data,$land_id) {
        //$where = "product_id=".$id." AND lang_code=".$lang_code;
//        $this->db->where('product_id',$id);
//        $this->db->where('lang_code',$lang_code);
//        $this->db->update('tbl_shop_product_lang',$data);

        $check_category = $this->product_lang_check($id,$land_id,$data['lang_code']);
        if($check_category){
            $this->db->where('product_id',$id);
            $this->db->where('land_id',$land_id);
            $this->db->update('tbl_shop_product_lang',$data);
        }else {
            $this->add_lang($data);
        }
    }
        
    function product_allow_check($product_id,$allow_product)
    {
        $sql = 'SELECT * FROM tbl_shop_product_allow WHERE product_id = ? AND allow_product=?';
        $query = $this->db->query($sql,array($product_id,$allow_product));
        return $query->num_rows();
    }

    function product_allow_insert($data) {
        $this->db->insert('tbl_shop_product_allow',$data);
        return $this->db->affected_rows();
    }

    function product_allow_update($product_id,$allow_product,$data) {
        $this->db->where('product_id',$product_id);
        $this->db->where('allow_product',$allow_product);
        $this->db->update('tbl_shop_product_allow',$data);
    }
    
    function product_allow_all() {
        $sql = "SELECT * FROM tbl_shop_product_allow";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function product_allow($product_id) {
        $sql = "SELECT * FROM tbl_shop_product_allow WHERE product_id = ?";
        $query = $this->db->query($sql,array($product_id));
        return $query->result_array();
    }
    
    function product_lang_check($product_id,$land_id,$lang_code)
    {
        $sql = 'SELECT * FROM tbl_shop_product_lang WHERE product_id = ? AND land_id=? AND lang_code=?';
        $query = $this->db->query($sql,array($product_id,$land_id,$lang_code));
        return $query->first_row('array');
    }

    function delete($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('tbl_shop_product');
    }

    function delete_photos($id)
    {
        $this->db->where('product_id',$id);
        $this->db->delete('tbl_shop_product_photo');
    }

    function get_all_product($land_id) {

        $this->db->select("*");
        $this->db->from('tbl_shop_product t1');
        $this->db->join('tbl_shop_product_lang t2', 't1.id = t2.product_id');
        $this->db->join('tbl_shop_product_category t3', 't3.category_id = t1.category_id');
        $this->db->join('tbl_shop_product_category_lang t4', 't4.product_category_id = t3.category_id');
        $this->db->where('t2.land_id', $land_id);
        $this->db->where('t4.land_id', $land_id);

        $query = $this->db->get();
        return $query->result_array();

    }

    function getSingleProduct($id)
    {
        $sql = "SELECT *
                FROM tbl_shop_product t1
                JOIN tbl_shop_product_lang t2
                ON t1.id = t2.product_id
                WHERE id=?";
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }
    
    function getSingleProductLang($id)
    {
        $sql = "SELECT *
                FROM tbl_shop_product t1
                JOIN tbl_shop_product_lang t2
                ON t1.id = t2.product_id
                WHERE id=?";
        $query = $this->db->query($sql,array($id));
        return $query->result_array();
    }

    function product_check($id)
    {
        $sql = "SELECT * FROM tbl_shop_product WHERE id=?";
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }

    function product_photo_by_id($id)
    {
        $sql = 'SELECT * FROM tbl_shop_product_photo WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }

    function delete_product_photo($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('tbl_shop_product_photo');
    }

    function getAllProductType ()
    {
        $sql = "SELECT * FROM tbl_shop_product_type";
        $query = $this->db->query($sql);
        return $query->result_array('array');
    }
    
    function getSingleProductType ($type_id)
    {
        $sql = "SELECT * FROM tbl_shop_product_type WHERE type_id = ?";
        $query = $this->db->query($sql,$type_id);
        return $query->first_row('array');
    }

    function product_type_check($type_id)
    {
        $sql = "SELECT * FROM tbl_shop_product_type WHERE type_id=?";
        $query = $this->db->query($sql,array($type_id));
        return $query->first_row('array');
    }

    function add_product_type($data) {
        $this->db->insert('tbl_shop_product_type',$data);
        return $this->db->insert_id();
    }

    function update_product_type($type_id,$data) {
        $this->db->where('type_id',$type_id);
        $this->db->update('tbl_shop_product_type',$data);
    }

    function delete_product_type($type_id)
    {
        $this->db->where('type_id',$type_id);
        $this->db->delete('tbl_shop_product_type');
    }
    
    function delete_allow_product($product_id,$product_allow)
    {
        $this->db->where('product_id',$product_id);
        $this->db->where('allow_product',$product_allow);
        $this->db->delete('tbl_shop_product_allow');
    }

}