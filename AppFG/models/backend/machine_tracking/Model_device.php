<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_device extends CI_Model
{

    function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_machine_tracking_device'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function show()
    {
        $sql = "SELECT * FROM tbl_machine_tracking_device ORDER BY id ASC";
        // $sql="SELECT STR_TO_DATE(updated_at, '%Y-%m-%d %T') AS CONVERTEDDATE FROM tbl_machine_tracking_device";
        // $sql = "SELECT TIMESTAMPDIFF(SECOND, updated_at, NOW()) FROM tbl_machine_tracking_device ORDER BY id ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function add($data)
    {
        $this->db->insert('tbl_machine_tracking_device', $data);
        return $this->db->insert_id();
    }

    function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('tbl_machine_tracking_device', $data);
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_machine_tracking_device');
    }

    function get_device($id)
    {
        $sql = 'SELECT * FROM tbl_machine_tracking_device WHERE id=?';
        $query = $this->db->query($sql, array($id));
        return $query->first_row('array');
    }

    function device_check($id)
    {
        $sql = 'SELECT * FROM tbl_machine_tracking_device WHERE id=?';
        $query = $this->db->query($sql, array($id));
        return $query->first_row('array');
    }

    function action($device_id,$data)
    {
        $this->db->where('id', $device_id);
        $this->db->update('tbl_machine_tracking_device', $data);
        return $this->db->affected_rows();
    }

    //datatable first step
    function ajax_device_totalRecordwithFilter ($searchQuery)
    {
        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        if ($searchQuery != '')
            $this->db->where($searchQuery);
        $records = $this->db->get('tbl_machine_tracking_device')->result();
        return $records[0]->allcount;
    }

    //datatable second step
    function ajax_device_records ($searchQuery,$columnName,$columnSortOrder,$rowperpage,$start)
    {

        // $sql = 'SELECT *, TIMESTAMPDIFF(SECOND,updated_at,CURRENT_TIMESTAMP) as fark from tbl_machine_tracking_device WHERE $searchQuery ORDER BY '.$columnName.', '.$columnSortOrder.' LIMIT '.$rowperpage.', '.$start;
        // $query = $this->db->query($sql);
        // return $query->result_array();
        
        ## Fetch records
        $this->db->select('*');

        if ($searchQuery != '')
            $this->db->where($searchQuery);

        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        return $this->db->get('tbl_machine_tracking_device')->result();
    }

    //datatable third step
    function ajax_device_totalRecords()
    {
        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $records = $this->db->get('tbl_machine_tracking_device')->result();
        return $records[0]->allcount;
    }

    function ajax_device($postData = null)
    {
        
    }
}
