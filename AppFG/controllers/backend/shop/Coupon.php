<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Coupon extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('id')) {
            redirect(base_url() . 'backend/admin/login');
        }

        $this->load->library('logger/logger');

        $this->load->model('backend/admin/Model_common');
        $this->load->model('backend/shop/Model_coupon');

        $data['setting'] = $this->Model_common->get_setting_data();

        if (!in_array($this->session->userdata('role'), ['Superadmin'])) {
            if ($data['setting']['website_status_backend'] === "Passive") {
                $data['message'] = $data['setting']['website_status_backend_message'];
                redirect(base_url('backend/info'));
            }
        }
    }

    public function index()
    {
        $data['setting'] = $this->Model_common->get_setting_data();

        $data['coupon'] = $this->Model_coupon->show();


        $this->load->view('backend/admin/view_header', $data);
        $this->load->view('backend/shop/view_coupon', $data);
        $this->load->view('backend/admin/view_footer');
    }

    public function add()
    {
        $data['setting'] = $this->Model_common->get_setting_data();

        $error = '';
        $success = '';

        if (isset($_POST['form1'])) {

            $valid = 1;

            $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required');
            if ($this->input->post('discount_type') === "fixed_cart") {
                $this->form_validation->set_rules('amount', 'Amount', 'trim|decimal|required');
                $amount = $this->input->post('amount');
                $percent = 0;
            } else {
                $this->form_validation->set_rules('percent', 'Percent', 'trim|numeric|required');
                $amount = 0.00;
                $percent = $this->input->post('percent');
            }
            $this->form_validation->set_rules('discount_type', 'Discount type', 'trim|required');
            $this->form_validation->set_rules('valid_date_from', 'Valid Date from', 'date|required');
            $this->form_validation->set_rules('valid_date_to', 'Valid Date to', 'date|required');
            $this->form_validation->set_rules('min_spend', 'Minimum spend', 'trim|decimal');
            $this->form_validation->set_rules('max_spend', 'Maximum spend', 'trim|decimal');
            $this->form_validation->set_rules('max_limit', 'Max Limit', 'trim|numeric|required');


            if ($this->form_validation->run() == FALSE) {
                $valid = 0;
                $error .= validation_errors();
            }

            if ($valid == 1) {

                $form_data = array(
                    'code' => $this->input->post('coupon_code'),
                    'amount' => $amount,
                    'percent' => $percent,
                    'discount_type' => $this->input->post('discount_type'),
                    'valid_date_from' => $this->input->post('valid_date_from'),
                    'valid_date_to' => $this->input->post('valid_date_to'),
                    'min_spend' => $this->input->post('min_spend'),
                    'max_spend' => $this->input->post('max_spend'),
                    'max_limit' => $this->input->post('max_limit'),
                    'title' => $this->input->post('title'),
                    'description' => $this->input->post('description'),
                    'status' => $this->input->post('status')
                );
                $this->Model_coupon->add($form_data);

                $success = 'Coupon is added successfully!';
                $this->session->set_flashdata('success', $success);
                redirect(base_url() . 'backend/shop/coupon');
            } else {
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . 'backend/shop/coupon/add');
            }
        } else {

            $this->load->view('backend/admin/view_header');
            $this->load->view('backend/shop/view_coupon_add');
            $this->load->view('backend/admin/view_footer');
        }
    }

    public function edit($coupon_id)
    {
        $data['setting'] = $this->Model_common->get_setting_data();

        $error = '';
        $success = '';

        if (isset($_POST['form1'])) {

            $valid = 1;

            $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required');
            if ($this->input->post('discount_type') === "fixed_cart") {
                $this->form_validation->set_rules('amount', 'Amount', 'trim|decimal|required');
                $amount = $this->input->post('amount');
                $percent = 0;
            } else {
                $this->form_validation->set_rules('percent', 'Percent', 'trim|numeric|required');
                $amount = 0.00;
                $percent = $this->input->post('percent');
            }

            $this->form_validation->set_rules('discount_type', 'Discount type', 'trim|required');
            $this->form_validation->set_rules('valid_date_from', 'Valid Date from', 'date|required');
            $this->form_validation->set_rules('valid_date_to', 'Valid Date to', 'date|required');
            $this->form_validation->set_rules('min_spend', 'Minimum spend', 'trim|decimal');
            $this->form_validation->set_rules('max_spend', 'Maximum spend', 'trim|decimal');
            $this->form_validation->set_rules('max_limit', 'Max Limit', 'trim|numeric|required');


            if ($this->form_validation->run() == FALSE) {
                $valid = 0;
                $error .= validation_errors();
            }

            if ($valid == 1) {

                $form_data = array(
                    'code' => $this->input->post('coupon_code'),
                    'amount' => $amount,
                    'percent' => $percent,
                    'discount_type' => $this->input->post('discount_type'),
                    'valid_date_from' => $this->input->post('valid_date_from'),
                    'valid_date_to' => $this->input->post('valid_date_to'),
                    'min_spend' => $this->input->post('min_spend'),
                    'max_spend' => $this->input->post('max_spend'),
                    'max_limit' => $this->input->post('max_limit'),
                    'title' => $this->input->post('title'),
                    'description' => $this->input->post('description'),
                    'status' => $this->input->post('status'),
                );
                $this->Model_coupon->update($coupon_id, $form_data);

                $success = 'Coupon is added successfully!';
                $this->session->set_flashdata('success', $success);
                redirect(base_url() . 'backend/shop/coupon');
            } else {
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . 'backend/shop/coupon/edit/' . $coupon_id);
            }
        } else {

            $data['coupon'] = $this->Model_coupon->getData($coupon_id);

            $this->load->view('backend/admin/view_header');
            $this->load->view('backend/shop/view_coupon_edit', $data);
            $this->load->view('backend/admin/view_footer');
        }
    }

    public function delete($coupon_id)
    {
        if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) {
            $this->session->set_flashdata('warning', 'access denied');
            redirect(base_url() . 'backend/shop/coupon');
        }

        // If there is no Coupon in this id, then redirect
        $tot = $this->Model_coupon->coupon_check($coupon_id);
        if (!$tot) {
            redirect(base_url() . 'backend/shop/coupon');
            exit;
        }

        $this->Model_coupon->delete($coupon_id);
        $success = 'Coupon is deleted successfully';
        $this->session->set_flashdata('success', $success);

        $this->logger->user('')->type('Coupon Delete')->id(1)->token(sha1(mt_rand()))->comment($success . ' -> ' . $coupon_id)->log();

        redirect(base_url() . 'backend/shop/coupon');
    }

    public function generate_code()
    {
        $coupon_code = strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10));
        $return_coupon_code = array(
            'csrf_fg' => $this->security->get_csrf_hash(),
            'coupon_code' => strtoupper($coupon_code)
        );

        exit(json_encode($return_coupon_code));
    }

    public function list()
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

        ## Search 
        $searchQuery = "";
        if ($searchValue != '') {
            $searchQuery = " (id like '%" . $searchValue . "%' or code like '%" . $searchValue . "%' or amount like '%" . $searchValue . "%' or percent like '%" . $searchValue . "%' or discount_type like '%" . $searchValue . "%' or valid_date_to like '%" . $searchValue . "%' or max_limit like '%" . $searchValue . "%' or status like '%" . $searchValue . "%') ";
        }

        $totalRecords = $this->Model_coupon->ajax_coupon_totalRecords();
        $totalRecordwithFilter = $this->Model_coupon->ajax_coupon_totalRecordwithFilter($searchQuery);
        $records = $this->Model_coupon->ajax_coupon_records($searchQuery, $columnName, $columnSortOrder, $rowperpage, $start);


        $data = array();

        foreach ($records as $record) {
            $action = '<td>
                <a href="' . base_url("backend/shop/coupon/edit/" . $record->id) . '" class="btn btn-primary btn-xs">Edit</a>
                <a href="' . base_url("backend/shop/coupon/delete/" . $record->id) . '" class="btn btn-danger btn-xs" onClick="return confirm("Are you sure?");">Delete</a>
            </td>';
            $data[] = array(
                "id" => $record->id,
                "code" => $record->code,
                "amount" => $record->amount,
                "percent" => $record->percent,
                "discount_type" => $record->discount_type,
                "valid_date" => $record->valid_date_from . "­ | " . $record->valid_date_to,
                "limit" => $record->max_limit,
                "status" => $record->status,
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
}
