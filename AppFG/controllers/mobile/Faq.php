<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Faq extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Model_common');
		$this->load->model('Model_faq');
	}

	public function index()
	{
		$data['setting'] = $this->Model_common->all_setting();
		$data['faq'] = $this->Model_faq->all_faq();

		$this->load->view('layout/mobile/view_header', $data);
		if($data['setting']['website_status_mobile'] === 'Active' || in_array($this->session->userdata('role'), ['Superadmin','Admin']))
        {
            $this->load->view('layout/mobile/view_faq',$data);
        } else {
            $this->load->view('layout/mobile/view_maintenance', $data);
        }
		$this->load->view('layout/mobile/view_footer', $data);
	}
}
