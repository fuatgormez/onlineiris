<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Social_deal extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        /**
         * fake ürün icin olusturulan coupon codunu kullanmissa normal ürünleri goremesin 
         */
        // if($this->session->userdata('coupon_for_upgrade'))
        //     redirect(base_url('shop/coupon/product'));
        $this->load->model('Model_common');
        $this->load->model('Model_service');
        $this->load->model('shop/Model_shopping_cart');

        $this->lang->load('file', $this->session->userdata('site_language') ?? 'de');
        // $this->lang->load('file', $this->session->userdata('site_language') ?? $this->session->userdata('store_language'));
        // $this->output->cache(60);

        $this->load->library('cart');

        if(!in_array(base_url(), ['https://www.youririsfoto.nl/','https://www.youririsfoto.be/'])){
            redirect(base_url('shop'));
        }

    }

    public function index()
    {

        $data['setting'] = $this->Model_common->all_setting();
        $data['page_home'] = $this->Model_common->all_page_home();
        $data['page_about'] = $this->Model_common->all_page_about();
        $data['comment'] = $this->Model_common->all_comment();
        $data['social'] = $this->Model_common->all_social();

        $data['services'] = $this->Model_service->all_service();

        $data['stores'] = $this->Model_common->get_all_store();
        $data['store_langs'] = $this->Model_common->get_all_store_value();

        $data['theme'] = $data['setting']['layout'];

        $this->load->view('layout/' . $data['setting']['layout'] . '/view_header', $data);
        if ($data['setting']['website_status_frontend'] === 'Active' || in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) {
            $this->load->view('layout/' . $data['setting']['layout'] . '/shop/view_social_deal', $data);
        } else {
            $this->load->view('view_maintenance', $data);
        }
        $this->load->view('layout/' . $data['setting']['layout'] . '/view_footer', $data);
    }

    public function add()
    {

        $error = '';

        if (isset($_POST['form_social_deal'])) {

            $valid = 1;

            $this->form_validation->set_rules('first_name', 'Vorname', 'required');
            $this->form_validation->set_rules('last_name', 'Vorname', 'required');
            $this->form_validation->set_rules('phone', 'Phone', 'required');
            $this->form_validation->set_rules('street', 'Staße', 'required');
            $this->form_validation->set_rules('street_no', 'Staße Nummer', 'required');
            $this->form_validation->set_rules('plz', 'PLZ', 'required');
            $this->form_validation->set_rules('city', 'Stadt', 'required');
            $this->form_validation->set_rules('country', 'Country', 'required');
            $this->form_validation->set_rules('coupon_code', 'Coupon Code ', 'trim|required');
            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
            $this->form_validation->set_error_delimiters('', '<br>');

            if ($this->form_validation->run() == FALSE) {
                $valid = 0;
                $error .= validation_errors();
            }

            if ($valid == 1) {
                $msg = '
            		<h3>Sender Information</h3>
					<b>Fistname: </b> ' . $_POST['first_name'] . '<br><br>
					<b>Lastname: </b> ' . $_POST['last_name'] . '<br><br>
					<b>Phone: </b> ' . $_POST['phone'] . '<br><br>
					<b>Street.: </b> ' . $_POST['street'] . '<br><br>
					<b>Street Nr.: </b> ' . $_POST['street_no'] . '<br><br>
					<b>Plz: </b> ' . $_POST['plz'] . '<br><br>
					<b>City: </b> ' . $_POST['city'] . '<br><br>
					<b>Country: </b> ' . $_POST['country'] . '<br><br>
					<b>Email: </b> ' . $_POST['email'] . '<br><br>
					<b>Coupon  code: </b> ' . $_POST['coupon_code'] . '<br><br>
					<b>Wunschstandort: </b> ' . $_POST['desired_location'] . '<br><br>
					<b>Comment: </b> ' . $_POST['message'] . '
				';


                $this->load->library('email');
                $this->load->library('shop_email');

                $this->shop_email->send_email_social_deal($msg);

                $this->session->set_flashdata('success', "Thank you for your booking. We will shortly send you all the necessary documents that you need for the on-site shooting to the e-mail address you provided.");
            } else {
                $this->session->set_flashdata('error', $error);
            }

            redirect(base_url() . 'shop/social_deal');
        } else {

            redirect(base_url() . 'shop/social_deal');
        }
    }
}
