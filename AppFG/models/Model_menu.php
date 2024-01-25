<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_menu extends CI_Model 
{
    public function get_menu_category()
    {
        $query = $this->db->query("SELECT * FROM tbl_menu_category ORDER BY category_name ASC");
        return $query->result_array();
    }
    public function get_menu_data()
    {
        $query = $this->db->query("SELECT * from tbl_menu ORDER BY id DESC");
        return $query->result_array();
    }
    public function get_menu_data_order_by_name()
    {
        $query = $this->db->query("SELECT * from tbl_menu ORDER BY name ASC");
        return $query->result_array();
    }
    public function get_menu_detail($id) {
    	$sql = 'SELECT * FROM tbl_menu WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }
    public function get_menu_photo($id)
    {
        $query = $this->db->query("SELECT * from tbl_menu_photo WHERE menu_id=?",array($id));
        return $query->result_array();
    }
    public function get_menu_photo_number($id)
    {
        $query = $this->db->query("SELECT * from tbl_menu_photo WHERE menu_id=?",array($id));
        return $query->num_rows();
    }
}