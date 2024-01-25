<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Info extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->library('logger/logger');

        $this->load->model('backend/admin/Model_common');
    }


    public function index()
    {
        $data['setting'] = $this->Model_common->get_setting_data();

        if (!in_array($this->session->userdata('role'), ['Superadmin'])) {
            if ($data['setting']['website_status_backend'] === "Active") {
                redirect(base_url('backend/admin'));
            }
        }

        $this->load->view('backend/admin/view_header');
        $this->load->view('backend/view_backend_website_status', $data);
        $this->load->view('backend/admin/view_footer');
    }
}
