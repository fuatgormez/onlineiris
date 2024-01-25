<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pricing extends CI_Controller {
	function __construct()
	{
        parent::__construct();
        $this->load->model('Model_common');
        $this->load->model('Model_pricing');
        $this->load->model('Model_portfolio');
        $this->load->model('Model_service');

		$this->lang->load('file', $this->session->userdata('site_language') ?? $this->session->userdata('store_language'));
//        $this->output->cache(60);
        // $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url()) : $this->session->userdata('store_language') ;
    }

	public function index()
	{
		$data['setting'] = $this->Model_common->all_setting();
		$data['page_pricing'] = $this->Model_common->all_page_pricing();
		$data['comment'] = $this->Model_common->all_comment();
		$data['social'] = $this->Model_common->all_social();
		$data['all_news'] = $this->Model_common->all_news();
        $data['services'] = $this->Model_service->all_service();
        $data['page_contact'] = $this->Model_common->all_page_contact();
		$data['pricing'] = $this->Model_pricing->all_pricing();
		$data['portfolio_footer'] = $this->Model_portfolio->get_portfolio_data();

        $data['stores'] = $this->Model_common->get_all_store();
        $data['store_langs'] = $this->Model_common->get_all_store_lang();

		$this->load->view('layout/'.$data['setting']['layout'].'/view_header',$data);
		$this->load->view('layout/'.$data['setting']['layout'].'/view_pricing',$data);
		$this->load->view('layout/'.$data['setting']['layout'].'/view_footer',$data);
	}
}