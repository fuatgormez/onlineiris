<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_social_media extends CI_Model 
{

    protected $table_name = 'tbl_social';

    function show() {
        $sql = "SELECT * FROM " . $this->table_name;
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function update($social_name,$data) {
        $this->db->where('social_name',$social_name);
        $this->db->update($this->table_name,$data);
    }
    
}