<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_ticket extends CI_Model 
{
	function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_ticket'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_auto_increment_id1()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_ticket_photo'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
	
    function show() 
    {
        $sql = "SELECT * FROM tbl_ticket ORDER BY status DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function show_user_tickect($id) 
    {
        $sql = "SELECT * FROM tbl_ticket WHERE user_id = ? ORDER BY id ASC";
        $query = $this->db->query($sql,array($id));
        return $query->result_array();
    }

    function add($data)
    {
        $this->db->insert('tbl_ticket',$data);
        return $this->db->insert_id();
    }
    
    function add_detail($data)
    {
        $this->db->insert('tbl_ticket_detail',$data);
        return $this->db->insert_id();
    }

    function add_photos($data)
    {
        $this->db->insert('tbl_ticket_photo',$data);
        return $this->db->insert_id();
    }

    function update($id,$data)
    {
        $this->db->where('id',$id);
        $this->db->update('tbl_ticket',$data);
    }

    function delete($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('tbl_ticket');
    }
    
    function delete_detail($id)
    {
        $this->db->where('ticket_id',$id);
        $this->db->delete('tbl_ticket_detail');
    }

    function delete_photos($id)
    {
        $this->db->where('ticket_id',$id);
        $this->db->delete('tbl_ticket_photo');
    }

    function getData($id)
    {
        $sql = 'SELECT * FROM tbl_ticket WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }
    function get_detail($ticket_id)
    {
        $sql = 'SELECT * FROM tbl_ticket_detail WHERE ticket_id=? ORDER BY id DESC';
        $query = $this->db->query($sql,array($ticket_id));
        return $query->result_array();
    }

    function ticket_check($id)
    {
        $sql = 'SELECT * FROM tbl_ticket WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }

    function ticket_photo_by_id($id)
    {
        $sql = 'SELECT * FROM tbl_ticket_photo WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }
    
    function get_all_photos_by_ticket_id($ticket_id)
    {
        $sql = 'SELECT * FROM tbl_ticket_photo WHERE ticket_id=?';
        $query = $this->db->query($sql,array($ticket_id));
        return $query->result_array();
    }

    function delete_ticket_photo($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('tbl_ticket_photo');
    }

    function check_department($id)
    {
        $sql = "SELECT * FROM tbl_ticket_department WHERE department_id = ?";
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }
    
    function department()
    {
        $sql = "SELECT * FROM tbl_ticket_department";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function all_ticket_department()
    {
        $sql = "SELECT * FROM tbl_ticket_department WHERE status = ? ORDER BY row ASC";
        $query = $this->db->query($sql,array('Active'));
        return $query->result_array();
    }
    
}