<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Device extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('id')) {
            redirect(base_url() . 'backend/admin/login');
        }

        $this->load->model('backend/shop/Model_common');
        $this->load->model('backend/machine_tracking/Model_device');

        $data['setting'] = $this->Model_common->get_setting_data();

        if (!in_array($this->session->userdata('role'), ['Superadmin'])) {
            if ($data['setting']['website_status_backend'] === "Passive") {
                $data['message'] = $data['setting']['website_status_backend_message'];
                redirect(base_url('backend/info'));
            }
        }
    }

    public function index()
    {
        $data['setting'] = $this->Model_common->get_setting_data();
        $data['devices'] = $this->Model_device->show();

        $url1 = $_SERVER['REQUEST_URI'];
        header("Refresh: 30; URL=$url1");

        
        $this->load->view('backend/admin/view_header', $data);
        $this->load->view('backend/machine_tracking/view_device', $data);
        $this->load->view('backend/admin/view_footer');
    }

    public function add()
    {
        $error = '';
        $success = '';

        if (isset($_POST['form1'])) {

            $sku = rand(100, 10000) . time();

            $form_data = array(
                'kiosk_id' => $this->input->post('kiosk_id'),
                'latitude' => $this->input->post('latitude'),
                'longitude' => $this->input->post('longitude'),
                'location_name' => $this->input->post('location_name'),
                'camera_id' => $this->input->post('camera_id'),
                'sim_card_no' => $this->input->post('sim_card_no'),
                'imei_no' => $this->input->post('imei_no'),
                'objective_type' => $this->input->post('objective_type'),
                'contact' => $this->input->post('contact'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'store_id' => $this->input->post('store_id'),
                'start_running' => $this->input->post('start_running'),
                'stop_running' => $this->input->post('stop_running')
            );

            $this->Model_device->add($form_data);

            $success = 'Device is added successfully!';
            $this->session->set_flashdata('success', $success);
            redirect(base_url() . 'backend/machine_tracking/device');
        } else {
            $data['setting'] = $this->Model_common->get_setting_data();
            $data['all_store'] = $this->Model_common->get_all_store();
            $data['all_store_value'] = $this->Model_common->get_all_store_value();

            $this->load->view('backend/admin/view_header', $data);
            $this->load->view('backend/machine_tracking/view_device_add', $data);
            $this->load->view('backend/admin/view_footer');
        }
    }

    public function edit($id)
    {

        // If there is no device in this id, then redirect
        $tot = $this->Model_device->device_check($id);
        if (!$tot) {
            redirect(base_url() . 'backend/machine_tracking/device');
            exit;
        }

        $data['setting'] = $this->Model_common->get_setting_data();
        $error = '';
        $success = '';

        if (isset($_POST['form1'])) {
            $valid = 1;

            if ($valid == 1) {
                $form_data = array(
                    'kiosk_id' => $this->input->post('kiosk_id'),
                    'latitude' => $this->input->post('latitude'),
                    'longitude' => $this->input->post('longitude'),
                    'location_name' => $this->input->post('location_name'),
                    'camera_id' => $this->input->post('camera_id'),
                    'sim_card_no' => $this->input->post('sim_card_no'),
                    'imei_no' => $this->input->post('imei_no'),
                    'objective_type' => $this->input->post('objective_type'),
                    'contact' => $this->input->post('contact'),
                    'email' => $this->input->post('email'),
                    'phone' => $this->input->post('phone'),
                    'store_id' => $this->input->post('store_id'),
                    'start_time' => $this->input->post('start_time'),
                    'finish_time' => $this->input->post('finish_time'),
                    'software_update' => $this->input->post('software_update')
                );

                $this->Model_device->update($id, $form_data);

                $success = 'Device is updated successfully!';
                $this->session->set_flashdata('success', $success);
                redirect(base_url() . 'backend/machine_tracking/device');
            } else {
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . 'backend/machine_tracking/device/edit/' . $id);
            }
        } else {
            $data['device'] = $this->Model_device->get_device($id);
            $data['all_store'] = $this->Model_common->get_all_store();
            $data['all_store_value'] = $this->Model_common->get_all_store_value();

            $this->load->view('backend/admin/view_header', $data);
            $this->load->view('backend/machine_tracking/view_device_edit', $data);
            $this->load->view('backend/admin/view_footer');
        }
    }

    public function action()
    {
        $device_id = $this->input->post('device_id');
        $device_val = $this->input->post('device_val'); //field a denk geliyor
        $device_mode = $this->input->post('device_mode'); //

        $data = array(
            $device_mode => $device_val
        );
        $update = $this->Model_device->action($device_id, $data);

        if ($update) {
            if ($device_mode === "status" && $device_val === "Online") {
                $message = 'is running';
            } else {
                $message = 'is not running';
            }
            exit(json_encode(array('status' => 'success', 'message' => $message)));
        } else {
            exit(json_encode(array('status' => 'error')));
        }
    }

    public function list()
    {

        $timeAgo = new Westsworld\TimeAgo();
        
        $response = array();

        $postData = $this->input->post();

        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value

        ## Search 
        $searchQuery = "";
        if ($searchValue != '') {
            $searchQuery = " (kiosk_id like '%" . $searchValue . "%' or location_name like '%" . $searchValue . "%' ) ";
        }


        $totalRecords = $this->Model_device->ajax_device_totalRecords();
        $totalRecordwithFilter = $this->Model_device->ajax_device_totalRecordwithFilter($searchQuery);
        $records = $this->Model_device->ajax_device_records($searchQuery, $columnName, $columnSortOrder, $rowperpage, $start);

        $data = array();

        foreach ($records as $record) {
            $status_selected_1 = $record->status === "Online" ? 'selected' && $status_bg = 'class="bg-danger"' : '';
            $status_selected_2 = $record->status === "Offline" ? 'selected' : '';
            $status_selected_3 = $record->status === "Maintenance" ? 'selected' : '';
            $status_selected_4 = $record->status === "Restart" ? 'selected' : '';

            $status_cover_selected_1 = $record->status_cover === "Open" ? 'selected' : '';
            $status_cover_selected_2 = $record->status_cover === "Closed" ? 'selected' : '';

            $status_led_selected_1 = $record->status_led === "Open" ? 'selected' : '';
            $status_led_selected_2 = $record->status_led === "Closed" ? 'selected' : '';

            $status_camera_selected_1 = $record->status_camera === "Open" ? 'selected' : '';
            $status_camera_selected_2 = $record->status_camera === "Closed" ? 'selected' : '';

            $status_flash_selected_1 = $record->status_flash === "Open" ? 'selected' : '';
            $status_flash_selected_2 = $record->status_flash === "Closed" ? 'selected' : '';

            $status_motor_selected_1 = $record->status_motor === "Park" ? 'selected' : '';
            $status_motor_selected_2 = $record->status_motor === "Test" ? 'selected' : '';
            $status_motor_selected_3 = $record->status_motor === "Online" ? 'selected' : '';

            $request = '<select class="form-control device_action ' . @$status_bg . '" data-mode="status" data-id="' . $record->id . '"><option value="Online" ' . $status_selected_1 . '>Status Online</option><option value="Offline" ' . $status_selected_2 . '>Status Offline</option><option value="Maintenance" ' . $status_selected_3 . '>Status Maintenance</option><option value="Restart" ' . $status_selected_4 . '>Status Restart</option></select> ';
            $request .= '<select class="hide form-control device_action" data-mode="status_cover" data-id="' . $record->id . '"><option value="Open" ' . $status_cover_selected_1 . '>Cover Open</option><option value="Closed" ' . $status_cover_selected_2 . '>Cover Closed</option></select> ';
            $request .= '<select class="hide form-control device_action" data-mode="status_led" data-id="' . $record->id . '"><option value="Open" ' . $status_led_selected_1 . '>Led Open</option><option value="Closed" ' . $status_led_selected_2 . '>Led Closed</option></select> ';
            $request .= '<select class="hide form-control device_action" data-mode="status_camera" data-id="' . $record->id . '"><option value="Open" ' . $status_camera_selected_1 . '>Camera Open</option><option value="Closed" ' . $status_camera_selected_2 . '>Camera Closed</option></select> ';
            $request .= '<select class="hide form-control device_action" data-mode="status_flash" data-id="' . $record->id . '"><option value="Open" ' . $status_flash_selected_1 . '>Flash Open</option><option value="Closed" ' . $status_flash_selected_2 . '>Flash Closed</option></select> ';
            $request .= '<select class="hide form-control device_action" data-mode="status_motor" data-id="' . $record->id . '"><option value="Park" ' . $status_motor_selected_1 . '>Motor Park</option><option value="Test" ' . $status_motor_selected_2 . '>Motor Test</option><option value="Online" ' . $status_motor_selected_3 . '>Motor Online</option></select> ';


            $start_time = $record->updated_at; // fill this in with actual time in this format
            $current_time = date('Y-m-d H:i:s'); // fill this in with actual time in this format

            $diff = strtotime($current_time) - strtotime($start_time);

            if ($diff > 60) {
                $time_warrning = "offline";
            } else {
                $time_warrning = "online";
            }

            // if ($record->status == 'Maintenance' ||  $record->status == 'Offline') {
            if ($record->status == 'Maintenance' ||  $time_warrning === 'offline') {
                $status = '<i class="fa fa-fw fa-circle text-danger status_' . $record->id . '"></i>';
            } else {
                $status = '<i class="fa fa-fw fa-circle text-success status_' . $record->id . '"></i>';
            }

            $data[] = array(
                "id" => $record->id,
                "kiosk_id" => $status . '<a href="' . base_url('backend/machine_tracking/device/edit/' . $record->id) . '">' . $record->kiosk_id . '</a><br>' . $time_warrning,
                "location_name" => '<a href="' . base_url('backend/machine_tracking/device/edit/' . $record->id) . '">' . $record->location_name . '</a><br>' . $timeAgo->inWords(new DateTime($record->updated_at)),
                // "status" => $record->fark, software_update
                "version" => "SV:" . $record->software_version . " - HV:" . $record->hardware_version,
                "request" => $request
            );
        }

        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );

        exit(json_encode($response));
    }

    public function delete($id)
    {
        // If there is no device in this id, then redirect
        $tot = $this->Model_device->device_check($id);
        if (!$tot) {
            redirect(base_url() . 'backend/machine_device/device');
            exit;
        }

        $this->Model_device->delete($id);

        $success = 'Device is deleted successfully';
        $this->session->set_flashdata('success', $success);
        redirect(base_url() . 'backend/machine_tracking/device');
    }
}
