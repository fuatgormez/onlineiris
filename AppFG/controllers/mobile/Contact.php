<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contact extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Model_common');
		$this->load->model('Model_contact');

		$this->load->library('cart');
		// $this->output->cache(60);
		// $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url()) : $this->session->userdata('store_language');


		$this->load->library('email');
	}

	public function index()
	{
		$data['setting'] = $this->Model_common->all_setting();
		$data['page_contact'] = $this->Model_common->all_page_contact();


		$this->load->view('layout/mobile/view_header', $data);
		if($data['setting']['website_status_mobile'] === 'Active' || in_array($this->session->userdata('role'), ['Superadmin','Admin']))
        {
            $this->load->view('layout/mobile/view_contact',$data);
        } else {
            $this->load->view('layout/mobile/view_maintenance', $data);
        }
		$this->load->view('layout/mobile/view_footer', $data);
	}

	public function send_email()
	{

		$data['setting'] = $this->Model_common->all_setting();

		$error = '';

		if (isset($_POST['form_contact'])) {

			$valid = 1;

			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
			$this->form_validation->set_rules('message', 'Message', 'trim|required');
			$this->form_validation->set_error_delimiters('', '<br>');

			if ($this->form_validation->run() == FALSE) {
				$valid = 0;
				$error .= validation_errors();
			}

			if ($valid == 1) {

				$form_data = array(
					'name' 		=> $this->input->post('name'),
					'phone' 	=> $this->input->post('phone'),
					'email' 	=> $this->input->post('email'),
					'subject'	=> $this->input->post('subject'),
					'message'	=> $this->input->post('message')
				);

				$this->Model_contact->insert($form_data);

				$success = 'Thank you for sending the email. We will contact you shortly.';
				$this->session->set_flashdata('success', $success);
			} else {
				$this->session->set_flashdata('error', $error);
			}

			exit(json_encode(array('status' => 200, 'msg' => 'success')));
		} else {

			redirect(base_url('contact'));
		}
	}
}
