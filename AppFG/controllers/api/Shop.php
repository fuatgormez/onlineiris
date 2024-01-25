<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shop extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('api/Model_shop');
		//$this->output->cache(60);
		// $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url()) : $this->session->userdata('store_language') ;
	}

	public function index()
	{
		exit('access denied');
	}

	public function all_data($store_id, $lang)
	{
		$data[] = $this->Model_shop->all_data($store_id, $lang);
		exit(json_encode($this->Model_shop->all_data($store_id, $lang)));
	}

	public function order($security_number)
	{
		exit(json_encode($this->Model_shop->order($security_number)));
	}

	public function update_order($order_number, $status, $token)
	{
		if ($token === "e58753aaf7a14d7c22017e6e198beb1034759bea") {
			try {
				$data = array(
					'status' => $status
				);

				$this->Model_shop->update_order($order_number, $data);
				exit(json_encode(array('status' => true)));
			} catch (Exception $e) {
				exit(json_encode(array('status' => false)));
			}
		} else {
			exit(json_encode(array('status' => false, 'message' => 'access denied')));
		}
	}

	public function single_product($id, $land_id, $lang)
	{
		$result = $this->Model_shop->single_product($id, $land_id, $lang);
		if ($result != null) {
			exit(json_encode(array('status' => true, 'message' => 'success', 'data' => $result)));
		} else {
			exit(json_encode(array('status' => false, 'message' => 'error', 'data' => 'null')));
		}
	}

	public function all_product($land_id, $lang)
	{
		exit(json_encode($this->Model_shop->all_product($land_id, $lang)));
	}

	public function updatable_product($product_id, $land_id)
	{
		exit(json_encode($this->Model_shop->updatable_product($product_id, $land_id)));
	}

	public function is_completed_item($order_number, $item_id, $item_uniqid, $is_completed_uniqid, $process="" )
	{
		try {

			$data = array(
				'is_completed' => 1,
				'is_completed_uniqid' => $is_completed_uniqid
			);
			$this->Model_shop->is_completed_item($order_number, $item_id, $item_uniqid, $data);

			if(!empty($process)){
				//mail gidecek
				$get_order = $this->Model_shop->get_order($order_number);

				$check_item_data =  $this->Model_shop->is_completed_uniqid_item($order_number, $item_uniqid);
				$this->load->library('shop_email');

				if($process === "normal"){
					// $this->shop_email->send_email_is_completed($check_item_data[0]['item_lang_code'], "AfterShootingMollie" ,$get_order['billing_email']);
					$this->shop_email->send_email($check_item_data[0]['item_lang_code'], "AfterShootingMollie" ,$get_order['billing_email'], $order_number);
				}
				
				if($process === "uniq"){
					// $this->shop_email->send_email_is_completed($check_item_data['item_lang_code'], "AfterShootingBilling", $get_order['billing_email']);
					$this->shop_email->send_email_is_completed($check_item_data[0]['item_lang_code'], "AfterShootingMollie", $check_item_data[0]['email']);
				}
			}

			// if($payment_method === "bankTransfer"){
			// 	$this->shop_email->send_email_single_banktransfer_kiosk();
			// 	$this->shop_email->send_email_is_completed("AfterShootingBilling");
			// } 
			// else {
			// 	$this->shop_email->send_email_is_completed("AfterShootingMollie");
			// }

			exit(json_encode(array('status' => true)));
		} catch (Exception $e) {
			exit(json_encode(array('status' => false)));
		}
	}

	public function all_category($store_id, $lang)
	{
		exit(json_encode($this->Model_shop->all_category($store_id, $lang)));
	}

	public function check_payment_order_status($order_number, $upgrade = "")
	{
		if ($upgrade === "upgrade") {
			$paid_field = "paid_update";
			$payment_method_field = "payment_method_update";
		} else {
			$paid_field = "paid";
			$payment_method_field = "payment_method";
		}

		$response = $this->Model_shop->check_payment_order_status($order_number, $paid_field);

		if (empty($response) || $response === "null") {
			$paid = false;
			$message = "error";
			$data = "isPending";
		} else {
			if ($response[$payment_method_field] === 'bankTransfer') {
				$paid = true;
				$message = "success";
				$data = $response['security_number'];
			} elseif ($response[$paid_field] === 'isPaid') {
				$paid = true;
				$message = "success";
				$data = $response['security_number'];
			} else {
				$paid = false;
				$message = "error";
				$data = $paid_field;
			}
		}
		exit(json_encode(array('status' => $paid, 'message' => $message, 'data' => $data)));
	}

	public function check_payment_order_status_single($order_number)
	{
		try {
			$response = $this->Model_shop->check_payment_order_status_single($order_number);
			if (isset($response)) {
				exit(json_encode(array('status' => true, 'data' => $response['security_number'], 'message' => 'isPaid')));
			} else {
				exit(json_encode(array('status' => false, 'data' => '', 'message' => 'isPending')));
			}
		} catch (Exception $e) {
			exit(json_encode(array('status' => false, 'data' => '', 'message' => 'isPending')));
		}
	}

	public function get_order_item_upload($order_number)
	{
		$get_images = $this->Model_shop->get_order_item_upload($order_number);

		if ($get_images !== "null") {

			$images = array();

			foreach ($get_images as $image) {
				$ext = pathinfo($image['image'], PATHINFO_EXTENSION);
				if ($ext === "jpg" || $ext === "jpeg") {
					$images[] = $image;
				}
			}

			exit(json_encode(array('status' => true, 'data' => $images, 'mesaj' => 'yes')));
		} else {
			exit(json_encode(array('status' => false, 'data' => '', 'meesaj' => 'no')));
		}
	}

	/**
	 * security number uniqid de olabilir ilk önce uniqid sorgulaniyor yoksa security de sorgulaniyor
	 * $is_uniq 1 ise buldu 0 ise bulamadi 
	 * @param String $security_number
	 * @return json
	 */
	public function get_ordered_products_by_security_number($security_number)
	{

		$response_items = $this->Model_shop->get_ordered_products_by_uniqid_item($security_number);

		if ($response_items) {
			$response_order = $this->Model_shop->get_ordered_products_by_security_number_order($response_items[0]['security_number']);
			$is_uniq = "1";
		} else {
			$response_items = $this->Model_shop->get_ordered_products_by_security_number_item($security_number);
			$response_order = $this->Model_shop->get_ordered_products_by_security_number_order($security_number);
			$is_uniq = "0";
		}

		if (count($response_items) > 0 && ($response_order['paid'] === "isPaid" || $response_order['paid'] === "isPending")) {

			$data['order_items'] = $response_items;
			$data['order_info'] = $response_order;

			$paid = true;
			$message = $is_uniq;
		} else {
			$paid = false;
			$message = $is_uniq;
			$data = "null";
		}
		exit(json_encode(array('status' => $paid, 'message' => $message, 'data' => $data)));
	}

	public function check_single_payment_order_status($order_number, $item_uniqid, $is_upgrade = 0)
	{
		//$is_upgrade with name price varsa sadece tbl_shop_order_item tablsounu cek 
		if($is_upgrade == 1){
			$check_status = $this->Model_shop->check_single_payment_order_status($order_number, $item_uniqid);
		} else {
			$check_status = $this->Model_shop->check_single_payment_order_updated_status($order_number, $item_uniqid);
		}

		try{
			if (empty($check_status)) {
				exit(json_encode(array('status' => false, 'message' => 'item not found', 'data' => 0)));
			} else if ($check_status['is_paid'] == 1) {
				exit(json_encode(array('status' => true, 'message' => 'paid', 'data' => 1)));
			} else {
				exit(json_encode(array('status' => false, 'message' => 'unpaid', 'data' => 0)));
			}
		} catch (Exception $e) {
			exit(json_encode(array('status' => false, 'message' => 'error', 'data' => '')));
		}
	}
	
	public function check_single_payment_order_updated_status($order_number, $item_uniqid)
	{
		$check_status = $this->Model_shop->check_single_payment_order_updated_status($order_number, $item_uniqid);

		try{
			if (empty($check_status)) {
				exit(json_encode(array('status' => false, 'message' => 'item not found', 'data' => 0)));
			} else if ($check_status['is_paid'] == 1) {
				exit(json_encode(array('status' => true, 'message' => 'paid', 'data' => 1)));
			} else {
				exit(json_encode(array('status' => false, 'message' => 'unpaid', 'data' => 0)));
			}
		} catch (Exception $e) {
			exit(json_encode(array('status' => false, 'message' => 'error', 'data' => '')));
		}
	}

	public function update_item_comment()
	{
		$get_kiosk_data = json_decode(file_get_contents('php://input'), true);

		try {
			if ($get_kiosk_data) {
				if ($get_kiosk_data['token'] !== "e58753aaf7a14d7c22017e6e198beb1034759bea") {
					exit(json_encode(array('status' => false, 'message' => 'access denied', 'data' => "no")));
				}

				$data = array(
					"comment" => $get_kiosk_data['comment'],
					"email" => $get_kiosk_data['email']
				);
				$update_comment = $this->Model_shop->update_item_comment($get_kiosk_data['order_number'], $get_kiosk_data['item_id'], $get_kiosk_data['item_uniqid'], $data);

				if ($update_comment > 0) {
					exit(json_encode(array('status' => true, 'message' => 'added', 'data' => '')));
				} else {
					exit(json_encode(array('status' => false, 'message' => 'could not be added', 'data' => '')));
				}
			} else {
				exit(json_encode(array('status' => false, 'message' => 'access denied', 'data' => '')));
			}			
		} catch (Exception $e) {
            exit(json_encode(array('status' => false, 'message' => 'error', 'data' => '')));
        }
	}
}
