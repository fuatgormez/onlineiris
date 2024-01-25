<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('id')) {
			redirect(base_url() . 'backend/admin/login');
			exit;
		}

		$this->load->library('logger/logger');

		$this->load->model('backend/admin/Model_common');
		// $this->load->model('backend/admin/Model_dashboard');

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

		if(in_array($this->session->userdata('role'), ['Production', 'Seller', 'Designer'])){
			redirect(base_url('backend/shop/order'));
		}

		$data['logs'] = json_decode(json_encode($this->logger->get()), true);


		$this->load->view('backend/admin/view_header', $data);
		$this->load->view('backend/admin/view_dashboard', $data);
		$this->load->view('backend/admin/view_footer');
	}
}
