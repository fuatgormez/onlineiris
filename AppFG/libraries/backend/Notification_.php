<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Notification_
{
    // private $_CI;

    function __construct()
    {
        $this->_CI = &get_instance();
        // $this->_CI->load->model('Dynamic_Model','dm');
        // $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url()) : $this->session->userdata('store_language') ;
    }

    
    public function index()
    {
        $this->_CI->load->model('backend/admin/Model_notification');

		$data['all_notification'] = $this->_CI->Model_notification->show();

        // $this->_CI->load->view('backend/notification/view_notification',$data);
        
    }
}
