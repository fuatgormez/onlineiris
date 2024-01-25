<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model_common');
        $this->load->model('shop/Model_order');
    }

    public function index()
    {
        redirect(base_url('mobile/shop'));
    }

    public function statistic()
    {
        $data['setting'] = $this->Model_common->all_setting();

        $data['daily_total'] = $this->Model_order->daily_order_sum();

		$this->load->view('layout/mobile/view_header', $data);
		if($data['setting']['website_status_mobile'] === 'Active' || in_array($this->session->userdata('role'), ['Superadmin','Admin']))
        {
            $this->load->view('layout/mobile/view_statistic',$data);
        } else {
            $this->load->view('layout/mobile/view_maintenance', $data);
        }
		$this->load->view('layout/mobile/view_footer', $data);
    }

    public function billing($order_number)
    {
        $data['setting'] = $this->Model_common->all_setting();
        $data['order'] = $this->Model_common->get_order($order_number);
        $data['order_item'] = $this->Model_common->get_order_item($order_number);
        $data['order_number'] = $order_number;

        if($data['order']) {
            $this->load->view('layout/mobile/view_header', $data);
            $this->load->view('layout/mobile/view_billing_order', $data);
            $this->load->view('layout/mobile/view_footer', $data);
        } else {
            redirect(base_url('mobile/home'));
        }
    }

    public function tracking($order_number)
    {
        $data['setting'] = $this->Model_common->all_setting();
        $data['get_order'] = $this->Model_common->get_order($order_number);

        if($data['get_order']) {
            $this->load->view('layout/mobile/view_header', $data);
            $this->load->view('layout/mobile/view_tracking_order', $data);
            $this->load->view('layout/mobile/view_footer', $data);
        } else {
            redirect(base_url('mobile/shop'));
        }
    }

    public function create_new_order_folder($order_number)
    {
        $data['order_detail'] = $this->Model_common->get_order($order_number);
        if (empty($data['order_detail']))
            redirect(base_url('mobile/shop'));

        $folder_date = date("d-m-Y", strtotime($data['order_detail']['date_purchased'])); 
        $current_folder = "public/uploads/shop/order_kiosk_upload/" . str_replace(' ', '', trim(strtolower($data['order_detail']['land_name']))) . "/" . str_replace(' ', '', trim(strtolower($data['order_detail']['store_name']))) . "/" . $folder_date . "/" . $order_number . "/";
        if (!file_exists($current_folder)) {
            mkdir($current_folder, 0755, true);
        }
        return $current_folder;
    }

    public function upload()
    {
        $status = 400;

        if($_FILES['photos']['size'] == 0 || $_FILES['photos']['name'] == '') {
            http_response_code(400);
            exit(json_encode(array('status' => 400, 'msg' => 'You must add a photo!')));
        }

        $order_number = $this->input->post('order_number');

        $get_order = $this->Model_common->get_order($order_number);
        
        // Count total files
        $countfiles = count($_FILES['photos']['name']);

        // Upload directory
        $upload_location = $this->create_new_order_folder($order_number);


        if (!file_exists($upload_location)) {
            // mkdir($upload_location, 0755, true);
            exit(json_encode(array("status" => 200)));
        }

        $form_data = array(
            "order_number" => $order_number,
            "path" => $upload_location,
            // "user" => 'kiosk'//$this->session->userdata('username')
        );

        try {
            // To store uploaded files path
            $files_arr = array();
            // Loop all files
            for ($index = 0; $index < $countfiles; $index++) {

                $uniqid = uniqid();

                if (isset($_FILES['photos']['name'][$index]) && $_FILES['photos']['name'][$index] != '') {
                    // File name
                    $filename = $_FILES['photos']['name'][$index];

                    // Get extension
                    // $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

                    $info = pathinfo($filename);
                    // get the filename without the extension
                    $image_name =  basename($filename, '.' . $info['extension']);
                    // get the extension without the image name
                    $tmp = explode('.', $filename);
                    $ext = end($tmp);
                    // $ext = end(explode('.', $filename));

                    $filename = $image_name . "_" . $uniqid . "." . $ext;

                    // Valid image extension
                    $valid_ext = array("png", "PNG", "jpeg", "JPEG", "jpg", "JPG", "tiff", "TIFF", "tif", "TIF");

                    // Check extension
                    if (in_array($ext, $valid_ext)) {

                        // File path
                        $path = $upload_location . $filename;

                        // Upload file
                        if (move_uploaded_file($_FILES['photos']['tmp_name'][$index], $path)) {
                            $files_arr[] = array(
                                "path" => $path,
                                "image" => $filename,
                                // "user" => 'kiosk',//$this->session->userdata('username'),
                                "created_at" => date("d-m-Y")
                            );

                            $form_data['image'] = $filename;
                            $this->Model_order->photoshop_upload($form_data);
                            exit(json_encode(array('status' => 200, 'msg' => 'Success!')));
                        }
                    }
                } else {
                    http_response_code(400);
                    exit(json_encode(array('status' => 400, 'msg' => 'You have a problem!')));
                }
            }
        } catch (Exception $e) {
            http_response_code(400);
            exit(json_encode(array('status' => 400, 'msg' => 'You have a problem!')));
        }
    }

    public function upload_success(int $order_number)
    {
        $data['setting'] = $this->Model_common->all_setting();
        $data['order'] = $this->Model_common->get_order($order_number);
        $data['order_image'] = $this->Model_order->get_order_image_upload($order_number);

        $this->load->view('layout/mobile/view_header', $data);
        $this->load->view('layout/mobile/view_upload_success', $data);
        $this->load->view('layout/mobile/view_footer', $data);
    }

    public function upload_view($order_number = null)
	{
		$data['setting'] = $this->Model_common->all_setting();
		$data['page_home'] = $this->Model_common->all_page_home();
		// $data['all_get_order'] = $this->Model_order->all_get_order();
		$data['last_get_order'] = $this->Model_order->last_get_order(30);
        $data['order_number'] = $order_number;


		$this->load->view('layout/mobile/view_header', $data);
		if($data['setting']['website_status_mobile'] === 'Active' || in_array($this->session->userdata('role'), ['Superadmin','Admin']))
        {
            $this->load->view('layout/mobile/view_upload',$data);
        } else {
            $this->load->view('layout/mobile/view_maintenance', $data);
        }
		$this->load->view('layout/mobile/view_footer', $data);
	}
}
