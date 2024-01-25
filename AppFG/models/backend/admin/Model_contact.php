<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_contact extends CI_Model 
{

	public function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_contact'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
	
    public function show() {
        $sql = "SELECT * FROM tbl_contact ORDER BY id ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function add($data) {
        $this->db->insert('tbl_contact',$data);
        return $this->db->insert_id();
    }

    public function update($id,$data) {
        $this->db->where('id',$id);
        $this->db->update('tbl_contact',$data);
    }

    public function delete($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('tbl_contact');
    }

    public function get_contact($id)
    {
        $sql = 'SELECT * FROM tbl_contact WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }

    public function contact_check($id)
    {
        $sql = 'SELECT * FROM tbl_contact WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }
    
}