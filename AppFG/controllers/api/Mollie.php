<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mollie extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Model_common');
        $this->load->model('shop/Model_order');
		
        $this->load->library('shop_email');
        
		try {
            $this->mollie = new \Mollie\Api\MollieApiClient();
            $select_mollie_key =  $this->Model_common->all_setting_shop();

            if ($select_mollie_key["mollie_current_key"] === "test") {
                $this->mollie->setApiKey($select_mollie_key["mollie_test_key"]);
            } else {
                $this->mollie->setApiKey($select_mollie_key["mollie_live_key"]);
            }
        } catch (Exception $e) {
            exit( 'While processing this page a system error occurred. Our developers were notified.' );
        }
	}

	public function index()
	{
		exit('access denied');
	}

    public function check_order($order_number)
    {
       return $this->Model_order->get_order($order_number) ? 1 : 0;
    }    

    public function mollie_check()
    {
        // $payment = $this->mollie->payments->get($payment_id);
        foreach($this->mollie->payments->page() as $order)
        {
            $this->mollie_create_re_order($order->id);
        }
    }

    public function mollie_create_re_order($payment_id)
    {
        // ini_set('display_errors', 1);
        // ini_set('display_startup_errors', 1);
        // error_reporting(E_ALL);

        $payment = $this->mollie->payments->get($payment_id);
        if($payment){

            if($payment->status === 'paid' && !empty($payment->metadata->store_name) && !empty($payment->metadata->items)){

                $store_search = $this->Model_common->store_search_single($payment->metadata->store_name);

                $total = 0;
                $form_data_item = [];
                // $order_number_token = rand(100, 1000) . time();
                $security_number_token = rand(100, 1000) . time();

                $meta_items = (array) json_encode($payment->metadata->items,true);

                $this->load->model('shop/Model_shopping_cart');

                foreach ($meta_items as $items) {
                    foreach ((array)json_decode($items,true) as $item) {
                        
                        $product_check = $this->Model_shopping_cart->product_check($item['item_product_id'],$store_search['lang_code']);

                        // print_r($product_check);exit;
                        $form_data_item[] = array(
                            "item_product_id" => $item['item_product_id'],
                            "item_uniqid" => $item['item_uniqid'],
                            "item_name" => $product_check['product_name'],
                            "item_price" => $product_check['product_price'],
                            "item_qty" => 1,
                            "item_eye_qty" => $product_check['eye_quantity'],
                            "item_image" => $product_check['thumbnail_photo'],
                            "item_type" => $product_check['product_type'],
                            "item_currency_icon" => $store_search['currency_icon'],
                            "item_currency_code" => $store_search['currency_code'],
                            "item_lang_code" => $store_search['lang_code'],
                            "item_subtotal" => $product_check['product_price'], //$item['subtotal'],
                            "order_number" => $payment->metadata->check_order_response,
                            "security_number" => $security_number_token
                        );
                            $total += $product_check['product_price']; //fiyati degismis olabilir o yuzden odendigi zamandaki fiyatini aliyoruz;
                    }
                }


                $form_data = array(
                    "billing_firstname" => $payment->metadata->billing_firstname,
                    "billing_lastname" => $payment->metadata->billing_lastname,
                    "billing_email" => $payment->metadata->billing_email,
                    "billing_phone" => $payment->metadata->billing_phone,
                    "billing_street" => $payment->metadata->billing_street,
                    "billing_street_no" => '',
                    "billing_postcode" => $payment->metadata->billing_postcode,
                    "billing_city" => $payment->metadata->billing_city,
                    "billing_country" => '',

                    "payment_method" => $payment->method,
                    "order_type" => "web",
                    "order_number" => $payment->metadata->check_order_response,
                    "security_number" => $security_number_token,

                    "store_currency_code" => $store_search['currency_code'],
                    "store_currency_icon" => $store_search['currency_icon'],
                    "store_lang_code" => $store_search['lang_code'],

                    "store_id" => $store_search['id'],
                    "store_name" => $store_search['store_name'],
                    "land_id" => $store_search['land_id'],
                    "land_name" => $store_search['land_name'],

                    "total" => $total,
                    "paid" => 'isPaid',
                    "transaction_id" => $payment_id
                );


                if($this->check_order($payment->metadata->check_order_response) == 0){
                    $this->Model_order->add($form_data);

                    $this->shop_email->send_email(
                        $store_search['lang_code'],
                        "mollie",
                        $payment->metadata->billing_email,
                        $payment->metadata->check_order_response
                    );

                }
                foreach ($form_data_item as $item) {
                    if (!$this->Model_order->check_order_item_with_uniqid($item['item_uniqid'])) {
                        $this->Model_order->add_order_item($item);
                    }
                }
            }
        } else {
            echo 'kayit bulunamadi';
        }
    }

    public function mollie_webhook()
    {
        return $this->mollie_create_re_order($_POST["id"]);
    }
}
