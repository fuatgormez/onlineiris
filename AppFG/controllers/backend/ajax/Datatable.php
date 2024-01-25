<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Datatable extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('id')) {
            redirect(base_url() . 'backend/admin');
        }

        $this->load->model('backend/datatable/Model_datatable');

    }

    function index(){
        
    }
    
    
}
