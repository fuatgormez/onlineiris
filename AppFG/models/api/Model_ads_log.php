<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_ads_log extends CI_Model
{
    function insert($data)
    {
        $this->db->insert('tbl_ads_log', $data);
        return $this->db->insert_id();
    }  
    
    function show()
    {
        $sql = "SELECT * FROM tbl_ads_log ORDER BY id DESC LIMIT 250";
        $query = $this->db->query($sql);
        return $query->result_array('array');
    }  
    
}
