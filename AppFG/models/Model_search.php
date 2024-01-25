<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_search extends CI_Model 
{
    public function search($search_string)
    {
        '%'. $search_string = '%' . $search_string . '%';
        $sql = "SELECT * 
                FROM tbl_service
                WHERE name like ? OR description like ?
                ORDER BY id DESC";
        $query = $this->db->query($sql,array($search_string,$search_string));
        return $query->result_array();
    }
    public function search_total($search_string)
    {
        $search_string = '%' . $search_string . '%';
        $sql = "SELECT * 
                FROM tbl_service
                WHERE name like ? OR description like ?
                ORDER BY id DESC";
        $query = $this->db->query($sql,array($search_string,$search_string));
        return $query->num_rows();
    }
}