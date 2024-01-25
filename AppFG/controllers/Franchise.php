<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Franchise extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Model_common');
		$this->load->model('Model_home');
		$this->load->model('Model_portfolio');

		$this->load->library('cart');
		$this->lang->load('file', $this->session->userdata('site_language') ?? $this->session->userdata('store_language'));
		// $this->output->cache(60);

		// $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url()) : $this->session->userdata('store_language') ;
	}

	public function index()
	{

		$data['setting'] = $this->Model_common->all_setting();
		$data['page_home'] = $this->Model_common->all_page_home();
		//		$data['comment'] = $this->Model_common->all_comment();
		$data['social'] = $this->Model_common->all_social();
		$data['all_news'] = $this->Model_common->all_news();
		$data['all_news_category'] = $this->Model_common->all_news_category();

		$data['page_contact'] = $this->Model_common->all_page_contact();

		$data['sliders'] = $this->Model_home->all_slider();
		$data['services'] = $this->Model_home->all_service();
		$data['features'] = $this->Model_home->all_feature();
		$data['why_choose'] = $this->Model_home->all_why_choose();
		$data['how_we_works'] = $this->Model_home->all_how_we_works();
		$data['team_members'] = $this->Model_home->all_team_member();
		$data['testimonials'] = $this->Model_home->all_testimonial();
		$data['clients'] = $this->Model_home->all_client();
		$data['pricing_table'] = $this->Model_home->all_pricing_table();
		$data['home_faq'] = $this->Model_home->all_faq_home();

		$data['portfolio_category'] = $this->Model_portfolio->get_portfolio_category();
		$data['portfolio'] = $this->Model_portfolio->get_portfolio_data();

		$data['portfolio_footer'] = $this->Model_portfolio->get_portfolio_data();

		$data['stores'] = $this->Model_common->get_all_store();
		//        $data['store_langs'] = $this->Model_common->get_all_store_lang();

		$data['theme'] = $data['setting']['layout'];

		$this->load->view('layout/' . $data['setting']['layout'] . '/view_header', $data);
		$this->load->view('layout/' . $data['setting']['layout'] . '/view_franchise_werden', $data);
		$this->load->view('layout/' . $data['setting']['layout'] . '/view_footer', $data);
	}

	public function send()
	{
		$data['setting'] = $this->Model_common->all_setting();
		$data['page_home'] = $this->Model_common->all_page_home();
		$data['page_contact'] = $this->Model_common->all_page_contact();
		$data['social'] = $this->Model_common->all_social();


		$data['stores'] = $this->Model_common->get_all_store();
		$data['store_langs'] = $this->Model_common->get_all_store_value();

		$data['theme'] = $data['setting']['layout'];

		$message = '';
		$message .= '<p>Voname: '.$this->input->post('firstname').'</p>';
		$message .= '<p>Name: '.$this->input->post('lastname').'</p>';
		$message .= '<p>Tel: '.$this->input->post('phone').'</p>';
		$message .= '<p>Email: '.$this->input->post('email').'</p>';
		$message .= '<p>Stückzahl: '.$this->input->post('qty').'</p>';
		$message .= '<p>Anmerkung: '.$this->input->post('message').'</p>';
		$this->load->library('shop_email');
		$this->shop_email->send_email_franchise($message);

		$success = "Vielen Dank für Ihre Anfrage. Wir werden uns in kürze mit Ihnen in Kontakt setzen.";
		$error = "Fehlermeldung! Bitte erneut versuchen.";

		$this->session->set_flashdata('success', $success);
		redirect(base_url('franchise#franchiseform'));
	}
}
