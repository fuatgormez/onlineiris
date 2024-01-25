<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct()
	{
        parent::__construct();
        $this->load->model('Model_common');
        $this->load->model('Model_home');
		$this->load->model('Model_service');
        $this->load->model('Model_portfolio');
		$this->load->model('shop/Model_shopping_cart');

		$this->load->library('cart');
		$this->load->library('set_store_url');
		$this->load->library('facebook_pixel');

        $this->lang->load('file', $this->session->userdata('site_language') ?? 'en');

		// $this->output->cache(60);
        // $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url()) : $this->session->userdata('store_language') ;

		if(!$this->session->userdata('order_number_token'))
        	$this->session->set_userdata('order_number_token', rand(100, 1000) . time());
        	$this->session->set_userdata('security_number_token', rand(100, 1000) . time());
    }

	public function index($store_id=1, $version=2)
	{
		try {
			$data['setting'] = $this->Model_common->all_setting();
			$data['page_home'] = $this->Model_common->all_page_home();
			$store = $this->Model_common->store_check($store_id);

			$this->session->set_userdata('store', $store);
			$this->session->set_userdata('version', $version);

			if($this->session->userdata('version') < 2)
				exit('“A new version is available. Please update and restart”');

			$this->load->view('layout/mobile/view_header', $data);
			if($data['setting']['website_status_mobile'] === 'Active' || in_array($this->session->userdata('role'), ['Superadmin','Admin']))
			{
				$this->load->view('layout/mobile/view_home',$data);
			} else {
				$this->load->view('layout/mobile/view_maintenance', $data);
			}
			$this->load->view('layout/mobile/view_footer', $data);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function index_old()
	{

		$data['setting'] = $this->Model_common->all_setting();
		$data['page_home'] = $this->Model_common->all_page_home();
		//$data['comment'] = $this->Model_common->all_comment();
		$data['social'] = $this->Model_common->all_social();
		$data['all_news'] = $this->Model_common->all_news();
		$data['all_news_category'] = $this->Model_common->all_news_category();

        $data['page_contact'] = $this->Model_common->all_page_contact();

		$data['sliders'] = $this->Model_home->all_slider();
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

		
		$land_id = empty($this->session->userdata('land_id')) ? redirect(base_url('select_land')) : $this->session->userdata('land_id') ;
        $store_id = empty($this->session->userdata('store_id')) ? redirect(base_url('select_land')) : $this->session->userdata('store_id') ;
        $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url('select_land')) : $this->session->userdata('store_language') ;
        // $store_currency_icon = empty($this->session->userdata('currency_icon')) ? redirect(base_url()) : $this->session->userdata('currency_icon') ;
        // $store_currency_code = empty($this->session->userdata('currency_code')) ? redirect(base_url()) : $this->session->userdata('currency_code') ;

		//$data['product'] = $this->Model_shopping_cart->single_product($store_lang_data);
        // $data['products'] = $this->Model_shopping_cart->all_product($store_lang_data,$store_id);
        // $data['product_categories'] = $this->Model_shopping_cart->all_product_category($store_lang_data,$store_id);
        $data['products'] = $this->Model_shopping_cart->all_product($store_lang_data, $land_id);
        $data['product_categories'] = $this->Model_shopping_cart->all_product_category($store_lang_data);
        $data['product_category_photo'] = $this->Model_shopping_cart->all_product_category_photo();

        $data['services'] = $this->Model_service->all_service();

        $data['stores'] = $this->Model_common->get_all_store();
        $data['store_langs'] = $this->Model_common->get_all_store_value();

		if (base_url() === "https://www.irispicture.com/" || base_url() === "https://www.youririsfoto.nl/" || base_url() === "https://www.youririsfoto.com/" || base_url() === "https://www.youririsfoto.be/iptal") {
            $this->facebook_pixel->PageView(
            // $pixel_id, $token
            $this->Model_common->all_setting()['facebook_init'],
            $this->Model_common->all_setting()['facebook_access_token']
            );
        }


		$data['theme'] = $data['setting']['layout'];

		$this->load->view('layout/'.$data['setting']['layout'].'/view_header',$data);
		if($data['setting']['website_status_frontend'] === 'Active' || in_array($this->session->userdata('role'), ['Superadmin','Admin']))
        {
            $this->load->view('layout/'.$data['setting']['layout'].'/view_home',$data);
        } else {
            $this->load->view('view_maintenance', $data);
        }
		$this->load->view('layout/'.$data['setting']['layout'].'/view_footer',$data);
	}

	public function send_email() {

		$data['setting'] = $this->Model_common->all_setting();

		$error = '';

		if(isset($_POST['form_contact'])) {

			$valid = 1;

			if($_POST['pest_control'] == 'Pest Control') {
	    		$pest_control_status = 'Yes';
	    	} else {
	    		$pest_control_status = 'No';
	    	}

	    	if($_POST['termite_control'] == 'Termite Control') {
	    		$termite_control_status = 'Yes';
	    	} else {
	    		$termite_control_status = 'No';
	    	}

	    	if($_POST['damage_repair'] == 'Damage Repair') {
	    		$damage_repair_status = 'Yes';
	    	} else {
	    		$damage_repair_status = 'No';
	    	}

			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
			$this->form_validation->set_rules('phone', 'Phone Number', 'trim|required');
			$this->form_validation->set_rules('city', 'City', 'trim|required');
			$this->form_validation->set_error_delimiters('', '<br>');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }

            if( $pest_control_status == 'No' && $termite_control_status == 'No' && $damage_repair_status == 'No' ) {
            	$valid = 0;
                $error .= 'You must have to select at least one service.';
            }

		    if($valid == 1)
		    {
				$msg = '
            		<h3>Visitor Information</h3>
					<b>Name: </b> '.$_POST['name'].'<br><br>
					<b>Email: </b> '.$_POST['email'].'<br><br>
					<b>Phone: </b> '.$_POST['phone'].'<br><br>
					<b>City: </b> '.$_POST['city'].'<br><br>
					<b>Pest Control: </b> '.$pest_control_status.'<br><br>
					<b>Termite Control: </b> '.$termite_control_status.'<br><br>
					<b>Damage Repair: </b> '.$damage_repair_status.'
				';
            	$this->load->library('email');

				$this->email->from($data['setting']['website_email']);
				$this->email->to($data['setting']['receive_email']);

				$this->email->subject('Contact Form Email');
				$this->email->message($msg);

				$this->email->set_mailtype("html");

				$this->email->send();

		        $success = 'Thank you for sending the email. We will contact with you shortly.';
        		$this->session->set_flashdata('success',$success);

		    } 
		    else
		    {
        		$this->session->set_flashdata('error',$error);
		    }

			redirect(base_url());
            
        } else {
            
            redirect(base_url());
        }
	}
}
