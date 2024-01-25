<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Global_variables
{
    private $_CI;

    function __construct()
    {
        $this->_CI = &get_instance();
        // $this->_CI->load->model('Dynamic_Model','dm');
        // $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url()) : $this->session->userdata('store_language') ;
    }

    public function index()
    {
        redirect(base_url());
    }
    
    public function statistic()
    {
        $this->_CI->load->model('backend/admin/Model_dashboard');

        $data['total_category'] = $this->_CI->Model_dashboard->show_total_category();
		$data['total_news'] = $this->_CI->Model_dashboard->show_total_news();
		$data['total_team_member'] = $this->_CI->Model_dashboard->show_total_team_member();
		$data['total_client'] = $this->_CI->Model_dashboard->show_total_client();
		$data['total_service'] = $this->_CI->Model_dashboard->show_total_service();
		$data['total_testimonial'] = $this->_CI->Model_dashboard->show_total_testimonial();
		$data['total_event'] = $this->_CI->Model_dashboard->show_total_event();
		$data['total_photo'] = $this->_CI->Model_dashboard->show_total_photo();
		$data['total_pricing_table'] = $this->_CI->Model_dashboard->show_total_pricing_table();
		$data['total_ticket'] = $this->_CI->Model_dashboard->show_total_ticket();

        return $data;
    }
}
