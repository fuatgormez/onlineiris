<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_service extends CI_Model 
{

	function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_service'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_auto_increment_id1()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_service_photo'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
	
    function show() {
        $sql = "SELECT * FROM tbl_service";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_all_photos_by_category_id($id)
    {
        $sql = "SELECT * 
    			FROM tbl_service_photo 
    			WHERE service_id=?";
        $query = $this->db->query($sql,array($id));
        return $query->result_array();
    }

    function add($data) {
        $this->db->insert('tbl_service',$data);
        return $this->db->insert_id();
    }

    function add_photos($data) {
        $this->db->insert('tbl_service_photo',$data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('id',$id);
        $this->db->update('tbl_service',$data);
    }

    function delete($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('tbl_service');
    }

    function delete_photos($id)
    {
        $this->db->where('service_id',$id);
        $this->db->delete('tbl_service_photo');
    }

    function getData($id)
    {
        $sql = 'SELECT * FROM tbl_service WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }

    function service_check($id)
    {
        $sql = 'SELECT * FROM tbl_service WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }

    function service_photo_by_id($id)
    {
        $sql = 'SELECT * FROM tbl_service_photo WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }
    
    function delete_service_photo($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('tbl_service_photo');
    }
    
}