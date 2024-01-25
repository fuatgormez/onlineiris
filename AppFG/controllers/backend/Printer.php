<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Printer extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        $data['print'] = array(
            'label' => 'amk',
        );
        $this->load->view('backend/backend_website_status', $data);
    }
}
