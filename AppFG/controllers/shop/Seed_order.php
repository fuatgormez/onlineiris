<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Seed_order extends CI_Controller
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




        $this->mollie = new \Mollie\Api\MollieApiClient();
        $select_mollie_key =  $this->Model_common->all_setting_shop();


        $this->mollie->setApiKey($select_mollie_key["mollie_test_key"]);
    }

    public function index()
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



        $data['methods'] = $this->mollie->methods->allActive();

        $this->load->view('layout/' . $data['setting']['layout'] . '/view_header', $data);
        $this->load->view('layout/' . $data['setting']['layout'] . '/shop/view_old_orders', $data);
        $this->load->view('layout/' . $data['setting']['layout'] . '/view_footer', $data);
    }

    public function add()
    {
        $error = '';
        $success = '';

        for ($i = 0; $i < 100; $i++) {

            //When the order is isPaid, end the session! Don't forget!
            $order_number_token = rand(100, 1000) . time();
            $security_number_token = rand(100, 1000) . time();

            $form_data1 = array(
                "billing_firstname" => "firstname",
                "billing_lastname" => "lastname",
                "billing_email" => "email",
                "billing_phone" => "phone",
                "billing_street" => "street",
                "billing_street_no" => "street number",
                "billing_postcode" => "postcode",
                "billing_city" => "city",
                "billing_country" => "country",
                "billing_comment" => "",

                "shipping_firstname" => "firstname",
                "shipping_lastname" => "lastname",
                "shipping_email" => "email",
                "shipping_phone" => "phone",
                "shipping_street" => "street",
                "shipping_street_no" => "street number",
                "shipping_postcode" => "postcode",
                "shipping_city" =>  "city",
                "shipping_country"  => "country",
                "shipping_comment"  => "",


                "payment_method" => "bankTransfer", //$this->input->post('payment_method'), //gegen_vorkasse bu kisim dinamik olacak
                "order_type" => "irisshot",
                "order_number" => $order_number_token,
                "security_number" => $security_number_token,
                // "tracking_number" => $number = rand(100, 100000) . time(),

                "store_currency_code" => $this->session->userdata('currency_code'),
                "store_currency_icon" => $this->session->userdata('currency_icon'),
                "store_lang_code" => $this->session->userdata('store_language'),

                "store_id" => $this->session->userdata('store_id'),
                "store_name" => $this->session->userdata('store_name'),
                "land_id" => $this->session->userdata('land_id'),
                "land_name" => $this->session->userdata('land_name'),

                // "coupon_code"    => $this->session->userdata('coupon_code'),
                // "discount_amount"  => $this->session->userdata('discount_amount'),
                "total" => 0.01,
                "paid" => "isPending"
            );


            //Check if the Cart is empty!
            $coupon_code =  substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10); //categori ile eşleştir
            $total = 0;

            $this->Model_order->add($form_data1);

            $form_data_item1 = array(
                "item_product_id" => 170,
                "item_uniqid" => mt_rand(1200, 999999999),
                "item_name" => "Mit einem Auge 20x30 Poster",
                "item_price" => 0.01,
                "item_qty" => 1,
                "item_eye_qty" => 1,
                "item_image" => "https://irispicture.com/public/uploads/product_photos/banner/product_banner_170_gtzt.jpg?v=1623325193",
                "item_currency_icon" => "€",
                "item_currency_code" => "EUR",
                "item_lang_code" => "de",
                "item_subtotal" => 0.01,
                "order_number" => $order_number_token,
                "security_number" => $security_number_token
            );

            $total += 0.01;
            $this->Model_order->add_order_item($form_data_item1);
        }

        for ($i = 0; $i < 100; $i++) {

            //When the order is isPaid, end the session! Don't forget!
            $order_number_token = rand(100, 1000) . time();
            $security_number_token = rand(100, 1000) . time();

            $form_data2 = array(
                "billing_firstname" => "firstname",
                "billing_lastname" => "lastname",
                "billing_email" => "email",
                "billing_phone" => "phone",
                "billing_street" => "street",
                "billing_street_no" => "street number",
                "billing_postcode" => "postcode",
                "billing_city" => "city",
                "billing_country" => "country",
                "billing_comment" => "",

                "shipping_firstname" => "firstname",
                "shipping_lastname" => "lastname",
                "shipping_email" => "email",
                "shipping_phone" => "phone",
                "shipping_street" => "street",
                "shipping_street_no" => "street number",
                "shipping_postcode" => "postcode",
                "shipping_city" =>  "city",
                "shipping_country"  => "country",
                "shipping_comment"  => "",


                "payment_method" => "bankTransfer", //$this->input->post('payment_method'), //gegen_vorkasse bu kisim dinamik olacak
                "order_type" => "irisshot",
                "order_number" => $order_number_token,
                "security_number" => $security_number_token,
                // "tracking_number" => $number = rand(100, 100000) . time(),

                "store_currency_code" => $this->session->userdata('currency_code'),
                "store_currency_icon" => $this->session->userdata('currency_icon'),
                "store_lang_code" => $this->session->userdata('store_language'),

                "store_id" => $this->session->userdata('store_id'),
                "store_name" => $this->session->userdata('store_name'),
                "land_id" => $this->session->userdata('land_id'),
                "land_name" => $this->session->userdata('land_name'),

                // "coupon_code"    => $this->session->userdata('coupon_code'),
                // "discount_amount"  => $this->session->userdata('discount_amount'),
                "total" => 19.00,
                "paid" => "isPending"
            );

            //Check if the Cart is empty!
            $coupon_code =  substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10); //categori ile eşleştir
            $total = 0;

            $this->Model_order->add($form_data2);


            $form_data_item2 = array(
                "item_product_id" => 171,
                "item_uniqid" => mt_rand(1200, 999999999),
                "item_name" => "Mit zwei Augen 20x30 Poster",
                "item_price" => 19.00,
                "item_qty" => 1,
                "item_eye_qty" => 1,
                "item_image" => "https://irispicture.com/public/uploads/product_photos/banner/product_banner_170_gtzt.jpg?v=1623325193",
                "item_currency_icon" => "€",
                "item_currency_code" => "EUR",
                "item_lang_code" => "de",
                "item_subtotal" => 19.00,
                "order_number" => $order_number_token,
                "security_number" => $security_number_token
            );

            $total += 19.00;
            $this->Model_order->add_order_item($form_data_item2);
        }

        exit( "100 order added hass been succesfully" );
        // redirect(base_url('shop/seed_order/payment'));
    }

    public function payment()
    {
        //Check if the Cart is empty!
        $coupon_code =  substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10); //categori ile eşleştir
        $total = 0;
        for ($i = 0; $i < 100; $i++) {
            $form_data_item = array(
                "item_product_id" => 170,
                "item_uniqid" => mt_rand(1200, 999999999),
                "item_name" => "Mit einem Auge 20x30 Poster",
                "item_price" => 0.01,
                "item_qty" => 1,
                "item_eye_qty" => 1,
                "item_image" => "https://irispicture.com/public/uploads/product_photos/banner/product_banner_170_gtzt.jpg?v=1623325193",
                "item_currency_icon" => "€",
                "item_currency_code" => "EUR",
                "item_lang_code" => "de",
                "item_subtotal" => 0.01,
                "order_number" => $this->session->userdata('order_number_token'),
                "security_number" => $this->session->userdata('security_number_token')
            );

            $total += 0.01;
            $this->Model_order->add_order_item($form_data_item);
        }

        for ($i = 0; $i < 100; $i++) {
            $form_data_item = array(
                "item_product_id" => 171,
                "item_uniqid" => mt_rand(1200, 999999999),
                "item_name" => "Mit zwei Augen 20x30 Poster",
                "item_price" => 19.00,
                "item_qty" => 1,
                "item_eye_qty" => 1,
                "item_image" => "https://irispicture.com/public/uploads/product_photos/banner/product_banner_170_gtzt.jpg?v=1623325193",
                "item_currency_icon" => "€",
                "item_currency_code" => "EUR",
                "item_lang_code" => "de",
                "item_subtotal" => 19.00,
                "order_number" => $this->session->userdata('order_number_token'),
                "security_number" => $this->session->userdata('security_number_token')
            );

            $total += 19.00;
            $this->Model_order->add_order_item($form_data_item);
        }

        if ($this->session->userdata["payment_form"]['payment_method'] === "creditCard") {

            $session_form_data = $this->session->userdata('payment_form');
            $session_form_data['total'] = $total;
            $session_form_data['paid'] = "isPaid";
            $this->Model_order->add($session_form_data);

            echo $this->success_view(); //html şablonu hazir olunca aç

            $this->shop_email->send_email(
                $this->session->userdata['payment_form']['store_lang_code'],
                "mollie",
                $this->session->userdata['payment_form']['billing_email'],
                $this->session->userdata['payment_form']['order_number']
            );

            //Destroy all session
            $this->session->unset_userdata('order_number_token');
            $this->session->unset_userdata('keep_input_value');
            $this->session->unset_userdata('payment_form');

            //Destroy Cart Session
            $this->cart->destroy();
        }
    }

    public function success()
    {
        $success = '';
        $error = '';
        $paid = '';

        $payment = $this->mollie->payments->get($this->session->userdata('payment_id'));

        $session_form_data = $this->session->userdata('payment_form');

        if ($payment->status === "paid" || $payment->isPaid()) {

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
            return $this->shop_email->send_email(
                $this->session->userdata['payment_form']['store_lang_code'],
                "MollieError",
                $this->session->userdata['payment_form']['billing_email'],
                $this->session->userdata['payment_form']['order_number']
            );
            redirect(base_url('shop'));
        }
        //        print_r($session_form_data);
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
