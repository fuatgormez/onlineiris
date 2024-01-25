<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {
	function __construct()
	{
        parent::__construct();
        $this->load->model('Model_common');
        $this->load->model('Model_category');
        $this->load->model('Model_portfolio');
        $this->load->model('Model_service');

		$this->load->library('cart');
		$this->lang->load('file', $this->session->userdata('site_language') ?? $this->session->userdata('store_language'));
//        $this->output->cache(60);
        $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url()) : $this->session->userdata('store_language') ;
    }

	public function index($id=0)
	{
		if( !isset($id) || !is_numeric($id) ) {
			redirect(base_url());
		}

		$tot = $this->Model_category->category_check($id);
		if(!$tot) {
			redirect(base_url());
		}


		$data['setting'] = $this->Model_common->all_setting();
		$data['page_home'] = $this->Model_common->all_page_home();
		$data['comment'] = $this->Model_common->all_comment();
		$data['social'] = $this->Model_common->all_social();
		$data['all_news'] = $this->Model_common->all_news();
		$data['all_categories'] = $this->Model_common->all_categories();
        $data['services'] = $this->Model_service->all_service();
        $data['page_contact'] = $this->Model_common->all_page_contact();
		$data['category'] = $this->Model_category->category_by_id($id);
		$data['news_by_category'] = $this->Model_category->all_news_by_category_id($id);
		$data['portfolio_footer'] = $this->Model_portfolio->get_portfolio_data();

		$this->load->view('layout/'.$data['setting']['layout'].'/view_header',$data);
		$this->load->view('layout/'.$data['setting']['layout'].'/view_category',$data);
		$this->load->view('layout/'.$data['setting']['layout'].'/view_footer',$data);
	}
}