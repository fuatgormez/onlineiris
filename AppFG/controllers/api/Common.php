<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Common extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('api/Model_common');
		//$this->output->cache(60);
		// $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url()) : $this->session->userdata('store_language') ;
	}

	public function index()
	{
		redirect(base_url());
	}

	public function settings()
	{
		exit(json_encode($this->Model_common->settings()));
	}	
}
