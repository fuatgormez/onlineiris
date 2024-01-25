<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Device extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('api/Model_device');

		//$this->output->cache(60);
		// $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url()) : $this->session->userdata('store_language') ;

	}

	public function index()
	{
		exit('access denied');
	}


	public function get_device($kiosk_id, $token)
	{

		if ($token === "e58753aaf7a14d7c22017e6e198beb1034759bea") {

			try {
				$get_device = $this->Model_device->get_device($kiosk_id);
				exit(json_encode(array('status' => true, 'device' => $get_device)));
			} catch (Exception $e) {
				exit(json_encode(array('status' => false)));
			}
		} else {
			exit(json_encode(array('status' => false, 'message' => 'access denied')));
		}
	}



	public function update_device()
	{
		$get_kiosk_data = json_decode(file_get_contents('php://input'), true);

		if ($get_kiosk_data['token'] === "e58753aaf7a14d7c22017e6e198beb1034759bea") {

			try {

				$data = array(
					"start_running" => $get_kiosk_data['start_running'],
					"stop_running" => $get_kiosk_data['stop_running'],
					"x_status" => $get_kiosk_data['x_status'],
					"y_status" => $get_kiosk_data['y_status'],
					"z_status" => $get_kiosk_data['z_status'],
					"status" => $get_kiosk_data['status'],
					"status_cover" => $get_kiosk_data['status_cover'],
					"status_led" => $get_kiosk_data['status_led'],
					"status_camera" => $get_kiosk_data['status_camera'],
					"status_flash" => $get_kiosk_data['status_flash'],
					"status_motor" => $get_kiosk_data['status_motor'],
					"software_version" => $get_kiosk_data['software_version'],
					"hardware_version" => $get_kiosk_data['hardware_version'],
					"software_update" => $get_kiosk_data['software_update'],
					"updated_at" => date('Y-m-d H:i:s')
				);

				$this->Model_device->update_device($get_kiosk_data['kiosk_id'], $data);
				exit(json_encode(array('status' => true, 'message' => '', 'data' => '')));
			} catch (Exception $e) {
				exit(json_encode(array('status' => false, 'message' => '', 'data' => '')));
			}
		}
	}
}
