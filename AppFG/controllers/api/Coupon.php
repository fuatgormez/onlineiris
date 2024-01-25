<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Coupon extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Model_common');
		$this->load->model('api/Model_coupon');
		//$this->output->cache(60);
		// $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url()) : $this->session->userdata('store_language') ;
	}

	public function index()
	{
		exit('access denied');
	}

	public function create($order_number = "")
	{
		// if ($amount == 0) exit(json_encode(array('status' => false, 'message' => 'The amount cannot be null!')));

		$check_order = $this->Model_coupon->check_order($order_number);
		$amount = $check_order['total'];

		if (!isset($check_order)) exit(json_encode(array('status' => false, 'message' => 'Order not found!')));

		$update_order = $this->Model_coupon->update_order($order_number, array("status" => "Passive"));

		if ($update_order == 1) {
			$coupon_code =  substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10);

			$valid_date_from = date('Y-m-d');
			$valid_date_to = date('Y-m-d', strtotime('+1 year'));

			$data = array(
				"code" => $coupon_code,
				"amount" => $amount,
				"discount_type" => "fixed_cart",
				"type" => "gift_card",
				"valid_date_from" => $valid_date_from,
				"valid_date_to" => $valid_date_to
			);
			$create_new_coupon = $this->Model_coupon->create($data);

			if ($create_new_coupon != 1) {
				$message = 'Error';
				$status = false;
			} else {
				$this->send_email($check_order['billing_email'], $coupon_code);
				$message = 'Coupon code has been created successfully!';
				$status = true;
			}
		} else {
			exit(json_encode(array('status' => false, 'message' => 'The order could not be updated!')));
		}

		exit(json_encode(array('status' => $status, 'message' => $message)));
	}

	public function update_current_limit($coupon_code)
	{
		exit(json_encode($this->Model_coupon->update_current_limit($coupon_code)));
	}

	public function get_coupon_code($coupon_code)
	{
		exit(json_encode($this->Model_coupon->get_coupon_code($coupon_code)));
	}

	public function get_coupon_code_spend($coupon_code)
	{
		exit(json_encode($this->Model_coupon->get_coupon_code_spend($coupon_code)));
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

	public function create_for_groupon()
	{
		//otomatik coupon olusturma groupon icin 10000 adet
		// for ($i = 0; $i < 10000; $i++) {
		// 	$coupon = array(
		// 		"code" =>  "GR" . strtolower(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10)),
		// 		"amount" => 39.00,
		// 		"discount_type" => "fixed_cart",
		// 		"valid_date_from" => "2021-08-09",
		// 		"valid_date_to" => "2022-08-09",
		// 		"current_limit" => 1
		// 	);
		// 	$this->Model_coupon->create($coupon);
		// }
	}

	public function groupon()
	{
		//kasiyor 10000 adet cekiyor gropun icin yapildi calisiyor
		// exit(json_encode($this->Model_coupon->get_coupon_groupon()));
		foreach($this->Model_coupon->get_coupon_groupon() as $code)
		{
			echo $code['code']."<br>";
		}
	}
}
