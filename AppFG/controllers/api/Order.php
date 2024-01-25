<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('api/Model_order');
		//$this->output->cache(60);
		// $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url()) : $this->session->userdata('store_language') ;
	}

	public function index()
	{
		exit('access denied');
	}



	public function get_order_status1($land_id, $store_id)
	{
		exit(json_encode($this->Model_order->get_order_status($land_id, $store_id)));
	}

	public function get_order_status($land_id, $store_id)
	{
		$get_order = $this->Model_order->get_order($land_id, $store_id);

		foreach ($get_order as $key => $row_order) {
			
			$get_order_item = $this->Model_order->get_order_item($row_order['order_number']);

			$items = [];
			foreach ($get_order_item as $row_item) {
				$items[] = $row_item;
			}

			$data[$key] = array(
				'order_info' =>$row_order,
				'items' => $items
			);
		}

		exit(json_encode(array('status' => true, 'message' => 'success', 'data' => $data)));
	}
}
