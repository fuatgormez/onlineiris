<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Checkout extends CI_Controller
{
    public $mollie;
    public $mollieDescription;

    public $userId;
    public $secret;
    public $apiClient;

    function __construct()
    {
        parent::__construct();
        $this->load->model('Model_common');
        $this->load->model('shop/Model_order');

        $this->load->library('cart');
        $this->load->library('shop_email');

        // exit($sms_code);
        try {
            $this->mollie = new \Mollie\Api\MollieApiClient();
            $selectMollieKey =  $this->Model_common->all_setting_shop();
            $this->mollieDescription = $selectMollieKey['mollie_description'];

            if(in_array($this->session->userdata('id'), [1])){
                $this->mollie->setApiKey($selectMollieKey["mollie_test_key"]);
            } else {
                if ($selectMollieKey["mollie_current_key"] === "test") {
                    $this->mollie->setApiKey($selectMollieKey["mollie_test_key"]);
                } else {
                    $this->mollie->setApiKey($selectMollieKey["mollie_live_key"]);
                }
            }
        } catch (Exception $e) {
            exit( 'While processing this page a system error occurred. Our developers were notified.' );
        }
    }

    public function index()
    {
        if($this->session->userdata('order_number_token'))
        {
            $this->order_item_save();

            redirect(base_url('mobile/checkout/form/' . $this->session->userdata('order_number_token') ));
            // $this->qrcode($this->session->userdata('order_number_token'));
        } else {
            redirect(base_url('mobile/home'));
        }
    }

    public function form($order_number)
    {
        $data['setting'] = $this->Model_common->all_setting();
        $data['store'] = $this->Model_common->get_all_store();
        $data['order'] = json_decode($this->Model_common->get_ci_sessions($order_number)['data']);

        $this->load->view('layout/mobile/view_header', $data);
        $this->load->view('layout/mobile/view_checkout_form', $data);
        $this->load->view('layout/mobile/view_footer', $data);
    }

    public function form_save()
    {
        $error = '';
        $success = '';
        $message = '';

        if ($this->input->post()) {
            $valid = 1;

            $store = $this->Model_common->store_check($this->input->post('billingStoreId'));

            if($store){
                $valid = 1;
            } else {
                $valid = 0;
                $message = 'store not found!';
            }

            if ($valid == 1) {
                if (!empty($this->input->post('order_number'))) {

                    $get_ci_session = $this->Model_common->get_ci_sessions($this->input->post('order_number'));
                    // echo json_decode($get_ci_session['data'])->order_total;
                    
                    $this->form_validation->set_rules('billingFirstName', 'First Name', 'trim|required');
                    $this->form_validation->set_rules('billingLastName', 'Last Name', 'trim|required');
                    $this->form_validation->set_rules('billingEmail', 'Email', 'trim|valid_email|required');
                    $this->form_validation->set_rules('billingPhone', 'Phone', 'trim|required');
                    $this->form_validation->set_rules('billingStreet', 'Street', 'trim|required');
                    $this->form_validation->set_rules('billingPostCode', 'Post Code', 'trim|required');
                    $this->form_validation->set_rules('billingCity', 'City', 'trim|required');
                    // $this->form_validation->set_rules('billingCountry', 'Country', 'trim|required');
                    // $this->form_validation->set_rules('payment_method', 'Payment Method', 'trim|required');
        
                    if ($this->form_validation->run() == FALSE) {
                        $valid = 0;
                        // $error .= validation_errors();
                    }
        
                    $form_data = array(
                        "billing_firstname" => $this->input->post('billingFirstName'),
                        "billing_lastname" => $this->input->post('billingLastName'),
                        "billing_email" => $this->input->post('billingEmail'),
                        "billing_phone" => $this->input->post('billingPhone'),
                        "billing_street" => $this->input->post('billingStreet'),
                        "billing_street_no" => $this->input->post('billingStreetNo'),
                        "billing_postcode" => $this->input->post('billingPostCode'),
                        "billing_city" => $this->input->post('billingCity'),
                        // "billing_country" => $this->input->post('billingCountry'),
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
        
                        // "payment_method" => $this->input->post('payment_method'),//only mollie methods
                        "order_type" => "web",
                        "order_number" => $this->input->post('order_number'),
                        "security_number" => $this->input->post('security_number'),
                        // "tracking_number" => $number = rand(100, 100000) . time(),
        
                        "store_currency_code" => $store['currency_code'],
                        "store_currency_icon" => $store['currency_icon'],
                        "store_lang_code" => $store['lang_code'],
        
                        "store_id" => $store['id'],
                        "store_name" => $store['store_name'],
                        "land_id" => $store['land_id'],
                        "land_name" => $store['land_name'],
        
                        "client_ip_address" => $_SERVER['REMOTE_ADDR'],
                        "client_user_agent" => $_SERVER['HTTP_USER_AGENT'],
        
                        // "coupon_code"    => $this->session->userdata('coupon_code'),
                        // "discount_amount"  => $this->session->userdata('coupon') ? $this->session->userdata('coupon') : $this->session->userdata('discount_amount'),
                        // "discount_amount"  => $this->session->userdata('discount_amount'),
                        "shipping_total" => $this->session->userdata('shipping_total'),
                        "total" => json_decode($get_ci_session['data'])->order_total,
                        "total_update" => 0.00,
                        "paid" => 'isOpen',
                        "transaction_id" => ''
                    );
        
                    $this->session->set_userdata('payment_form', $form_data);
                }

                redirect(base_url('mobile/checkout/payment-method/'.$this->input->post('order_number')));
            } else {
                $this->session->set_flashdata('error', $error);
                redirect(base_url('mobile/checkout/form/'.$this->input->post('order_number')));
            }
        } else {
            redirect(base_url('mobile/checkout/data'));
        }
    }

    public function payment_method($order_number)
    {
        $data['setting'] = $this->Model_common->all_setting();
        $data['methods'] = $this->mollie->methods->allActive();
        $data['order'] = json_decode($this->Model_common->get_ci_sessions($order_number)['data']);

        $this->load->view('layout/mobile/view_header', $data);
        $this->load->view('layout/mobile/view_checkout_payment_method', $data);
        $this->load->view('layout/mobile/view_footer', $data);
    }

    public function payment()
    {
        //Check if the Cart is empty!
        if (!empty($this->input->post('order_number'))) {
            $this->session->set_userdata('payment_method', $this->input->post('payment_method'));
            redirect(base_url('mobile/mollie/payment-url/'.$this->input->post('order_number')));
        } else {
            redirect(base_url('mobile/shop'));
        }
    }

    public function unset_only()
    {
        $user_data = $this->session->all_userdata();
    
        foreach ($user_data as $key => $value) {
            if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
                $this->session->unset_userdata($key);
            }
        }
    }

    public function order_customer_save()
    {
        if (!empty($this->input->post('order_number'))) {

            $store = $this->Model_common->store_check($this->input->post('billingStoreId'));

            if(!$store)
                exit('store not found');

            
            $get_ci_session = $this->Model_common->get_ci_sessions($this->input->post('order_number'));
            // echo json_decode($get_ci_session['data'])->order_total;
            
            $this->form_validation->set_rules('billingFirstName', 'First Name', 'trim|required');
            $this->form_validation->set_rules('billingLastName', 'Last Name', 'trim|required');
            $this->form_validation->set_rules('billingEmail', 'Email', 'trim|valid_email|required');
            $this->form_validation->set_rules('billingPhone', 'Phone', 'trim|required');
            $this->form_validation->set_rules('billingStreet', 'Street', 'trim|required');
            $this->form_validation->set_rules('billingPostCode', 'Post Code', 'trim|required');
            $this->form_validation->set_rules('billingCity', 'City', 'trim|required');
            // $this->form_validation->set_rules('billingCountry', 'Country', 'trim|required');
            // $this->form_validation->set_rules('payment_method', 'Payment Method', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $valid = 0;
                // $error .= validation_errors();
            }

            $form_data = array(
                "billing_firstname" => $this->input->post('billingFirstName'),
                "billing_lastname" => $this->input->post('billingLastName'),
                "billing_email" => $this->input->post('billingEmail'),
                "billing_phone" => $this->input->post('billingPhone'),
                "billing_street" => $this->input->post('billingStreet'),
                "billing_street_no" => $this->input->post('billingStreetNo'),
                "billing_postcode" => $this->input->post('billingPostCode'),
                "billing_city" => $this->input->post('billingCity'),
                // "billing_country" => $this->input->post('billingCountry'),
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

                // "payment_method" => $this->input->post('payment_method'),//only mollie methods
                "order_type" => "web",
                "order_number" => $this->input->post('order_number'),
                "security_number" => $this->input->post('security_number'),
                // "tracking_number" => $number = rand(100, 100000) . time(),

                "store_currency_code" => $store['currency_code'],
                "store_currency_icon" => $store['currency_icon'],
                "store_lang_code" => $store['lang_code'],

                "store_id" => $this->session->userdata('store')['id'],
                "store_name" => $this->session->userdata('store')['store_name'],
                "land_id" => $this->session->userdata('store')['land_id'],
                "land_name" => $this->session->userdata('store')['land_name'],

                "client_ip_address" => $_SERVER['REMOTE_ADDR'],
                "client_user_agent" => $_SERVER['HTTP_USER_AGENT'],

                // "coupon_code"    => $this->session->userdata('coupon_code'),
                // "discount_amount"  => $this->session->userdata('coupon') ? $this->session->userdata('coupon') : $this->session->userdata('discount_amount'),
                // "discount_amount"  => $this->session->userdata('discount_amount'),
                // "shipping_total" => $this->session->userdata('shipping_total'),
                "total" => json_decode($get_ci_session['data'])->order_total,
                "total_update" => 0.00,
                "paid" => 'isOpen',
                "transaction_id" => ''
            );

            $this->session->set_userdata('payment_form', $form_data);
            return $valid = 1;
        }
    }

    public function order_customer_update($order_number)
    {
        $valid = 1;
        try {
            if ($order_number) {
                $this->form_validation->set_rules('billingFirstName', 'First Name', 'trim|required');
                $this->form_validation->set_rules('billingLastName', 'Last Name', 'trim|required');
                $this->form_validation->set_rules('billingEmail', 'Email', 'trim|valid_email|required');
                $this->form_validation->set_rules('billingPhone', 'Phone', 'trim|required');
                $this->form_validation->set_rules('billingStreet', 'Street', 'trim|required');
                $this->form_validation->set_rules('billingPostCode', 'Post Code', 'trim|required');
                $this->form_validation->set_rules('billingCity', 'City', 'trim|required');
                // $this->form_validation->set_rules('billingCountry', 'Country', 'trim|required');
                // $this->form_validation->set_rules('payment_method', 'Payment Method', 'trim|required');
    
                if ($this->form_validation->run() == FALSE) {
                    $valid = 0;
                    // $error .= validation_errors();
                }
    
                $form_data = array(
                    "billing_firstname" => $this->input->post('billingFirstName'),
                    "billing_lastname" => $this->input->post('billingLastName'),
                    "billing_email" => $this->input->post('billingEmail'),
                    "billing_phone" => $this->input->post('billingPhone'),
                    "billing_street" => $this->input->post('billingStreet'),
                    "billing_street_no" => $this->input->post('billingStreetNo'),
                    "billing_postcode" => $this->input->post('billingPostCode'),
                    "billing_city" => $this->input->post('billingCity'),
                    // "billing_country" => $this->input->post('billingCountry'),
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
                    "shipping_comment" => $this->input->post('shippingComment')
                );
    
                return $this->Model_order->update_order($order_number, $form_data);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function order_item_save()
    {
        $valid = 1;
        $form_data_item = [];
        if (!empty($this->cart->contents())) {
            foreach ($this->cart->contents() as $item) {
                $form_data_item = array(
                    "item_product_id" => $item['id'],
                    "item_uniqid" => $item['rowid'],//$item_uniqid,
                    "item_name" => $item['name'],
                    "item_price" => $item['price'],
                    "item_qty" =>  $item['qty'],
                    // "item_eye_qty" => $item['eye_qty'],
                    "item_image" => $item['image'],
                    // "item_type" => $item['product_type'],
                    "item_currency_icon" => $this->session->userdata('store')['currency_icon'],
                    "item_currency_code" => $this->session->userdata('store')['currency_code'],
                    "item_lang_code" => $this->session->userdata('store')['lang_code'],
                    "item_subtotal" => $item['price'] * $item['qty'],
                    "order_number" => $this->session->userdata('order_number_token'),
                    "security_number" => $this->session->userdata('security_number_token')
                );
                if (!$this->Model_order->check_order_item_with_id_order_number($item['id'], $this->session->userdata('order_number_token'))) {
                    $this->Model_order->add_order_item($form_data_item);
                }
            }

            $ci_sessions = json_encode (array(
                'order_number'      => $this->session->userdata('order_number_token'),
                'security_number'   => $this->session->userdata('security_number_token'),
                'order_total'       => number_format($this->cart->total(), 2),
                'store_id'          => $this->session->userdata('store')['id']
            ));
            $this->Model_common->insert_ci_sessions(
                array(
                    'id' => $this->session->userdata('order_number_token'),
                    'data' => $ci_sessions
                )
            );
            $this->session->set_userdata('payment_form_items', $form_data_item);
            $valid = 0;
        }
        return $valid;
    }

    public function mobile_form($store_id)
    {
        $store = $this->Model_common->store_check($store_id);
		$this->session->set_userdata('store', $store);
    }

    public function qrcode($order_number)
    {
        $data['setting'] = $this->Model_common->all_setting();
        $data['order_number'] = $order_number;

        if($this->Model_order->isPaid_order($order_number))
            redirect(base_url('mobile/home/1/2'));

        $data['QRcode'] = $this->qrcode_generate(base_url('mobile/checkout/form/'.$order_number));
        $data['link'] = base_url('mobile/checkout/form/'.$order_number);

        $this->load->view('layout/mobile/view_header', $data);
        $this->load->view('layout/mobile/view_mollie_qrcode', $data);
        $this->load->view('layout/mobile/view_footer', $data);
    }

    public function qrcode_generate($url)
    {
        return 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl='.$url.'&choe=UTF-8';
    }
}
