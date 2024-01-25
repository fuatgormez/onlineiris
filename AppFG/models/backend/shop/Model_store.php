<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_store extends CI_Model
{

	function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_shop_store'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function get_store_value_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_shop_store_value'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
	
    function show() {
        $sql = "SELECT * FROM tbl_shop_store ORDER BY id ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function show_value() {
        $sql = "SELECT * FROM tbl_shop_store_value ORDER BY store_value_id ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function add($data) {
        $this->db->insert('tbl_shop_store',$data);
        return $this->db->insert_id();
    }

    function add_value($data) {
        $this->db->insert('tbl_shop_store_value',$data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('id',$id);
        $this->db->update('tbl_shop_store',$data);
    }

    function update_value($id,$data) {
        $this->db->where('store_value_id',$id);
        $this->db->update('tbl_shop_store_value',$data);
    }

    function delete($id)
    {
//        $this->db->where('id',$id);
//        $this->db->delete('tbl_shop_store');

        $this->db->delete('tbl_shop_store', array('id' =>$id));
        $this->db->delete('tbl_shop_product_lang', array('land_id' =>$id));
        $this->db->delete('tbl_shop_product_category_lang', array('land_id' =>$id));
    }

    function delete_value($id)
    {
        $this->db->where('store_value_id',$id);
        $this->db->delete('tbl_shop_store_value');
    }

    function get_store($id)
    {
        $sql = 'SELECT * FROM tbl_shop_store WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }
    
    function get_store_all($land_id)
    {
        $sql = 'SELECT * FROM tbl_shop_store  WHERE land_id=?';
        $query = $this->db->query($sql,array($land_id));
        return $query->result_array('array');
    }

    function get_store_value($id)
    {
        $sql = 'SELECT * FROM tbl_shop_store_value WHERE store_value_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }

    function store_check($id)
    {
        $sql = 'SELECT * FROM tbl_shop_store WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }

    function store_value_check($id)
    {
        $sql = 'SELECT * FROM tbl_shop_store_value WHERE store_value_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }
    
}