<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Datenschutz extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Model_common');
	}

	public function index()
	{
		$data['setting'] = $this->Model_common->all_setting();
		$data['datenschutz'] = $this->Model_common->all_page_datenschutz();

		$this->load->view('layout/mobile/view_header', $data);
		if($data['setting']['website_status_mobile'] === 'Active' || in_array($this->session->userdata('role'), ['Superadmin','Admin']))
        {
            $this->load->view('layout/mobile/view_datenschutz',$data);
        } else {
            $this->load->view('layout/mobile/view_maintenance', $data);
        }
		$this->load->view('layout/mobile/view_footer', $data);
	}
}
