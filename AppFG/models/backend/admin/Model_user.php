<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_user extends CI_Model 
{

    function get_all_user() {
        $sql = "SELECT * FROM tbl_user";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_user_data ($id)
    {
        $sql = "SELECT * FROm tbl_user WHERE id = ?";
        $query = $this->db->query($sql,$id);
        return $query->first_row();
    }

    function user_check($id)
    {
        $sql = 'SELECT id FROM tbl_user WHERE id=?';
        $query = $this->db->query($sql,$id);
        return $query->first_row();
    }

    function add($data) {
        $this->db->insert('tbl_user',$data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('id',$id);
        $this->db->update('tbl_user',$data);
    }

    function delete($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('tbl_user');
    }
    
}