<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_contact extends CI_Model
{
    public function insert($data) {
        $this->db->insert('tbl_contact',$data);
        return $this->db->insert_id();
    }
}