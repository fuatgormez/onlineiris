<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Search extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model_common');
        $this->load->model('Model_search');
        $this->load->model('Model_portfolio');
        $this->load->model('Model_service');

        $this->load->library('cart');
        $this->lang->load('file', $this->session->userdata('site_language') ?? $this->session->userdata('store_language'));
        //$this->output->cache(60);
        // $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url()) : $this->session->userdata('store_language') ;
    }

    public function index()
    {

        $data['setting'] = $this->Model_common->all_setting();
        $data['page_home'] = $this->Model_common->all_page_home();
        $data['page_search'] = $this->Model_common->all_page_search();
        $data['comment'] = $this->Model_common->all_comment();
        $data['social'] = $this->Model_common->all_social();
        $data['all_news'] = $this->Model_common->all_news();
        $data['services'] = $this->Model_service->all_service();
        $data['page_contact'] = $this->Model_common->all_page_contact();
        $data['portfolio_footer'] = $this->Model_portfolio->get_portfolio_data();

        $data['stores'] = $this->Model_common->get_all_store();
        $data['store_langs'] = $this->Model_common->get_all_store_lang();

        $data['theme'] = $data['setting']['layout'];

        $error2 = '';

        if (isset($_POST['search_string'])) {

            $data['search_string'] = $this->input->post('search_string');
            $data['result'] = $this->Model_search->search($this->input->post('search_string'));
            $data['total'] = $this->Model_search->search_total($this->input->post('search_string'));

            $this->load->view('layout/' . $data['setting']['layout'] . '/view_header', $data);
            $this->load->view('layout/' . $data['setting']['layout'] . '/view_search', $data);
            $this->load->view('layout/' . $data['setting']['layout'] . '/view_footer', $data);

        } else {
            redirect(base_url());
        }

    }
}