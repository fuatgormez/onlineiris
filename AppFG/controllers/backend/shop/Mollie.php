<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mollie extends CI_Controller
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

		if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) {
			if ($data['setting']['website_status_backend'] === "Passive") {
				$data['message'] = $data['setting']['website_status_backend_message'];
				redirect(base_url('backend/info'));
			}
		}

        $this->mollie = new \Mollie\Api\MollieApiClient();
        $select_mollie_key =  $this->Model_common->get_setting_shop_data();

        if ($select_mollie_key["mollie_current_key"] === "test") {
            $this->mollie->setApiKey($select_mollie_key["mollie_test_key"]);
        } else {
            $this->mollie->setApiKey($select_mollie_key["mollie_live_key"]);
        }

        // $this->mollie->setAccessToken("access_47RSjzkkTRHt9gKNkM79RD5TFVDBCFMsKFWz3DWv");
        
    }

    public function index()
    {
        $data['setting'] = $this->Model_common->get_setting_data();

        $data['payments'] = $this->mollie->payments->page();
        $data['next_payments'] = $data['payments']->next();

        $this->load->view('backend/admin/view_header', $data);
        $this->load->view('backend/shop/view_mollie', $data);
        $this->load->view('backend/admin/view_footer');
    }

    public function detail($id)
    {
        $data['payment'] = $this->mollie->payments->get($id);
        // $amk = $this->mollie->payments->get($id);
        // $data['metadata'] = $amk->metadata;
        // $data['metadata'] = (array) $data['payment']->metadata;

        // print_r($data['payment']);exit;

        $this->load->view('backend/admin/view_header', $data);
        $this->load->view('backend/shop/view_mollie_detail', $data);
        $this->load->view('backend/admin/view_footer');
    }

    public function action($params)
    {
        $data['setting'] = $this->Model_common->get_setting_data();

        if($params === 're_create'){
            $action_view = 'view_mollie_action_re_create';
        } elseif($params === 'all_order_check'){
            $action_view = 'view_mollie_action_all_order_check';
        } else {
            redirect(base_url('backend/admin'));
        }

        $this->load->view('backend/admin/view_header', $data);
        $this->load->view('backend/shop/'.$action_view, $data);
        $this->load->view('backend/admin/view_footer');
    }

    public function re_create()
    {
        redirect(base_url('shop/checkout/mollie_create_re_order/'.$this->input->post('tr_id')));
    }
    
    public function all_order_check()
    {
    //initialize session
    $ch = curl_init();

    //set the URL
    $url = base_url('api/mollie/mollie_check');

    //set options
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    //execution
    $json=curl_exec($ch);

    //close
    curl_close($ch);
        redirect(base_url('backend/shop/mollie'));
    }

}