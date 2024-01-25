<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_notification extends CI_Model 
{

	function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_notification'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
	
    function show() {
        $sql = "SELECT * FROM tbl_notification ORDER BY id ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function add($data) {
        $this->db->insert('tbl_notification',$data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('id',$id);
        $this->db->update('tbl_notification',$data);
    }

    function delete($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('tbl_notification');
    }

    function get_notification($id)
    {
        $sql = 'SELECT * FROM tbl_notification WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }

    function notification_check($id)
    {
        $sql = 'SELECT * FROM tbl_notification WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }

    function get_all_user()
    {
        $sql = 'SELECT * FROM tbl_user';
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function get_all_user_group()
    {
        $sql = 'SELECT * FROM tbl_user_group';
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
}