<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_order extends CI_Model
{

    function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_shop_order'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_order()
    {
        $sql = "SELECT * FROM tbl_shop_order";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function get_order_note($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_note WHERE order_number = ?";
        $query = $this->db->query($sql, $order_number);
        return $query->result_array();
    }

    function get_order_customer_process($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_customer_process WHERE order_number = ? ORDER BY id DESC";
        $query = $this->db->query($sql, $order_number);
        return $query->result_array('array');
    }

    function get_order_paid_process($order_number)
    {
        $sql = "SELECT * from tbl_shop_order_paid_process WHERE order_number=?";
        $query = $this->db->query($sql, array($order_number));
        return $query->result_array('array');
    }

    function count_status_process($i)
    {
        $sql = "SELECT status_process FROM tbl_shop_order WHERE status_process = ?";
        $query = $this->db->query($sql, $i);
        return $query->num_rows();
    }
    
    function export_order_data_all()
    {
        $this->db->select('billing_email');
        return $this->db->get('tbl_shop_order')->result_array('array');
    }

    // function export_order_data($i = 0, $store_id = 0 , $land_id)
    // {
    //     $this->db->select('order_number, billing_email, store_name, total, date_purchased');
    //     if ($i != 0 && $store_id != 0)
    //         $this->db->where('status_process', $i);
    //         $this->db->where('store_id', $store_id);
    //         $this->db->where('land_id', $land_id);
    //     return $this->db->get('tbl_shop_order')->result_array('array');
    // }
    function export_get_all_orders($store_id, $status_id, $start_date, $end_date)
    {
        $this->db->select('*');
        $this->db->where('store_id', $store_id);
        $this->db->where('status_process', $status_id);
        // $this->db->where('order_type', $order_type);
        $this->db->where('paid', 'isPaid');
        $this->db->where('storno', 0);

        $this->db->where('DATE(date_purchased) >=', $start_date);
        $this->db->where('DATE(date_purchased) <=', $end_date);
        
        return $this->db->get('tbl_shop_order')->result('array');

        
    }

    function export_get_all_order_items($item_id, $start_date, $end_date)
    {
        $this->db->select('*');
        $this->db->where('item_product_id', $item_id);
        $this->db->where('DATE(created_at) >=', $start_date);
        $this->db->where('DATE(created_at) <=', $end_date);
        return $this->db->get('tbl_shop_order_item')->result('array');
    }
    
    function export_order_data_detail($order_number)
    {
        $this->db->select('*');
        $this->db->where('order_number', $order_number);
        return $this->db->get('tbl_shop_order_item')->result_array('array');
    }

    function show($status_process)
    {
        $sql = "SELECT * FROM tbl_shop_order WHERE status_process = ? ORDER BY order_id DESC LIMIT 500";
        $query = $this->db->query($sql, $status_process);
        return $query->result_array();
    }
    
    function get_order_pending()
    {
        $sql = "SELECT * FROM tbl_shop_order WHERE paid = ? ORDER BY order_id DESC";
        $query = $this->db->query($sql, 'isPending');
        return $query->result_array();
    }
    
    function get_order_storno()
    {
        $sql = "SELECT * FROM tbl_shop_order WHERE storno = ? ORDER BY order_id DESC";
        $query = $this->db->query($sql, 1);
        return $query->result_array();
    }

    function get_records($limit, $count)
    {
        return $this->db->limit($limit, $count)->get('tbl_shop_order')->result();
    }

    function get_count()
    {
        return $this->db->count_all('tbl_shop_order');
    }

    public function detail($order_id)
    {
        $sql = "SELECT * FROM tbl_shop_order WHERE order_id = ?";
        $query = $this->db->query($sql, $order_id);
        return $query->first_row('array');
    }

    function update($order_id, $data)
    {
        $this->db->where('order_id', $order_id);
        $this->db->update('tbl_shop_order', $data);
    }

    public function order_item($order_number)
    {
        // $sql = "SELECT * FROM 
        // tbl_shop_order_item t1
        // JOIN tbl_shop_order_item_upload t2
        // ON t1.item_id = t2.item_id
        // WHERE t1.order_number = ?";

        // $query = $this->db->query($sql,array($order_number));
        // return $query->result_array();

        $sql = "SELECT * FROM tbl_shop_order_item WHERE order_number = ?";
        $query = $this->db->query($sql, $order_number);
        return $query->result_array();
    }

    public function order_item_updated($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_item_updated WHERE order_number = ?";
        $query = $this->db->query($sql, $order_number);
        return $query->result_array('array');
    }

    public function order_item_upload($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_item_upload WHERE order_number = ?";
        $query = $this->db->query($sql, $order_number);
        return $query->result_array('array');
    }

    public function order_item_upload_with_uniqid($order_number,$uniqid)
    {
        $sql = "SELECT order_number, item_uniqid FROM tbl_shop_order_item_upload WHERE order_number = ? AND item_uniqid = ?";
        $query = $this->db->query($sql, array($order_number, $uniqid));
        return $query->result_array('array');
    }

    public function order_item_upload_done($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_item_upload_done WHERE order_number = ?";
        $query = $this->db->query($sql, $order_number);
        return $query->result_array('array');
    }

    function delete_order_items_excluded($order_id, $order_number)
    {
        return $this->db->delete('tbl_shop_order', array('order_id' => $order_id, 'order_number' => $order_number));
    }
    
    function delete($order_id, $order_number)
    {
        $this->db->delete('tbl_shop_order', array('order_id' => $order_id, 'order_number' => $order_number));
        $this->db->delete('tbl_shop_order_note', array('order_number' => $order_number));
        $this->db->delete('tbl_shop_order_item', array('order_number' => $order_number));
        $this->db->delete('tbl_shop_order_item_updated', array('order_number' => $order_number));
        $this->db->delete('tbl_shop_order_item_upload', array('order_number' => $order_number));
        $this->db->delete('tbl_shop_order_item_upload_done', array('order_number' => $order_number));
        $this->db->delete('tbl_shop_order_paid_process', array('order_number' => $order_number));
        $this->db->delete('tbl_shop_order_payment_history', array('order_number' => $order_number));
    }

    function order_check($order_id, $order_number)
    {
        $sql = 'SELECT * FROM tbl_shop_order WHERE order_id = ? AND order_number = ?';
        $query = $this->db->query($sql, array($order_id, $order_number));
        return $query->first_row('array');
    }

    function order_freigabe_access()
    {
        $check_order = $this->Model_order->show();

        if ($check_order) {
            echo "order var";
        }
    }

    function delete_order_item($item_id, $order_number)
    {
        $this->db->delete('tbl_shop_order_item', array('item_id' => $item_id, 'order_number' => $order_number));
        $this->db->delete('tbl_shop_order_item_updated', array('item_id' => $item_id, 'order_number' => $order_number));
        $this->db->delete('tbl_shop_order_item_upload', array('item_id' => $item_id, 'order_number' => $order_number));
        // $this->db->delete('tbl_shop_order_item', array('order_number' => $order_number));
    }

    function get_before_delete_upload($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_item_upload WHERE order_number = ?";
        $query = $this->db->query($sql, array($order_number));
        return $query->result_array();
    }

    function get_before_delete_upload_done($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_item_upload_done WHERE order_number = ?";
        $query = $this->db->query($sql, array($order_number));
        return $query->result_array();
    }

    public function sum_order_total($store_id, $order_type, $start_date, $end_date)
    {
        $this->db->select_sum('total')
        ->where('order_type', $order_type)
        ->where('paid', 'paid')
        ->where('storno', 0)
        ->where('store_id', $store_id)
        ->where('DATE(date_purchased) >=', $start_date . " 00:00:00")
        ->where('DATE(date_purchased) <=', $end_date . " 00:00:00");
        
        return $this->db->get('tbl_shop_order')->result('array');
    }

    function get_best_week_in_range($rep_id, $start_date, $end_date) {
        $this->db->select_sum('sales_quantity', 'weekly_total')
                 ->from('sales')
                 ->where('sale_rep_id', $rep_id)
                 ->where('date >=', $start_date)
                 ->where('date <=', $end_date)
                 ->group_by('WEEK(date)')
                 ->order_by('weekly_total', 'DESC')
                 ->limit(1);
       $query = $this->db->get();
       return $query->row('weekly_total');
   }

    function sum_order_total_old($store_id, $order_type)
    {
        $sql = "SELECT SUM(total) as total, SUM(total_update) as total_update FROM tbl_shop_order WHERE store_id = ? AND order_type = ? AND paid = ? AND storno = ?";
        $query = $this->db->query($sql, array($store_id, $order_type, 'isPaid', 0));
        return $query->result_array();
    }

    //datatable first step
    function ajax_order_totalRecordwithFilter($searchQuery)
    {
        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        if ($searchQuery != '')
            $this->db->where($searchQuery);
        $records = $this->db->get('tbl_shop_order')->result();
        return $records[0]->allcount;
    }

    //datatable second step
    function ajax_order_records($status_process, $searchQuery, $columnName, $columnSortOrder, $rowperpage, $start)
    {
        // $sql = 'SELECT *, TIMESTAMPDIFF(SECOND,updated_at,CURRENT_TIMESTAMP) as fark from tbl_machine_tracking_device WHERE $searchQuery ORDER BY '.$columnName.', '.$columnSortOrder.' LIMIT '.$rowperpage.', '.$start;
        // $query = $this->db->query($sql);
        // return $query->result_array();

        ## Fetch records
        $this->db->select('*');

        if ($searchQuery != '')
            $this->db->where($searchQuery);
        
        $this->db->where($status_process);

        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        return $this->db->get('tbl_shop_order')->result();
    }

    //datatable third step
    function ajax_order_totalRecords()
    {
        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $records = $this->db->get('tbl_shop_order')->result();
        return $records[0]->allcount;
    }

    public function check_unuploaded_order()
    {
        $sql = "SELECT order_number,store_id FROM tbl_shop_order WHERE status = ? AND storno = ? AND status_process != ?";
        $query = $this->db->query($sql, array('Active', 0, 9));
        return $query->result_array();
    }

    public function check_unuploaded_order_req($order_number, $store_id)
    {
        $sql = "SELECT order_number,store_id FROM tbl_shop_order_item_re_upload WHERE order_number = ? AND store_id = ?";
        $query = $this->db->query($sql, array($order_number, $store_id));
        return $query->result_array();
        // return $query->num_rows();
    }

    public function add_unuploaded_order_req($data)
    {
        $this->db->insert('tbl_shop_order_item_re_upload', $data);
        return $this->db->insert_id();
    }
}
