<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contact extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Model_common');
		$this->load->model('Model_contact');
		$this->load->model('Model_portfolio');
		$this->load->model('Model_service');

		$this->load->library('cart');
		$this->lang->load('file', $this->session->userdata('site_language') ?? $this->session->userdata('store_language'));
		// $this->output->cache(60);
		// $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url()) : $this->session->userdata('store_language');


		$this->load->library('email');
	}

	public function index()
	{
		$data['setting'] = $this->Model_common->all_setting();
		$data['page_home'] = $this->Model_common->all_page_home();
		$data['page_contact'] = $this->Model_common->all_page_contact();
		$data['social'] = $this->Model_common->all_social();
		$data['all_news'] = $this->Model_common->all_news();
		$data['services'] = $this->Model_service->all_service();
		$data['page_contact'] = $this->Model_common->all_page_contact();


		$data['stores'] = $this->Model_common->get_all_store();
		$data['store_langs'] = $this->Model_common->get_all_store_value();

		$data['theme'] = $data['setting']['layout'];

		$this->load->view('layout/' . $data['setting']['layout'] . '/view_header', $data);
		if($data['setting']['website_status_frontend'] === 'Active' || in_array($this->session->userdata('role'), ['Superadmin','Admin']))
        {
            $this->load->view('layout/'.$data['setting']['layout'].'/view_contact',$data);
        } else {
            $this->load->view('view_maintenance', $data);
        }
		$this->load->view('layout/' . $data['setting']['layout'] . '/view_footer', $data);
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

				$msg = '
            		<h3>Sender Information</h3>
					<b>Name: </b> ' . $this->input->post('name') . '<br><br>
					<b>Phone: </b> ' . $this->input->post('phone') . '<br><br>
					<b>Email: </b> ' . $this->input->post('email') . '<br><br>
					<b>Subject: </b> ' . $this->input->post('subject') . '<br><br>
					<b>Message: </b> ' . $this->input->post('message') . '
				';

				$this->email->from($data['setting']['send_email_from']);
				$this->email->to($data['setting']['receive_email_to']);
				// $this->email->to($_POST['email']);
				$this->email->reply_to($this->input->post('email'), $this->input->post('name'));
				$this->email->subject('Contact Form Email');
				$this->email->message($msg);
				$this->email->set_mailtype("html");
				$this->email->send();


				//$success = 'Thank you for sending the email. We will contact you shortly.';
				$this->session->set_flashdata('success', $this->lang->line('contact_form_send_success'));
			} else {
				$this->session->set_flashdata('error', $error);
			}

			exit(json_encode(array('status' => 200, 'msg' => 'success')));
		} else {

			redirect(base_url('contact'));
		}
	}
}
