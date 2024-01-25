<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{
    public $mollie;

    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('id')) {
            redirect(base_url() . 'backend/admin/login');
        }

        $this->load->model('backend/admin/Model_common');
        $this->load->model('backend/shop/Model_store');
        $this->load->model('backend/shop/Model_order');
        $this->load->model('backend/shop/Model_product_category');
        $this->load->model('backend/shop/Model_product');
        $this->load->library('logger/logger');
        $this->load->library('slug');

        $data['setting'] = $this->Model_common->get_setting_data();

        if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) {
            if ($data['setting']['website_status_backend'] === "Passive") {
                $data['message'] = $data['setting']['website_status_backend_message'];
                redirect(base_url('backend/info'));
            }
        }
    }

    public function index($status_process = 1)
    {
        $data['setting'] = $this->Model_common->get_setting_data();
        $data['setting_shop_order_status'] = $this->Model_common->get_setting_shop_order_status();


        if($status_process === 'pending'){
            $data['order'] = $this->Model_order->get_order_pending();
        } elseif($status_process === 'storno'){
            $data['order'] = $this->Model_order->get_order_storno();
        } else {
            $data['order'] = $this->Model_order->show($status_process);
        }


        //bu kisma (for) sonra tekrar bak
        for ($i = 1; $i < 14; $i++) {
            $data['count_status_process'][] = array(
                $i => $this->Model_order->count_status_process($i)
            );
        }

        $data['status_process_color'] = "";

        foreach ($data['setting_shop_order_status'] as $row_status_process) {
            if ($status_process == $row_status_process['status']) {
                $data['status_process_color'] = $row_status_process['color'];
            }
        }

        // echo $data['count_status_process'][0][1];exit;
        // print_r($data['count_status_process']);exit;

        $this->load->view('backend/admin/view_header', $data);
        $this->load->view('backend/shop/view_order', $data);
        $this->load->view('backend/admin/view_footer');
    }

    public function detail($order_id, $order_number)
    {

        $data['setting'] = $this->Model_common->get_setting_data();

        $data['order_detail'] = $this->Model_order->detail($order_id);
        if (empty($data['order_detail']))
            redirect(base_url('backend/shop/order'));


        $data['setting_shop_order_status'] = $this->Model_common->get_setting_shop_order_status();

        $data['status_process_color'] = "";

        foreach ($data['setting_shop_order_status'] as $row_status_process) {
            if ($data['order_detail']['status_process'] == $row_status_process['status']) {
                $data['status_process_color'] = $row_status_process['color'];
            }
        }

        $data['order_item'] = $this->Model_order->order_item($order_number);

        if (empty($data['order_item']))
            redirect(base_url('backend/shop/order'));


        $data['order_item_updated'] = $this->Model_order->order_item_updated($order_number);
        $data['order_item_upload'] = $this->Model_order->order_item_upload($order_number);
        $data['order_item_upload_done'] = $this->Model_order->order_item_upload_done($order_number);

        $data['get_order_note'] = $this->Model_order->get_order_note($order_number);
        $data['get_order_customer_process'] = $this->Model_order->get_order_customer_process($order_number);
        $data['get_order_paid_process'] = $this->Model_order->get_order_paid_process($order_number);

        $data['total'] = $data['order_detail']['total'] + $data['order_detail']['total_update'];


        if ($data['order_detail']['paid'] === "isPaid") {
            $data['o_zwischensumme'] = $data['order_detail']['total'];
            $data['o_bereit_bezahlt'] = $data['order_detail']['total'];
            $data['o_rabattbetrag'] = $data['order_detail']['discount_amount'];
            $data['o_shipping'] = $data['order_detail']['shipping_total'];
            $data['o_zu_zahlen'] = 0;
        } else {
            $data['o_zwischensumme'] = $data['order_detail']['total'];
            $data['o_bereit_bezahlt'] = 0;
            $data['o_rabattbetrag'] = 0;
            $data['o_shipping'] = $data['order_detail']['shipping_total'];
            $data['o_zu_zahlen'] = $data['order_detail']['total'];
        }

        if ($data['order_detail']['paid_update'] === "isPaid") {
            $data['u_zwischensumme'] = $data['order_detail']['total_update'];
            $data['u_bereit_bezahlt'] = $data['order_detail']['total_update'];
            $data['u_rabattbetrag'] = $data['order_detail']['discount_amount'];
            $data['u_shipping'] = $data['order_detail']['shipping_total'];
            $data['u_zu_zahlen'] = 0;
        } else {
            $data['u_zwischensumme'] = $data['order_detail']['total_update'];
            $data['u_bereit_bezahlt'] = 0;
            $data['u_rabattbetrag'] = 0;
            $data['u_shipping'] = $data['order_detail']['shipping_total'];
            $data['u_zu_zahlen'] = $data['order_detail']['total_update'];
        }

        $data['zahlen'] = ($data['o_zu_zahlen'] - $data['order_detail']['discount_amount']) + $data['u_zu_zahlen'];

        $this->load->view('backend/admin/view_header', $data);
        $this->load->view('backend/shop/view_order_detail', $data);
        $this->load->view('backend/admin/view_footer');
    }

    public function update($order_id = 0, $order_number = 0)
    {

        $data['setting'] = $this->Model_common->get_setting_data();

        $data['order_detail'] = $this->Model_order->detail($order_id);
        $data['order_item'] = $this->Model_order->order_item($order_number);


        $error = '';
        $message = '';

        if (isset($_POST['form1'])) {

            $valid = 1;

            $this->form_validation->set_rules('billing_firstname', 'First Name', 'required');
            $this->form_validation->set_rules('billing_lastname', 'Last Name', 'required');
            $this->form_validation->set_rules('billing_phone', 'Phone', 'required');
            $this->form_validation->set_rules('billing_email', 'Email', 'required');
            $this->form_validation->set_rules('billing_street', 'Street', 'required');
            $this->form_validation->set_rules('billing_postcode', 'Postcode', 'required');
            $this->form_validation->set_rules('billing_city', 'City', 'required');
            $this->form_validation->set_rules('billing_country', 'Country', 'required');

            if ($this->form_validation->run() == FALSE) {
                $valid = 0;
                $error .= validation_errors();
            }

            if ($valid == 1) {

                $form_data = array(
                    'billing_firstname'  => $this->input->post('billing_firstname'),
                    'billing_lastname'  => $this->input->post('billing_lastname'),
                    'billing_phone'  => $this->input->post('billing_phone'),
                    'billing_email'  => $this->input->post('billing_email'),
                    'billing_street'  => $this->input->post('billing_street'),
                    'billing_street_no'  => $this->input->post('billing_street_no'),
                    'billing_postcode'  => $this->input->post('billing_postcode'),
                    'billing_city'  => $this->input->post('billing_city'),
                    'billing_country'  => $this->input->post('billing_country'),

                    'shipping_firstname'  => $this->input->post('shipping_firstname'),
                    'shipping_lastname'  => $this->input->post('shipping_lastname'),
                    'shipping_phone'  => $this->input->post('shipping_phone'),
                    'shipping_email'  => $this->input->post('shipping_email'),
                    'shipping_street'  => $this->input->post('shipping_street'),
                    'shipping_street_no'  => $this->input->post('shipping_street_no'),
                    'shipping_postcode'  => $this->input->post('shipping_postcode'),
                    'shipping_city'  => $this->input->post('shipping_city'),
                    'shipping_country'  => $this->input->post('shipping_country'),

                    'status'  => $this->input->post('status'),
                    'order_type'  => $this->input->post('order_type')
                );

                $this->Model_order->update($this->input->post('order_id'), $form_data);

                $message = 'Order is updated successfully!';
                $this->session->set_flashdata('success', $message);

                $this->logger->user($this->session->userdata('username'))->type('Order Update')->id(1)->token(sha1(mt_rand()))->comment($message . ' order_id -> ' . $this->input->post('order_id'))->log();
                redirect(base_url() . 'backend/shop/order/detail/'.$order_id.'/'.$order_number);
            } else {
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . 'backend/shop/order');
            }
        } else {
            $this->load->view('backend/admin/view_header', $data);
            $this->load->view('backend/shop/view_order_update', $data);
            $this->load->view('backend/admin/view_footer');
        }
    }

    public function delete($order_id, $order_number, $params='')
    {
        if (in_array($this->session->userdata('role'), ['Superadmin'])) {

            // If there is no Order in this id, then redirect
            $tot = $this->Model_order->order_check($order_id, $order_number);
            if (!$tot) {
                redirect(base_url() . 'backend/shop/order');
                exit;
            }

            if($params === 'items_excluded'){
                $this->Model_order->delete_order_items_excluded($order_id, $order_number);
                return redirect(base_url() . 'backend/shop/order');
            }

            //dosya silme islemlerini repactor et

            $order_folder = "";
            $upload = $this->Model_order->get_before_delete_upload($order_number);

            if (!empty($upload)) {
                foreach ($upload as $upload_row) {
                    $order_folder = $upload_row['path'];
                    if (file_exists($upload_row['path'] . $upload_row['image']))
                        unlink(FCPATH . $upload_row['path'] . $upload_row['image']);
                }
            }

            $upload_done = $this->Model_order->get_before_delete_upload_done($order_number);
            if (!empty($upload_done)) {
                foreach ($upload_done as $upload_done_row) {
                    if (file_exists($upload_done_row['path'] . $upload_done_row['image']))
                        unlink(FCPATH . $upload_done_row['path'] . $upload_done_row['image']);
                }
            }

            $this->Model_order->delete($order_id, $order_number);

            if (file_exists($order_folder))
                rmdir($order_folder);

            $message = 'Order is deleted successfully';
            $this->session->set_flashdata('success', $message);

            $this->logger->user($this->session->userdata('username'))->type('Order Delete')->id(1)->token(sha1(mt_rand()))->comment($message . ' -> ' . $order_number)->log();
        } else {
            $message = 'You are not authorized to access!';
            $this->session->set_flashdata('error', $message);
        }


        redirect(base_url() . 'backend/shop/order');
    }
    
    public function delete_order_item($item_id, $order_number)
    {
        if (in_array($this->session->userdata('role'), ['Superadmin'])) {
            $this->Model_order->delete_order_item($item_id, $order_number);
            $this->session->set_flashdata('success', 'Order item is deleted successfully');
        }

        redirect($this->agent->referrer());
    }

    public function list($status_process_par = 1)
    {

        $response = array();

        $postData = $this->input->post();

        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value

        $status_process = array('status_process' => $status_process_par);

        ## Search 
        $searchQuery = "";
        if ($searchValue != '') {
            $searchQuery = " (order_id like '%" . $searchValue . "%'  or order_number like '%" . $searchValue . "%'  or billing_firstname like '%" . $searchValue . "%' or billing_lastname like '%" . $searchValue . "%' or billing_email like '%" . $searchValue . "%' or paid like '%" . $searchValue . "%' or total like '%" . $searchValue . "%') ";
        }

        $totalRecords = $this->Model_order->ajax_order_totalRecords();
        $totalRecordwithFilter = $this->Model_order->ajax_order_totalRecordwithFilter($searchQuery);
        $records = $this->Model_order->ajax_order_records($status_process, $searchQuery, $columnName, $columnSortOrder, $rowperpage, $start);


        $data = array();

        foreach ($records as $record) {
            $action = '<td>
                <a href="' . base_url("backend/shop/order/detail/" . $record->order_id.'/'.$record->order_number) . '" class="btn btn-primary btn-xs">Detail</a>
                <a href="' . base_url("backend/shop/order/delete/" . $record->order_id.'/'.$record->order_number) . '" class="btn btn-danger btn-xs" onClick="return confirm("Are you sure?");">Delete</a>
            </td>';
            $data[] = array(
                "order_id" => $record->order_id,
                "order_type" => $record->order_type,
                "order_number" => $record->order_number,
                "billing_firstname" => $record->billing_firstname.' '.$record->billing_lastname,
                "billing_email" => $record->billing_email,
                "total" => $record->total,
                "paid" => $record->paid,
                "action" => $action
            );
        }

        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );

        exit(json_encode($response));
    }

    public function check_unuploaded_order_item()
    {
        if (in_array($this->session->userdata('role'), ['Superadmin'])) {

            $get_orders = $this->Model_order->check_unuploaded_order();

            foreach($get_orders as $row_order)
            {
                $get_order_items = $this->Model_order->order_item($row_order['order_number']);
                foreach($get_order_items as $row_order_item)
                {
                    $get_order_item_upload = $this->Model_order->order_item_upload_with_uniqid($row_order['order_number'], $row_order_item['item_uniqid']);
                    if($get_order_item_upload)
                    {
                        $check_unuploaded_order_req = $this->Model_order->check_unuploaded_order_req($row_order['order_number'], $row_order['store_id']);
                        if($check_unuploaded_order_req < 0)
                        {
                            print_r($this->Model_order->add_unuploaded_order_req(array('order_number' => $row_order['order_number'], 'store_id' => $row_order['store_id'])));
                        }
                    }
                    break;
                }
            }
        }
    }

    public function create_new_order_folder($order_id)
    {
        if (!in_array($this->session->userdata('id'), [1,20]))
            redirect(base_url('backend/info'));
        
        $data['order_detail'] = $this->Model_order->detail($order_id);
        if (empty($data['order_detail']))
            redirect(base_url('backend/shop/order'));

        $folder_date = date("d-m-Y", strtotime($data['order_detail']['date_purchased'])); 
        $current_folder = "public/uploads/shop/order_kiosk_upload/" . str_replace(' ', '', trim(strtolower($data['order_detail']['land_name']))) . "/" . str_replace(' ', '', trim(strtolower($data['order_detail']['store_name']))) . "/" . $folder_date . "/" . intval($data['order_detail']['order_number']) . "/";
        if (!file_exists($current_folder)) {
            mkdir($current_folder, 0755, true);
        }
        redirect(base_url('backend/shop/order/detail/'.$order_id.'/'.$data['order_detail']['order_number']));
    }

    //public/backend/js/backend.js de ajax islemleri
    public function export_order_data_detail()
    {
        exit(json_encode($this->Model_order->export_order_data_detail($this->input->post('order_number'))));
    }
    
    public function export_order_data()
    {

        if($this->input->post()){
            $getAllOrders = $this->Model_order->export_get_all_orders($this->input->post('store_id'), $this->input->post('status_id'), $this->input->post('order_start_date'), $this->input->post('order_end_date'));
            if($this->input->post('item_id') == 0) {
                if($getAllOrders) {
                    exit(json_encode(array('status' => true,'getAllOrders' => $getAllOrders)));
                } else {
                    exit(json_encode(array('status' => false, 'message' => 'No result')));
                }
            } else {
                $emails = [];
                $order = [];
                $getAllOrderItems = $this->Model_order->export_get_all_order_items($this->input->post('item_id'), $this->input->post('order_start_date'), $this->input->post('order_end_date'));
                
                foreach($getAllOrderItems as $key => $item) {
                    foreach($getAllOrders as $order) {
                       if($item['order_number'] == $order['order_number']) {
                           if(!in_array($order['billing_email'], $emails)) {
                               $emails[] = $order['billing_email'];
                               $order[] = $order;
                            }
                       }
                   }
                }

                exit(json_encode(array('status' => true, 'getAllOrderItems' => $getAllOrderItems, 'emails' => $emails, 'order' => $order)));
            }
            
                        
            $data['get_store_all'] = $this->Model_store->get_store_all($this->session->userdata('land_id'));
            $data['setting_shop_order_status'] = $this->Model_common->get_setting_shop_order_status();

                
        } else {
            $data['get_store_all'] = $this->Model_store->get_store_all($this->session->userdata('land_id'));
            $data['setting_shop_order_status'] = $this->Model_common->get_setting_shop_order_status();
            $data['product_type'] = $this->Model_product->getAllProductType();
            $data['products'] = $this->Model_product->show($this->session->userdata('lang_code'));
            $this->load->view('backend/admin/view_header');
            $this->load->view('backend/shop/view_export_order_data', $data);
            $this->load->view('backend/admin/view_footer');
        }

        

        // exit(json_encode($getAll));


        // $fp = fopen('file.csv', 'w');

        // foreach ($getAll as $fields) {
        //     fputcsv($fp, $fields);
        // }

        // fclose($fp);

        // $this->load->helper('download');

        // $pth    =   file_get_contents(base_url($fp));
        // $name   = "amk.csv";
        // force_download($name, $pth);


        // if (count($getAll) == 0) {
        //     return null;
        //   }


        //   ob_start();
        //   $df = fopen("php://output", 'w');
        //   fputcsv($df, array_keys(reset($getAll)));
        //   foreach ($getAll as $row) {
        //      fputcsv($df, $row);
        //   }
        //   fclose($df);
        //   return ob_get_clean();
    }
}
