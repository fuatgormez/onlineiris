<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Upload extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Model_common');
		$this->load->model('shop/Model_order');
	}

	public function index()
	{
		$data['setting'] = $this->Model_common->all_setting();
		$data['page_home'] = $this->Model_common->all_page_home();

		$this->load->view('layout/mobile/view_header', $data);
		if($data['setting']['website_status_mobile'] === 'Active' || in_array($this->session->userdata('role'), ['Superadmin','Admin']))
        {
            $this->load->view('layout/mobile/view_upload',$data);
        } else {
            $this->load->view('layout/mobile/view_maintenance', $data);
        }
		$this->load->view('layout/mobile/view_footer', $data);
	}

	public function image()
	{
		$result = $this->Model_order->get_order( $this->input->post('order_number') );

		exit(
			json_encode(
				array(
					'status' => $result ? 200 : 404,
					'order' => $result
				)
			)
		);
	}
}
