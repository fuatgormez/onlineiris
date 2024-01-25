<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Mollie extends CI_Controller
{
    public $mollie;

    function __construct()
    {
        parent::__construct();
        $this->load->model('Model_common');
        $this->load->model('shop/Model_order');

        $this->load->library('shop_email');

        try {
            $this->mollie = new \Mollie\Api\MollieApiClient();
            $select_mollie_key =  $this->Model_common->all_setting_shop();

            //codeguru & engin & ipekfor test buying access
            if(in_array($this->session->userdata('id'), [1])){
                $this->mollie->setApiKey($select_mollie_key["mollie_test_key"]);
            } else {
                if ($select_mollie_key["mollie_current_key"] === "test") {
                    $this->mollie->setApiKey($select_mollie_key["mollie_test_key"]);
                } else {
                    $this->mollie->setApiKey($select_mollie_key["mollie_live_key"]);
                }
            }
        } catch (Exception $e) {
            exit( 'While processing this page a system error occurred. Our developers were notified.' );
        }
    }
    
    public function index()
    {
        redirect(base_url('mobile'));
    }

    public function payment_url($order_number)
    {
        $this->insert_order_data();

        $setting = $this->Model_common->all_setting_shop();
        $get_order = $this->Model_order->get_order($order_number);

        if(!$get_order)
            redirect(base_url('mobile/shop'));

        $get_order_item = $this->Model_order->get_order_item($order_number);

        $payment = $this->mollie->payments->create([
            'amount' => [
                'currency' => 'EUR',
                'value' => number_format($get_order['total'] + $this->session->userdata('shipping_total') , 2)
            ],
            'method' => $this->session->userdata('payment_method'),
            'description' => $setting['mollie_description'],
            'cancelUrl' => base_url('mobile/checkout/payment-method'),
            'redirectUrl' => base_url('mobile/mollie/success/'.$order_number),
            "metadata" => [
                "check_order_response" => $order_number
            ],
        ]);
        $this->Model_order->update_order($order_number, array('transaction_id' => $payment->id));
        header("Location: " . $payment->getCheckoutUrl(), true, 303);
    }

    public function webhook()
    {
        $this->Model_order->mollie_webhook(array('data' => json_encode($this->input->post())));
    }

    public function qrcode()
    {
        $data['setting'] = $this->Model_common->all_setting();
        $data['qrcode'] = $this->qrcode_generate(base_url('mobile/mollie/payment-url/'.$this->session->userdata('order_number_token')));

        $this->load->view('layout/mobile/view_header', $data);
        $this->load->view('layout/mobile/view_mollie_qrcode', $data);
        $this->load->view('layout/mobile/view_footer', $data);
    }

    public function qrcode_generate($url)
    {
        return 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl='.$url.'&choe=UTF-8';
    }

    public function success($order_number)
    {
        $data['setting'] = $this->Model_common->all_setting();
        $data['get_order'] = $this->Model_order->get_order($order_number);

        $data['order_status'] = false;

        if(!$data['get_order'])
            redirect(base_url('mobile/shop'));

        $payment = $this->mollie->payments->get($data['get_order']['transaction_id']);

        if ($payment->isPaid() && ! $payment->hasRefunds() && ! $payment->hasChargebacks()) { 
            $data['message'] = 'The order was created successfully!';
            $data['order_status'] = true;

            if($data['get_order']['receive']  < 1){
                $this->shop_email->send_email(
                    $data['get_order']['billing_email'],
                    $data['get_order']['order_number'],
                    $data['get_order']['store_lang_code'],
                    "mollie"
                );
            }

            $update_order = array('paid' => 'paid' ,'receive' => 1);
            $this->Model_order->update_order($order_number, $update_order);

            $this->unset_only();
        } else {
            $data['message'] = 'The order was not created! Please try again...';
        }

        $this->load->view('layout/mobile/view_header', $data);
        $this->load->view('layout/mobile/view_payment_success', $data);
        $this->load->view('layout/mobile/view_footer', $data);
    }

    public function insert_order_data()
    {
        if($this->session->userdata('payment_form')){

            $session_form_data = $this->session->userdata('payment_form');
            // $session_form_data_item = $this->session->userdata('payment_form_items');
            // $session_form_data['payment_method'] = $this->session->userdata('payment_method');

            if(!$this->Model_order->get_order($this->session->userdata('payment_form')['order_number'])){
                $this->Model_order->add($session_form_data);
                // foreach ($session_form_data_item as $item) {
                //     if (!$this->Model_order->check_order_item_with_uniqid($item['item_uniqid'])) {
                //         $this->Model_order->add_order_item($item);
                //     }
                // }
            }
        }
    }

    public function check_order($order_number)
    {
        exit(json_encode(array('res' => $this->Model_common->get_order($order_number) )));
        //return json_encode(array('order' => $this->Model_order->get_order($order_number) ));
    }

    public function unset_only()
    {
        foreach ($this->session->all_userdata() as $key => $value) {
            if (!in_array($key, ['id','username','password','photo','role','status','land_id','land_name','lang_code','currency_code','currency_icon'])) {
                $this->session->unset_userdata($key);
            }
        }
    }

    public function check_payment($payment_id)
    {
        try {
            $payment = $this->mollie->payments->get($payment_id);

            if ($payment->isPaid() && ! $payment->hasRefunds() && ! $payment->hasChargebacks()) {
                exit(json_encode(array('status' => 'paid')));
            } else {
                exit(json_encode(array('status' => 'isOpen')));
            }
        } catch (\Mollie\Api\Exceptions\ApiException $e) {
            echo "API call failed: " . htmlspecialchars($e->getMessage());
        }
    }
}
