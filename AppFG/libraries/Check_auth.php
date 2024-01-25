<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Check_auth
{
    private $_CI;

    function __construct()
    {
        $this->_CI = &get_instance();
        $this->_CI->load->model('backend/admin/Model_common');
    }

    public function index()
    {
        redirect(base_url());
    }

    public function Authorize ($controller, $role)
    {
        
        $data['authorize'] = $this->_CI->Model_common->authorize($controller);
        
        if (!in_array($role, json_decode($data['authorize']['role']))) {
            redirect(base_url() . 'backend/admin');
        }
    }

    public function LoginCheck($id)
    {
        if (!$id) {
            redirect(base_url() . 'backend/admin/login');
        }
    }

    public function AuthorizeWebsiteStatusBackend($role)
    {
        if (!in_array($role, ['Superadmin'])) {
            $data['setting'] = $this->_CI->Model_common->get_setting_data();

            if ($data['setting']['website_status_backend'] === "Passive") {
                $data['message'] = $data['setting']['website_status_backend_message'];
                redirect(base_url('backend/info'));
            }
        }
    }
}
