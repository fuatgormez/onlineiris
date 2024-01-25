<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Coupon extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Model_common');
		$this->load->model('shop/Model_coupon');

		$this->lang->load('file', $this->session->userdata('site_language') ?? $this->session->userdata('store_language'));
		//$this->output->cache(60);
		$store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url('select_land/activation')) : $this->session->userdata('store_language') ;

		$this->load->library('cart');
	}

	public function index()
	{
		exit('access denied');
	}

	public function activation()
	{
		// $this->session->set_userdata('coupon_for_upgrade', 20.99);
		// echo $this->session->userdata('coupon_for_upgrade');

		$data['setting'] = $this->Model_common->all_setting();
		$data['page_home'] = $this->Model_common->all_page_home();
		$data['page_about'] = $this->Model_common->all_page_about();
		$data['comment'] = $this->Model_common->all_comment();
		$data['social'] = $this->Model_common->all_social();

		$data['all_land'] = $this->Model_common->get_all_land();
        $data['stores'] = $this->Model_common->get_all_store();

		$data['theme'] = $data['setting']['layout'];

		$this->load->view('layout/' . $data['setting']['layout'] . '/view_header', $data);
		$this->load->view('layout/' . $data['setting']['layout'] . '/shop/view_coupon_activation', $data);
		$this->load->view('layout/' . $data['setting']['layout'] . '/view_footer', $data);

	}

	public function cart($id = 1)
	{
		echo $this->input->get('id');

		exit;
		if (!ctype_digit($id))
			redirect(base_url('shop/coupon/product'));

	}

	public function send_email($email, $coupon_code = 0)
	{

		$data['setting'] = $this->Model_common->all_setting();


		$this->load->library('email');

		$this->email->from($data['setting']['send_email_from']);
		$this->email->to($email);

		$this->email->subject("New Coupon code");
		$this->email->message("Your new coupon is : " . $coupon_code);

		$this->email->set_mailtype("html");

		$this->email->send();
	}
}
