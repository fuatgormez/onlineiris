<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_profile extends CI_Model 
{

    function update($id, $data) {
        $this->db->where('id',$id);
        $this->db->update('tbl_user',$data);
    }
    
}