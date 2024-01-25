<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Groupon extends CI_Controller
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
            $this->load->view('layout/' . $data['setting']['layout'] . '/shop/view_groupon', $data);
        } else {
            $this->load->view('view_maintenance', $data);
        }
        $this->load->view('layout/' . $data['setting']['layout'] . '/view_footer', $data);
    }

    public function add()
    {

        $error = '';

        if (isset($_POST['form_groupon'])) {

            $valid = 1;

            $this->form_validation->set_rules('first_name', 'Vorname', 'required');
            $this->form_validation->set_rules('last_name', 'Vorname', 'required');
            $this->form_validation->set_rules('phone', 'Phone', 'required');
            $this->form_validation->set_rules('street', 'Staße', 'required');
            $this->form_validation->set_rules('street_no', 'Staße Nummer', 'required');
            $this->form_validation->set_rules('plz', 'PLZ', 'required');
            $this->form_validation->set_rules('city', 'Stadt', 'required');
            $this->form_validation->set_rules('wunschstandort', 'Wunschstandort', 'required');
            $this->form_validation->set_rules('coupon_code', 'Gutschein Code ', 'trim|required');
            $this->form_validation->set_rules('security_code', 'Security Code', 'trim|required');
            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
            $this->form_validation->set_error_delimiters('', '<br>');

            if ($this->form_validation->run() == FALSE) {
                $valid = 0;
                $error .= validation_errors();
            }

            if ($valid == 1) {
                $msg = '
            		<h3>Sender Information</h3>
					<b>Vorname: </b> ' . $_POST['first_name'] . '<br><br>
					<b>Nachname: </b> ' . $_POST['last_name'] . '<br><br>
					<b>Phone: </b> ' . $_POST['phone'] . '<br><br>
					<b>Str.: </b> ' . $_POST['street'] . '<br><br>
					<b>Str Nr.: </b> ' . $_POST['street_no'] . '<br><br>
					<b>Plz: </b> ' . $_POST['plz'] . '<br><br>
					<b>Stadt: </b> ' . $_POST['city'] . '<br><br>
					<b>Wunschstandort: </b> ' . $_POST['wunschstandort'] . '<br><br>
					<b>Email: </b> ' . $_POST['email'] . '<br><br>
					<b>Gutschein  code: </b> ' . $_POST['coupon_code'] . '<br><br>
					<b>Security  code: </b> ' . $_POST['security_code'] . '<br><br>
					<b>Bemerkung: </b> ' . $_POST['message'] . '
				';



                $this->load->library('email');
                $this->load->library('shop_email');

                $this->shop_email->send_email_groupon($msg);

                $this->session->set_flashdata('success', "Vielen Dank für Deine Buchung. In kürze senden wir Dir alle notwendigen Unterlagen, die Du für das Shooting vor Ort benötigst, an die von dir angegeben E-Mailadresse.");
            } else {
                $this->session->set_flashdata('error', $error);
            }

            redirect(base_url() . 'shop/groupon');
        } else {

            redirect(base_url() . 'shop/groupon');
        }
    }
}
