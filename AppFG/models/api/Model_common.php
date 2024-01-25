<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_common extends CI_Model
{
    public function settings()
    {
        $sql = "SELECT * FROM tbl_settings";
        $query = $this->db->query($sql);
        return $query->first_row();
    }
}
