<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_device extends CI_Model
{
    public function get_device($kiosk_id)
    {
        $sql = "SELECT * FROM tbl_machine_tracking_device WHERE kiosk_id = ?";
        $query = $this->db->query($sql, $kiosk_id);
        return $query->first_row('array');
    }
    
    function update_device($kiosk_id,$data)
    {
        $this->db->where('kiosk_id',$kiosk_id);
        $this->db->update('tbl_machine_tracking_device',$data);

        return $this->db->affected_rows();
    }
    
}
