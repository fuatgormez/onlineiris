<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_postfinance extends CI_Model
{
    function add($data)
    {
        $this->db->insert('tbl_shop_postfinance_payment', $data);
        return $this->db->insert_id();
    }
}
