<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cache extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('id')) {
            redirect(base_url().'backend/admin/login');
            exit;
        }

        $this->load->model('backend/admin/Model_common');
        
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
        array_map( 'unlink', array_filter((array) glob("application/cache/*") ) );
        redirect(base_url().'backend/admin/dashboard');
    }
}