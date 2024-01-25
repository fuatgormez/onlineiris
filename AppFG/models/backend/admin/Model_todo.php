<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_todo extends CI_Model
{

    function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_todo'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function show() {
        $sql = "SELECT * FROM tbl_todo ORDER BY is_completed ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function add($data) {
        $this->db->insert('tbl_todo',$data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('todo_id',$id);
        $this->db->update('tbl_todo',$data);
    }

    function delete($id)
    {
        $this->db->where('todo_id',$id);
        $this->db->delete('tbl_todo');
    }

    function getData($id)
    {
        $sql = 'SELECT * FROM tbl_todo WHERE todo_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }

    function todo_check($id)
    {
        $sql = 'SELECT * FROM tbl_todo WHERE todo_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }

}