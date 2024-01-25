<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Store extends CI_Controller
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


        $this->load->view('backend/admin/view_header', $data);
        $this->load->view('backend/machine_tracking/view_store', $data);
        $this->load->view('backend/admin/view_footer');
    }
}
