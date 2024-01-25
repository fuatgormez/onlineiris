<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Checkout extends CI_Controller
{
    public $mollie;

    function __construct()
    {
        parent::__construct();
        $this->load->model('Model_common');
        $this->load->model('Model_service');
        $this->load->model('shop/Model_order');
        //        $this->load->model('shop/Model_shopping_cart');

        $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url()) : $this->session->userdata('store_language');
        $this->lang->load('file', $this->session->userdata('site_language') ?? $this->session->userdata('store_language'));

        $this->load->library('cart');
        $this->load->library('shop_email');



        if (empty($this->cart->contents())) {
            redirect(base_url('shop'));
            return;
        }

        $this->mollie = new \Mollie\Api\MollieApiClient();
        $select_mollie_key =  $this->Model_common->all_setting_shop();

        if ($select_mollie_key["mollie_current_key"] === "test") {
            $this->mollie->setApiKey($select_mollie_key["mollie_test_key"]);
        } else {
            $this->mollie->setApiKey($select_mollie_key["mollie_live_key"]);
        }
    }

    public function index()
    {

        redirect(base_url('shop/checkout/data'));
    }

    public function data()
    {

        $data['setting'] = $this->Model_common->all_setting();
        $data['page_home'] = $this->Model_common->all_page_home();
        $data['social'] = $this->Model_common->all_social();
        $data['services'] = $this->Model_service->all_service();

        $data['description'] = 'Shopping Cart';

        $data['stores'] = $this->Model_common->get_all_store();
        $data['store_langs'] = $this->Model_common->get_all_store_value();

        // $data['all_land'] = $this->Model_common->get_all_land();

        $data['theme'] = $data['setting']['layout'];

        //When the order is isPaid, end the session! Don't forget!
        $order_number_token = rand(100, 1000) . time();
        $security_number_token = rand(100, 1000) . time();
        $this->session->set_userdata('order_number_token', $order_number_token);
        $this->session->set_userdata('security_number_token', $security_number_token);

        $data['methods'] = $this->mollie->methods->allActive();

        $this->load->view('layout/' . $data['setting']['layout'] . '/view_header', $data);
        $this->load->view('layout/' . $data['setting']['layout'] . '/shop/view_checkout_data', $data);
        $this->load->view('layout/' . $data['setting']['layout'] . '/view_footer', $data);
    }

    public function add()
    {
        $error = '';
        $success = '';

        if ($this->input->post()) {
            $valid = 1;

            $this->session->set_userdata('keep_input_value', $this->input->post());

            $this->form_validation->set_rules('billingFirstName', 'First Name', 'trim|required');
            $this->form_validation->set_rules('billingLastName', 'Last Name', 'trim|required');
            $this->form_validation->set_rules('billingEmail', 'Email', 'trim|valid_email|required');
            $this->form_validation->set_rules('billingPhone', 'Phone', 'trim|required');
            $this->form_validation->set_rules('billingStreet', 'Street', 'trim|required');
            $this->form_validation->set_rules('billingPostCode', 'Post Code', 'trim|required');
            $this->form_validation->set_rules('billingCity', 'City', 'trim|required');
            $this->form_validation->set_rules('billingCountry', 'Country', 'trim|required');
            // $this->form_validation->set_rules('payment_method', 'Payment Method', 'trim|required');


            if ($this->form_validation->run() == FALSE) {
                $valid = 0;
                $error .= validation_errors();
            }

            if ($valid == 1) {

                $form_data = array(
                    "billing_firstname" => $this->input->post('billingFirstName'),
                    "billing_lastname" => $this->input->post('billingLastName'),
                    "billing_email" => $this->input->post('billingEmail'),
                    "billing_phone" => $this->input->post('billingPhone'),
                    "billing_street" => $this->input->post('billingStreet'),
                    "billing_street_no" => $this->input->post('billingStreetNo'),
                    "billing_postcode" => $this->input->post('billingPostCode'),
                    "billing_city" => $this->input->post('billingCity'),
                    "billing_country" => $this->input->post('billingCountry'),
                    "billing_comment" => $this->input->post('billingComment'),

                    "shipping_firstname" => $this->input->post('shippingFirstName'),
                    "shipping_lastname" => $this->input->post('shippingLastName'),
                    "shipping_email" => $this->input->post('shippingEmail'),
                    "shipping_phone" => $this->input->post('shippingPhone'),
                    "shipping_street" => $this->input->post('shippingStreet'),
                    "shipping_street_no" => $this->input->post('shippingStreetNo'),
                    "shipping_postcode" => $this->input->post('shippingPostCode'),
                    "shipping_city" => $this->input->post('shippingCity'),
                    "shipping_country" => $this->input->post('shippingCountry'),
                    "shipping_comment" => $this->input->post('shippingComment'),

                    // "payment_method" => $this->input->post('payment_method'), //gegen_vorkasse bu kisim dinamik olacak
                    "order_type" => "web",
                    "order_number" => $this->session->userdata('order_number_token'),
                    "security_number" => $this->session->userdata('security_number_token'),
                    // "tracking_number" => $number = rand(100, 100000) . time(),

                    "store_currency_code" => $this->session->userdata('currency_code'),
                    "store_currency_icon" => $this->session->userdata('currency_icon'),
                    "store_lang_code" => $this->session->userdata('store_language'),

                    "store_id" => $this->session->userdata('store_id'),
                    "store_name" => $this->session->userdata('store_name'),
                    "land_id" => $this->session->userdata('land_id'),
                    "land_name" => $this->session->userdata('land_name'),

                    "coupon_code"    => $this->session->userdata('coupon_code'),
                    "discount_amount"  => $this->session->userdata('discount_amount'),
                    "total" => $this->cart->total(),
                );

                //$this->session->set_userdata('payment_form_items', $form_data_item);
                $this->session->set_userdata('payment_form', $form_data);

                redirect(base_url('shop/checkout/payment'));
            } else {
                $this->session->set_flashdata('error', $error);
                redirect(base_url('shop/checkout/data'));
            }
        }
    }

    public function payment()
    {
        $data['setting'] = $this->Model_common->all_setting();
        $data['page_home'] = $this->Model_common->all_page_home();
        $data['social'] = $this->Model_common->all_social();
        $data['services'] = $this->Model_service->all_service();

        $data['description'] = 'Shopping Cart';

        $data['stores'] = $this->Model_common->get_all_store();
        $data['store_langs'] = $this->Model_common->get_all_store_value();

        $data['theme'] = $data['setting']['layout'];

        $data['methods'] = $this->mollie->methods->allActive();

        $this->load->view('layout/' . $data['setting']['layout'] . '/view_header', $data);
        $this->load->view('layout/' . $data['setting']['layout'] . '/shop/view_checkout_payment', $data);
        $this->load->view('layout/' . $data['setting']['layout'] . '/view_footer', $data);
    }

    public function set_flashdata_redirect($error, $url)
    {
        $this->session->set_flashdata('error', $error);
        redirect(base_url($url));
    }

    public function payment_sent()
    {

        $error = '';
        $success = '';

        $valid = 1;

        if(empty($this->session->userdata('payment_form')['billing_firstname'])){
            $valid = 0;
            $this->set_flashdata_redirect("The First Name field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['billing_lastname'])){
            $valid = 0;
            $this->set_flashdata_redirect("The Last Name field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['billing_email'])){
            $valid = 0;
            $this->set_flashdata_redirect("The Email field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['billing_phone'])){
            $valid = 0;
            $this->set_flashdata_redirect("The Phone field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['billing_street'])){
            $valid = 0;
            $this->set_flashdata_redirect("The Street field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['billing_postcode'])){
            $valid = 0;
            $this->set_flashdata_redirect("The Postcode field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['billing_city'])){
            $valid = 0;
            $this->set_flashdata_redirect("The City field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['billing_country'])){
            $valid = 0;
            $this->set_flashdata_redirect("The Country field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['land_id'])){
            $valid = 0;
            $this->set_flashdata_redirect("The land id field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['land_name'])){
            $valid = 0;
            $this->set_flashdata_redirect("The Land name field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['store_id'])){
            $valid = 0;
            $this->set_flashdata_redirect("The Store id field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['store_name'])){
            $valid = 0;
            $this->set_flashdata_redirect("The Store name field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['store_lang_code'])){
            $valid = 0;
            $this->set_flashdata_redirect("The Store lang code field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['store_currency_icon'])){
            $valid = 0;
            $this->set_flashdata_redirect("The Store currency icon field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['store_currency_code'])){
            $valid = 0;
            $this->set_flashdata_redirect("The Store currency code field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['order_type'])){
            $valid = 0;
            $this->set_flashdata_redirect("The Order type field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['order_number'])){
            $valid = 0;
            $this->set_flashdata_redirect("The Order number field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['order_number'])){
            $valid = 0;
            $this->set_flashdata_redirect("The Order number field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['security_number'])){
            $valid = 0;
            $this->set_flashdata_redirect("The Security number field is required.", "shop");
        } else {
            $valid = 1;
        }

        if ($valid == 1) {

            //Check if the Cart is empty!
            if (!empty($this->cart->contents())) {
                $coupon_code =  substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10); //categori ile eşleştir
                $total = 0;
                // $uniq_id = rand(100, 1000);
                // $uniq_id = mt_rand(1200,999999999);

                foreach ($this->cart->contents() as $item) {
                    for ($i = 0; $i < $item['qty']; $i++) {
                        $form_data_item = array(
                            "item_product_id" => $item['id'],
                            "item_uniqid" => mt_rand(1200, 999999999),
                            "item_name" => $item['name'],
                            "item_price" => $item['price'],
                            "item_qty" => 1, //$item['qty'],
                            "item_eye_qty" => $item['eye_qty'],
                            "item_image" => $item['image'],
                            "item_type" => $item['product_type'],
                            "item_currency_icon" => $item['currency_icon'],
                            "item_currency_code" => $item['currency_code'],
                            "item_lang_code" => $item['lang_code'],
                            "item_subtotal" => $item['price'], //$item['subtotal'],
                            "order_number" => $this->session->userdata('order_number_token'),
                            "security_number" => $this->session->userdata('security_number_token')
                        );

                        $total += $item['price']; //$item['subtotal'];
                        $this->Model_order->add_order_item($form_data_item);
                    }
                }

                if ($this->session->userdata('payment_method') === "bankTransfer") {

                    $session_form_data = $this->session->userdata('payment_form');
                    $session_form_data['payment_method'] = $this->session->userdata('payment_method');
                    $session_form_data['total'] = $total;
                    $session_form_data['paid'] = "isPending";

                    $this->Model_order->add($session_form_data);

                    echo $this->success_view(); //html şablonu hazir olunca aç

                    $this->shop_email->send_email(
                        $this->session->userdata['payment_form']['store_lang_code'],
                        "bankTransfer",
                        $this->session->userdata['payment_form']['billing_email'],
                        $this->session->userdata['payment_form']['order_number']
                    );

                    //Destroy all session
                    $this->session->unset_userdata('order_number_token');
                    $this->session->unset_userdata('keep_input_value');
                    $this->session->unset_userdata('payment_form');

                    //Destroy Cart Session
                    $this->cart->destroy();
                } else {

                    $payment = $this->mollie->payments->create([
                        'amount' => [
                            'currency' => $this->session->userdata('currency_code'),
                            // 'value' => $this->cart->total()
                            'value' => number_format($this->cart->total(), 2)
                        ],
                        'method' => $this->session->userdata('payment_method'),
                        'description' => 'IRISPICTURE',
                        'redirectUrl' => base_url('shop/checkout/success')
                        // 'webhookUrl' => base_url('shop/checkout/success')
                    ]);

                    $this->session->set_userdata('payment_id', $payment->id);

                    header("Location: " . $payment->getCheckoutUrl(), true, 303);
                }
            } else {
                redirect(base_url('shop'));
            }
        } else {
            $this->session->set_flashdata('error', $error);
            redirect(base_url('shop'));
        }
    }

    public function overview()
    {
        $error = '';
        $success = '';

        if ($this->input->post()) {
            $valid = 1;

            $this->form_validation->set_rules('payment_method', 'Payment Method', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $valid = 0;
                $error .= validation_errors();
            }

            if ($valid == 1) {

                $this->session->set_userdata('payment_method', $this->input->post('payment_method'));

                $data['setting'] = $this->Model_common->all_setting();
                $data['page_home'] = $this->Model_common->all_page_home();
                $data['social'] = $this->Model_common->all_social();
                $data['services'] = $this->Model_service->all_service();

                $data['description'] = 'Shopping Cart';

                $data['stores'] = $this->Model_common->get_all_store();
                $data['store_langs'] = $this->Model_common->get_all_store_value();

                $data['theme'] = $data['setting']['layout'];


                $this->load->view('layout/' . $data['setting']['layout'] . '/view_header', $data);
                $this->load->view('layout/' . $data['setting']['layout'] . '/shop/view_checkout_overview', $data);
                $this->load->view('layout/' . $data['setting']['layout'] . '/view_footer', $data);
            } else {
                $this->session->set_flashdata('error', $error);
                redirect(base_url('shop/checkout/payment'));
            }
        } else {
            $this->session->set_flashdata('error', $error);
            redirect(base_url('shop/checkout/payment'));
        }
    }

    public function success()
    {
        $success = '';
        $error = '';
        $paid = '';


        $payment = $this->mollie->payments->get($this->session->userdata('payment_id'));

        // print_r($this->mollie->payments);exit;

        // if ($payment->isPaid()) {
        if ($payment->status === "paid" || $payment->isPaid()) {

            $session_form_data = $this->session->userdata('payment_form');
            $session_form_data['payment_method'] = $this->session->userdata('payment_method');
            $paid = "isPaid";

            $session_form_data['paid'] = $paid;
            $this->session->set_userdata('payment_form', $session_form_data);
            $this->Model_order->add($session_form_data);

            $success = $this->lang->line('payment_success_message_alert');
            $this->session->set_flashdata('success', $success);

            //gegen vorkasse icin ayri bir mail gonderilecek
            $this->shop_email->send_email(
                $this->session->userdata['payment_form']['store_lang_code'],
                "mollie",
                $this->session->userdata['payment_form']['billing_email'],
                $this->session->userdata['payment_form']['order_number']
            );

            echo $this->success_view();

            //Destroy all session
            $this->session->unset_userdata('order_number_token');
            $this->session->unset_userdata('keep_input_value');
            $this->session->unset_userdata('payment_form');

            //Destroy Cart Session
            $this->cart->destroy();
        } else {
            $paid = "isFailed";
            $this->shop_email->single_email(
                $this->session->userdata['payment_form']['store_lang_code'],
                "MollieError",
                $this->session->userdata['payment_form']['billing_email'],
                $this->session->userdata['payment_form']['order_number']
            );
            redirect(base_url('shop/checkout/overview'));
        }
    }

    public function success_view()
    {
        $data['setting'] = $this->Model_common->all_setting();
        $data['page_home'] = $this->Model_common->all_page_home();
        $data['social'] = $this->Model_common->all_social();
        $data['services'] = $this->Model_service->all_service();

        $data['success_message'] = $this->lang->line('payment_success_message');

        $data['stores'] = $this->Model_common->get_all_store();
        $data['store_langs'] = $this->Model_common->get_all_store_value();

        $data['theme'] = $data['setting']['layout'];

        $this->load->view('layout/' . $data['setting']['layout'] . '/view_header', $data);
        $this->load->view('layout/' . $data['setting']['layout'] . '/shop/view_payment_success', $data);
        $this->load->view('layout/' . $data['setting']['layout'] . '/view_footer', $data);
    }
}
