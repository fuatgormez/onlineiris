<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_faq extends CI_Model 
{
    public function all_faq()
    {
        $query = $this->db->query("SELECT * FROM tbl_faq WHERE show_on_home=? ORDER BY row, faq_title ASC","Yes");
        return $query->result_array();
    }
}