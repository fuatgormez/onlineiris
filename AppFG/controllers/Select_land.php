<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Select_land extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model_common');
        $this->load->model('Model_search');
        $this->load->model('Model_portfolio');
        $this->load->model('Model_service');

        $this->load->library('cart');
        $this->load->library('set_store_url');

        // $this->lang->load('file', $this->session->userdata('site_language') ?? $this->session->userdata('store_language'));
        $this->lang->load('file', 'de');
        //$this->output->cache(60);

        redirect(base_url('language/select_store/1'));

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

        $data['all_land'] = $this->Model_common->get_all_land();
        $data['stores'] = $this->Model_common->get_all_store();
        $data['store_langs'] = $this->Model_common->get_all_store_value();

        $data['theme'] = $data['setting']['layout'];

        $this->load->view('layout/' . $data['setting']['layout'] . '/view_header', $data);
        if ($data['setting']['website_status_frontend'] === 'Active' || in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) {
            $this->load->view('layout/' . $data['setting']['layout'] . '/view_select_land', $data);
        } else {
            $this->load->view('view_maintenance', $data);
        }
        $this->load->view('layout/' . $data['setting']['layout'] . '/view_footer', $data);
    }

    public function find()
    {
        $error = '';
        $success = '';

        $csrf_fg = $this->security->get_csrf_hash();

        $valid = 1;

        $this->form_validation->set_rules('term', 'Term', 'xss_clean|required');

        if ($this->form_validation->run() == FALSE) {
            $valid = 0;
            $error .= validation_errors();
        }

        if ($valid == 1 && $this->input->post('term')) {

            $store_check = $this->Model_common->find_store($this->input->post('term'));

            if ($store_check) {

                $resultData = array();

                foreach ($store_check as $row_store) {
                    $resultData[] = array(
                        "store_id" => $row_store["id"],
                        "store_name" => $row_store["store_name"],
                        "store_address" => $row_store["store_address"],
                        "photo" => $row_store["photo"],
                        "csrf_fg" => $csrf_fg,
                        "statusCode" => 200
                    );
                }

                // $resultData['statusCode'] = 200;
                // $resultData['csrf_fg'] = $csrf_fg;

                exit(json_encode($resultData));
            } else {
                $error = 'undefined';
                exit(json_encode(array("csrf_fg" => $csrf_fg, "responseMessage" => $error)));
            }
            return;
        } else {
            $error = 'undefined';
            exit(json_encode(array("csrf_fg" => $csrf_fg, "responseMessage" => $error)));
        }
    }

    public function generate_csrf()
    {
        exit(json_encode(array('csrf_fg' => $this->security->get_csrf_hash())));
    }

    public function activation()
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

        $data['all_land'] = $this->Model_common->get_all_land();
        $data['stores'] = $this->Model_common->get_all_store();
        // $data['store_langs'] = $this->Model_common->get_all_store_lang();

        $data['theme'] = $data['setting']['layout'];
        $data['par'] = "a";

        $this->load->view('layout/' . $data['setting']['layout'] . '/view_header', $data);
        if ($data['setting']['website_status_frontend'] === 'Active' || in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) {
            $this->load->view('layout/' . $data['setting']['layout'] . '/view_select_land', $data);
        } else {
            $this->load->view('view_maintenance', $data);
        }
        $this->load->view('layout/' . $data['setting']['layout'] . '/view_footer', $data);
    }
}
