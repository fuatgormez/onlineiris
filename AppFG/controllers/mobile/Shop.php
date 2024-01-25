<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shop extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Model_common');
		$this->load->model('shop/Model_shopping_cart');

		$this->load->library('cart');

		if(!$this->session->userdata('order_number_token'))
        	redirect(base_url('mobile'));

	}

	public function index()
	{
		$data['setting'] = $this->Model_common->all_setting();
		$data['page_home'] = $this->Model_common->all_page_home();
		$data['products'] = $this->Model_shopping_cart->all_product();
		$data['product_category'] = $this->Model_shopping_cart->all_product_category();

		$this->load->view('layout/mobile/view_header', $data);
		if($data['setting']['website_status_mobile'] === 'Active' || in_array($this->session->userdata('role'), ['Superadmin','Admin']))
        {
            $this->load->view('layout/mobile/view_shop',$data);
        } else {
            $this->load->view('layout/mobile/view_maintenance', $data);
        }
		$this->load->view('layout/mobile/view_footer', $data);
	}

	public function product_category($category_id)
	{
		$data['setting'] = $this->Model_common->all_setting();
		$data['all_category'] = $this->Model_shopping_cart->all_product_category();
		$data['product_category'] = $this->Model_shopping_cart->get_product_with_category_id($category_id);
		$data['category'] = $this->Model_shopping_cart->get_single_category($category_id);
		$data['products'] = $this->Model_shopping_cart->all_product();

		$this->load->view('layout/mobile/view_header', $data);
		if($data['setting']['website_status_mobile'] === 'Active' || in_array($this->session->userdata('role'), ['Superadmin','Admin']))
        {
            $this->load->view('layout/mobile/view_shop_product_category',$data);
        } else {
            $this->load->view('view_maintenance', $data);
        }
		$this->load->view('layout/mobile/view_footer', $data);
	}

	public function product_detail($product_id)
	{
		$data['setting'] = $this->Model_common->all_setting();
		$data['product'] = $this->Model_shopping_cart->get_single_product($product_id);
		$data['product_photo'] = $this->Model_shopping_cart->get_single_product_photo($product_id);

		// echo "<pre>";
		// print_r($this->cart->contents());

		// $this->cart->destroy();

		$this->load->view('layout/mobile/view_header', $data);
		if($data['setting']['website_status_mobile'] === 'Active' || in_array($this->session->userdata('role'), ['Superadmin','Admin']))
        {
            $this->load->view('layout/mobile/view_shop_product_detail',$data);
        } else {
            $this->load->view('view_maintenance', $data);
        }
		$this->load->view('layout/mobile/view_footer', $data);
	}
}
