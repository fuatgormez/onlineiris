<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_coupon extends CI_Model
{

    function show()
    {
        $sql = "SELECT * FROM tbl_shop_coupon ORDER BY id ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function add($data)
    {
        $this->db->insert('tbl_shop_coupon', $data);
        return $this->db->insert_id();
    }

    function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('tbl_shop_coupon', $data);
    }

    function getData($id)
    {
        $sql = 'SELECT * FROM tbl_shop_coupon WHERE id=?';
        $query = $this->db->query($sql, array($id));
        return $query->first_row('array');
    }

    public function delete($coupon_id)
    {
        $this->db->delete('tbl_shop_coupon', array('id' => $coupon_id));
    }

    public function coupon_check($coupon_id)
    {
        $sql = 'SELECT * FROM tbl_shop_coupon WHERE id=?';
        $query = $this->db->query($sql, array($coupon_id));
        return $query->first_row('array');
    }

    //datatable first step
    function ajax_coupon_totalRecordwithFilter($searchQuery)
    {
        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        if ($searchQuery != '')
            $this->db->where($searchQuery);
        $records = $this->db->get('tbl_shop_coupon')->result();
        return $records[0]->allcount;
    }

    //datatable second step
    function ajax_coupon_records($searchQuery, $columnName, $columnSortOrder, $rowperpage, $start)
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
        return $this->db->get('tbl_shop_coupon')->result();
    }

    //datatable third step
    function ajax_coupon_totalRecords()
    {
        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $records = $this->db->get('tbl_shop_coupon')->result();
        return $records[0]->allcount;
    }
}
