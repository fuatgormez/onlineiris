<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Partner extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Model_common');
		$this->load->model('Model_home');
		$this->load->model('Model_portfolio');

		$this->load->library('cart');
		$this->load->library('email');
		$this->lang->load('file', $this->session->userdata('site_language') ?? $this->session->userdata('store_language'));
		// $this->output->cache(60);

		// $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url()) : $this->session->userdata('store_language') ;
	}

	public function index()
	{

		$data['setting'] = $this->Model_common->all_setting();
		$data['page_home'] = $this->Model_common->all_page_home();
		//		$data['comment'] = $this->Model_common->all_comment();
		$data['social'] = $this->Model_common->all_social();
		$data['all_news'] = $this->Model_common->all_news();
		$data['all_news_category'] = $this->Model_common->all_news_category();

		$data['page_contact'] = $this->Model_common->all_page_contact();

		$data['sliders'] = $this->Model_home->all_slider();
		$data['services'] = $this->Model_home->all_service();
		$data['features'] = $this->Model_home->all_feature();
		$data['why_choose'] = $this->Model_home->all_why_choose();
		$data['how_we_works'] = $this->Model_home->all_how_we_works();
		$data['team_members'] = $this->Model_home->all_team_member();
		$data['testimonials'] = $this->Model_home->all_testimonial();
		$data['clients'] = $this->Model_home->all_client();
		$data['pricing_table'] = $this->Model_home->all_pricing_table();
		$data['home_faq'] = $this->Model_home->all_faq_home();

		$data['portfolio_category'] = $this->Model_portfolio->get_portfolio_category();
		$data['portfolio'] = $this->Model_portfolio->get_portfolio_data();

		$data['portfolio_footer'] = $this->Model_portfolio->get_portfolio_data();

		$data['stores'] = $this->Model_common->get_all_store();
		//        $data['store_langs'] = $this->Model_common->get_all_store_lang();

		$data['theme'] = $data['setting']['layout'];

		$this->load->view('layout/' . $data['setting']['layout'] . '/view_header', $data);
		$this->load->view('layout/' . $data['setting']['layout'] . '/view_partner', $data);
		$this->load->view('layout/' . $data['setting']['layout'] . '/view_footer', $data);
	}

	public function send()
	{

		$data['setting'] = $this->Model_common->all_setting();

		$error = '';

		if (isset($_POST['form_contact'])) {

			$valid = 1;

			$this->form_validation->set_rules('firstname', 'Name', 'trim|required');
			$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
			$this->form_validation->set_rules('message', 'Message', 'trim|required');
			$this->form_validation->set_error_delimiters('', '<br>');

			if ($this->form_validation->run() == FALSE) {
				$valid = 0;
				$error .= validation_errors();
			}

			if ($valid == 1) {
				$msg = '
            		<h3>Sender Information</h3>
					<b>Name: </b> ' . $this->input->post('firstname') .' '.$this->input->post('lastname'). '<br><br>
					<b>Phone: </b> ' . $this->input->post('phone') . '<br><br>
					<b>Email: </b> ' . $this->input->post('email') . '<br><br>
					<b>Stückzahl: </b> ' . $this->input->post('qty') . '<br><br>
					<b>Anmerkung: </b> ' . $this->input->post('message') . '
				';

				$this->email->from($data['setting']['send_email_from']);
				$this->email->to($data['setting']['receive_email_to']);
				// $this->email->to($_POST['email']);
				$this->email->subject('Partner Form Email');
				$this->email->message($msg);
				$this->email->set_mailtype("html");
				$this->email->send();

				$success = "Vielen Dank für Ihre Anfrage. Wir werden uns in kürze mit Ihnen in Kontakt setzen.";
				$error = "Fehlermeldung! Bitte erneut versuchen.";

				//$success = 'Thank you for sending the email. We will contact you shortly.';
				// $this->session->set_flashdata('success', $this->lang->line('contact_form_send_success'));
				$this->session->set_flashdata('success', $success);
			} else {
				$this->session->set_flashdata('error', $error);
			}

			redirect(base_url('partner#partner'));
		} else {

			redirect(base_url('partner#partner'));
		}
	}
}
