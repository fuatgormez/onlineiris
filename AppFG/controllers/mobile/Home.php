<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Model_common');

		if(!$this->session->userdata('order_number_token'))
        	$this->session->set_userdata('order_number_token', rand(100, 1000) . time());
        	$this->session->set_userdata('security_number_token', rand(100, 1000) . time());

		// exit($this->session->userdata('version'));
		// if($this->session->userdata('version') > 2)
		// 	exit('“A new version is available. Please update and restart”');

	}

	public function index($store_id=1, $version=2)
	{
		try {
			$data['setting'] = $this->Model_common->all_setting();
			$data['page_home'] = $this->Model_common->all_page_home();
			$store = $this->Model_common->store_check($store_id);

			$this->session->set_userdata('store', $store);
			$this->session->set_userdata('version', $version);

			if($this->session->userdata('version') < 2)
				exit('“A new version is available. Please update and restart”');

			$this->load->view('layout/mobile/view_header', $data);
			if($data['setting']['website_status_mobile'] === 'Active' || in_array($this->session->userdata('role'), ['Superadmin','Admin']))
			{
				redirect(base_url('mobile/shop'));
				// $this->load->view('layout/mobile/view_home',$data);
			} else {
				$this->load->view('layout/mobile/view_maintenance', $data);
			}
			$this->load->view('layout/mobile/view_footer', $data);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}
