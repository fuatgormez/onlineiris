<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ads_log extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('id')) {
            redirect(base_url() . 'backend/admin/login');
        }

        $this->load->library('logger/logger');

        $this->load->model('backend/admin/Model_common');
        $this->load->model('api/Model_ads_log');

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

        $data['ads_logs'] = $this->Model_ads_log->show();

        $this->load->view('backend/admin/view_header', $data);
        $this->load->view('backend/shop/view_ads_log', $data);
        $this->load->view('backend/admin/view_footer');
    }
}
