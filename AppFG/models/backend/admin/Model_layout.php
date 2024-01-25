<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_layout extends CI_Model
{

    function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_layout'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function show() {
        $sql = "SELECT * FROM tbl_layout ORDER BY layout_id ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function add($data) {
        $this->db->insert('tbl_layout',$data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('layout_id',$id);
        $this->db->update('tbl_layout',$data);
    }

    function delete($id)
    {
        $this->db->where('layout_id',$id);
        $this->db->delete('tbl_layout');
    }

    function getData($id)
    {
        $sql = 'SELECT * FROM tbl_layout WHERE layout_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }

    function layout_check($id)
    {
        $sql = 'SELECT * FROM tbl_layout WHERE layout_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }

}