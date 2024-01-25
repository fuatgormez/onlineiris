<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Photo_gallery extends CI_Controller {

	function __construct() 
	{
        parent::__construct();
        $this->load->model('Model_common');
        $this->load->model('Model_photo_gallery');
        //$this->load->model('Model_portfolio');
        $this->load->model('Model_service');

        $this->load->library('cart');
        $this->lang->load('file', $this->session->userdata('site_language') ?? $this->session->userdata('store_language'));
        // $this->output->cache(60);
        // $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url()) : $this->session->userdata('store_language') ;
    }

	public function index()
	{
		$data['setting'] = $this->Model_common->all_setting();
        $data['page_home'] = $this->Model_common->all_page_home();
		$data['page_photo_gallery'] = $this->Model_common->all_page_photo_gallery();
		//$data['comment'] = $this->Model_common->all_comment();
		$data['social'] = $this->Model_common->all_social();
		//$data['all_news'] = $this->Model_common->all_news();
        $data['services'] = $this->Model_service->all_service();
        $data['page_contact'] = $this->Model_common->all_page_contact();
		$data['photo_gallery'] = $this->Model_photo_gallery->all_photo();
		//$data['portfolio_footer'] = $this->Model_portfolio->get_portfolio_data();

        $data['stores'] = $this->Model_common->get_all_store();
        $data['store_langs'] = $this->Model_common->get_all_store_value();

        $data['theme'] = $data['setting']['layout'];

        $this->load->view('layout/'.$data['setting']['layout'].'/view_header',$data);
		if($data['setting']['website_status_frontend'] === 'Active' || in_array($this->session->userdata('role'), ['Superadmin','Admin']))
        {
			$this->load->view('layout/'.$data['setting']['layout'].'/view_photo_gallery',$data);
        } else {
            $this->load->view('view_maintenance', $data);
        }
		$this->load->view('layout/'.$data['setting']['layout'].'/view_footer',$data);
	}
}
