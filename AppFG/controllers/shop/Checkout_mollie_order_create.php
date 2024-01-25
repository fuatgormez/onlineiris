<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Checkout_mollie_order_create extends CI_Controller
{
    public $mollie;

    //only for www.irispicture.ch (postfinance) 
    public $spaceId;
    public $userId;
    public $secret;
    public $apiClient;

    function __construct()
    {
        parent::__construct();
        $this->load->model('Model_common');
        $this->load->model('Model_service');
        $this->load->model('shop/Model_order');
        $this->load->model('api/Model_coupon');
        //$this->load->model('shop/Model_shopping_cart');

        $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url()) : $this->session->userdata('store_language');
        $this->lang->load('file', $this->session->userdata('site_language') ?? $this->session->userdata('store_language'));

        $this->load->library('cart');
        $this->load->library('shop_email');
        $this->load->library('facebook_pixel');

        if($this->uri->segment(3) !== 'mollie_create_re_order' && $this->uri->segment(3) !== 'mollie_check' && $this->uri->segment(3) !== 'mollie_webhook'){
            if (empty($this->cart->contents())) {
                redirect(base_url('shop'));
                return;
            }
        }

        // $timeout = 20; // or 30, whatever you need
        // $guzzleClient = new Client([
        //     \GuzzleHttp\RequestOptions::VERIFY => \Composer\CaBundle\CaBundle::getBundledCaBundlePath(),
        //     \GuzzleHttp\RequestOptions::TIMEOUT => $timeout,
        // ]);

        //A technical error has occurred.

        try {
            $this->mollie = new \Mollie\Api\MollieApiClient();
            $select_mollie_key =  $this->Model_common->all_setting_shop();

            if ($select_mollie_key["mollie_current_key"] === "test") {
                $this->mollie->setApiKey($select_mollie_key["mollie_test_key"]);
            } else {
                $this->mollie->setApiKey($select_mollie_key["mollie_live_key"]);
            }

            if (base_url() === "https://irispicture.ch/") {
                //only for www.irispicture.ch (postfinance)
                $this->spaceId = 18373;
                $this->userId = 43756;
                $this->secret = 'vU3cr7wSlPVO+uRlg1t0C9cXHSsNsiaEun5i8WY7wtk=';
                $this->apiClient = new \PostFinanceCheckout\Sdk\ApiClient($this->userId, $this->secret);
            }
        } catch (Exception $e) {
            exit( 'While processing this page a system error occurred. Our developers were notified.' );
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

        $data['billingFirstName'] = $data['billingLastName'] = $data['billingStreet'] = $data['billingStreetNo'] = $data['billingPostCode'] = $data['billingCity'] = $data['billingEmail'] = $data['billingPhone'] = '';

        if ($this->session->userdata('order_number')) {
            $data['order'] = $this->Model_order->check_order($this->session->userdata('order_number'));

            if ($data['order']->billing_firstname)
                $data['billingFirstName'] = $data['order']->billing_firstname;
            if ($data['order']->billing_lastname)
                $data['billingLastName'] = $data['order']->billing_lastname;
            if ($data['order']->billing_street)
                $data['billingStreet'] = $data['order']->billing_street;
            if ($data['order']->billing_street_no)
                $data['billingStreetNo'] = $data['order']->billing_street_no;
            if ($data['order']->billing_postcode)
                $data['billingPostCode'] = $data['order']->billing_postcode;
            if ($data['order']->billing_city)
                $data['billingCity'] = $data['order']->billing_city;
            if ($data['order']->billing_email)
                $data['billingEmail'] = $data['order']->billing_email;
            if ($data['order']->billing_phone)
                $data['billingPhone'] = $data['order']->billing_phone;
        } else {
            //When the order is isPaid, end the session! Don't forget!
            // $order_number_token = 1891636912485;
            $order_number_token = rand(100, 1000) . time();
            $security_number_token = rand(100, 1000) . time();
            $this->session->set_userdata('order_number_token', $order_number_token);
            $this->session->set_userdata('security_number_token', $security_number_token);
        }

        if (!empty($this->session->userdata['keep_input_value']['billingFirstName']))
            $data['billingFirstName'] = $this->session->userdata['keep_input_value']['billingFirstName'];

        if (!empty($this->session->userdata['keep_input_value']['billingLastName']))
            $data['billingLastName'] = $this->session->userdata['keep_input_value']['billingLastName'];

        if (!empty($this->session->userdata['keep_input_value']['billingStreet']))
            $data['billingStreet'] = $this->session->userdata['keep_input_value']['billingStreet'];

        if (!empty($this->session->userdata['keep_input_value']['billingStreetNo']))
            $data['billingStreetNo'] = $this->session->userdata['keep_input_value']['billingStreetNo'];

        if (!empty($this->session->userdata['keep_input_value']['billingPostCode']))
            $data['billingPostCode'] = $this->session->userdata['keep_input_value']['billingPostCode'];

        if (!empty($this->session->userdata['keep_input_value']['billingCity']))
            $data['billingCity'] = $this->session->userdata['keep_input_value']['billingCity'];

        if (!empty($this->session->userdata['keep_input_value']['billingEmail']))
            $data['billingEmail'] = $this->session->userdata['keep_input_value']['billingEmail'];

        if (!empty($this->session->userdata['keep_input_value']['billingPhone']))
            $data['billingPhone'] = $this->session->userdata['keep_input_value']['billingPhone'];

            // $this->facebook_pixel->PageView(
            //     $this->Model_common->all_setting()['facebook_access_token'],
            //     $this->Model_common->all_setting()['facebook_init']
            // );

        // print_r($data['order']);exit;
        $data['methods'] = $this->mollie->methods->allActive();

        $this->load->view('layout/' . $data['setting']['layout'] . '/view_header', $data);
        $this->load->view('layout/' . $data['setting']['layout'] . '/shop/view_checkout_data', $data);
        $this->load->view('layout/' . $data['setting']['layout'] . '/view_footer', $data);
    }

    public function add()
    {
        $error = '';
        $success = '';
        // print_r($this->cart->contents());exit;

        if ($this->input->post()) {
            $valid = 1;

            $store_check = $this->Model_common->store_check($this->input->post('billingStoreId'));

            if($store_check){

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
                
            } else {
                $valid = 0;
            }


            if ($valid == 1) {

                if (!empty($this->cart->contents())) {

                    $total = 0;
                    $total_update = 0;
                    $form_data_item = [];
                    $form_data_item_for_mollie = [];
                    if ($this->session->userdata('order_number')) {
                        $get_order = $this->Model_order->get_order($this->session->userdata('order_number'));
                        // eger musteri upgrade yapiyorsa eski urunler odenmemisse totaldan dusuyoruz ki toplamlar tutsun musterinin ne odeyecegi karismasin aksi halde upgrade yapilan ilk urunde toplama dahil oluyor
                        $total = $get_order['total'];
                    }

                    foreach ($this->cart->contents() as $item) {
                        for ($i = 0; $i < $item['qty']; $i++) {
                            $item_uniqid = mt_rand(1200, 999999999);
                            // $form_data_item[$i] = array(
                            $form_data_item[] = array(
                                "item_product_id" => $item['id'],
                                "item_uniqid" => $item_uniqid,
                                "item_name" => $item['name'],
                                "item_price" => $item['price'],
                                // "item_qty" => $item['qty'],
                                "item_qty" => 1, //$item['qty'],
                                "item_eye_qty" => $item['eye_qty'],
                                "item_image" => $item['image'],
                                "item_type" => $item['product_type'],
                                "item_currency_icon" => $item['currency_icon'],
                                "item_currency_code" => $item['currency_code'],
                                "item_lang_code" => $item['lang_code'],
                                "item_subtotal" => $item['price'], //$item['subtotal'],
                                "order_number" => $this->session->userdata('order_number') ? $this->session->userdata('order_number') : $this->session->userdata('order_number_token'),
                                "security_number" => $this->session->userdata('order_number') ? $get_order['security_number'] : $this->session->userdata('security_number_token')
                            );
                            
                            $form_data_item_for_mollie[] = array(
                                // "item_product_id" => $item['id'],
                                // "item_uniqid" => $item_uniqid,
                                // "item_name" => $item['name'],
                                // "item_price" => $item['price']
                                
                                "sku" => (string)$item_uniqid,
                                // "sku" => strval($item_uniqid),
                                // "sku" => "deneme",
                                "name" => $item['name'],
                                "quantity" => 1,
                                "vatRate" => "19.00",
                                "unitPrice" => [
                                    "currency" => "EUR",
                                    "value" => number_format($item['price'],2),
                                ],
                                "totalAmount" => [
                                    "currency" => "EUR",
                                    "value" => number_format($item['price'],2),
                                ],
                                "vatAmount" => [
                                    "currency" => "EUR",
                                    "value" => number_format($item['price'] - ($item['price'] / 1.19),2),
                                ],
                            );

                            //bu kisim sadece update icin kullaniliyor
                            if ($this->session->userdata('order_number')) {
                                $form_data_item[] += [
                                    "item_id_old" => $item['item_id_old'],
                                    "is_updated" => $item['metadata']['is_updated']
                                ];
                            }

                            //bu kisim sadece update icin kullaniliyor
                            if ($this->session->userdata('order_number')) {
                                $check_order_item = $this->Model_order->check_order_item_single($this->session->userdata('order_number'), $item['item_id_old']);
                                if ($check_order_item && $get_order['paid'] === 'isPaid') {
                                    $total_update += $item['price'] - $check_order_item['item_price'];
                                } else {
                                    $total_update += $item['price'];
                                    $total -= $check_order_item['item_price'];
                                }
                            } else {
                                $total += $item['price']; //$item['subtotal'];
                            }
                        }
                    }

                    // exit($this->session->userdata('discount_amount'));
                    // exit($total);

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
                        "order_type" => $this->session->userdata('order_number') ? "upgrade" : "web",
                        "order_number" => $this->session->userdata('order_number') ? $this->session->userdata('order_number') : $this->session->userdata('order_number_token'),
                        "security_number" => $this->session->userdata('security_number_token'),
                        // "tracking_number" => $number = rand(100, 100000) . time(),

                        "store_currency_code" => $this->session->userdata('currency_code'),
                        "store_currency_icon" => $this->session->userdata('currency_icon'),
                        "store_lang_code" => $this->session->userdata('store_language'),

                        "store_id" => $store_check['id'],
                        "store_name" => $store_check['store_name'],
                        "land_id" => $store_check['land_id'],
                        "land_name" => $store_check['land_name'],

                        // "store_id" => $this->session->userdata('store_id'),
                        // "store_name" => $this->session->userdata('store_name'),
                        // "land_id" => $this->session->userdata('land_id'),
                        // "land_name" => $this->session->userdata('land_name'),

                        "coupon_code"    => $this->session->userdata('coupon_code'),
                        "discount_amount"  => $this->session->userdata('coupon') ? $this->session->userdata('coupon') : $this->session->userdata('discount_amount'),
                        // "discount_amount"  => $this->session->userdata('discount_amount'),
                        "shipping_total" => $this->session->userdata('shipping_total'),
                        // "total" => $this->cart->total() - $this->session->userdata('discount_amount'),
                        "total" => $total, //- $this->session->userdata('discount_amount'),
                        "total_update" => $total_update,
                        "paid" => 'isOpen',
                        "transaction_id" => ''
                    );

                    $this->session->set_userdata('payment_form_items_for_mollie', $form_data_item_for_mollie);
                    $this->session->set_userdata('payment_form_items', $form_data_item);
                    $this->session->set_userdata('payment_form', $form_data);

                    redirect(base_url('shop/checkout/payment'));
                } else {
                    redirect(base_url('shop'));
                }
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

    public function payment_sent()
    {

        $error = '';
        $success = '';

        $valid = 1;

        if (empty($this->session->userdata('payment_form')['billing_firstname'])) {
            $valid = 0;
            $this->set_flashdata_redirect("The First Name field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['billing_lastname'])) {
            $valid = 0;
            $this->set_flashdata_redirect("The Last Name field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['billing_email'])) {
            $valid = 0;
            $this->set_flashdata_redirect("The Email field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['billing_phone'])) {
            $valid = 0;
            $this->set_flashdata_redirect("The Phone field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['billing_street'])) {
            $valid = 0;
            $this->set_flashdata_redirect("The Street field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['billing_postcode'])) {
            $valid = 0;
            $this->set_flashdata_redirect("The Postcode field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['billing_city'])) {
            $valid = 0;
            $this->set_flashdata_redirect("The City field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['billing_country'])) {
            $valid = 0;
            $this->set_flashdata_redirect("The Country field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['land_id'])) {
            $valid = 0;
            $this->set_flashdata_redirect("The land id field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['land_name'])) {
            $valid = 0;
            $this->set_flashdata_redirect("The Land name field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['store_id'])) {
            $valid = 0;
            $this->set_flashdata_redirect("The Store id field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['store_name'])) {
            $valid = 0;
            $this->set_flashdata_redirect("The Store name field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['store_lang_code'])) {
            $valid = 0;
            $this->set_flashdata_redirect("The Store lang code field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['store_currency_icon'])) {
            $valid = 0;
            $this->set_flashdata_redirect("The Store currency icon field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['store_currency_code'])) {
            $valid = 0;
            $this->set_flashdata_redirect("The Store currency code field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['order_type'])) {
            $valid = 0;
            $this->set_flashdata_redirect("The Order type field is required.", "shop");
        } elseif (empty($this->session->userdata('payment_form')['order_number'])) {
            $valid = 0;
            $this->set_flashdata_redirect("The Order number field is required.", "shop");
        } else {
            $valid = 1;
        }

        // print_r($this->cart->contents());exit;

        if ($valid == 1) {

            //Check if the Cart is empty!
            if (!empty($this->cart->contents())) {
                // $coupon_code =  substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10); //categori ile eşleştir
                // $uniq_id = rand(100, 1000);
                // $uniq_id = mt_rand(1200,999999999);

                // print_r($this->session->userdata('payment_form_items'));exit;

                if ($this->session->userdata('payment_method') === "bankTransfer") {
                    
                    //facebook satis sonrasi pixel kodu eklenecek bu kisma
                    //tobiasin kendi pixeli var
                    if (base_url() === "https://www.youririsfoto.be1/" || base_url() === "https://www.youririsfoto.nl1/") {
                        $this->facebook_pixel->Purchase(
                            $this->session->userdata('payment_form')['total'],
                            $this->Model_common->all_setting()['facebook_access_token'],
                            $this->Model_common->all_setting()['facebook_init'],
                            $this->session->userdata('payment_form')
                        );
                    }

                    $session_form_data = $this->session->userdata('payment_form');
                    $session_form_data_item = $this->session->userdata('payment_form_items');
                    $session_form_data['payment_method'] = $this->session->userdata('payment_method');
                    $session_form_data['total'] = ($session_form_data['total'] - $this->session->userdata('discount_amount')) + $this->session->userdata('shipping_total');
                    $session_form_data['paid'] = "isPending";

                    if ($this->session->userdata('order_number')) {
                        // $this->update_order($this->session->userdata('order_number'), $session_form_data);
                        $this->update_order($session_form_data, 'bankTransfer', 'isPending');
                        $this->update_order_item($session_form_data_item);
                    } else {
                        $this->insert_order_data();
                    }                    

                    echo $this->success_view(); //html şablonu hazir olunca aç

                    //deploy ederken active hale getirmeyi unutma!!!
                    $this->shop_email->send_email(
                        $this->session->userdata['payment_form']['store_lang_code'],
                        "bankTransfer",
                        $this->session->userdata['payment_form']['billing_email'],
                        $this->session->userdata['payment_form']['order_number']
                    );

                    //Destroy all session
                    $this->session->unset_userdata('order_number');
                    $this->session->unset_userdata('order_number_token');
                    $this->session->unset_userdata('keep_input_value');
                    $this->session->unset_userdata('payment_form');
                    $this->session->unset_userdata('coupon');
                    $this->session->unset_userdata('coupon_code');
                    $this->session->unset_userdata('discount_type');
                    $this->session->unset_userdata('discount_amount');
                    $this->session->unset_userdata('shipping_total');
                    $this->session->unset_userdata('percent');

                    //Destroy Cart Session
                    $this->cart->destroy();
                } else {

                    $total = number_format(($this->cart->total() - ($this->session->userdata('coupon') ? $this->session->userdata('coupon') : $this->session->userdata('discount_amount'))) + $this->session->userdata('shipping_total'), 2);
                    
                    if(base_url() === 'https://irispicture.ch/' || base_url() === 'https://www.fuatgormez.tech/irispicture/iptal'){
                        return $this->payment_postfinance($total);
                    }

                    // print "<pre>";
                    // print_r($this->session->userdata('payment_form_items_for_mollie'));
                    // // print_r($this->session->userdata('payment_form_items'));
                    // print "</pre>";
                    // exit();

                    $payment = $this->mollie->orders->create([
                    // $payment = $this->mollie->payments->create([
                        'amount' => [
                            'currency' => $this->session->userdata('currency_code'),
                            'value' => $total,
                            // "value" => "1027.99",
                            // 'value' => number_format(($this->cart->total() - $this->session->userdata('discount_amount')) + $this->session->userdata('shipping_total'), 2)
                        ],
                        'method' => $this->session->userdata('payment_method'),
                        // 'description' => $this->session->userdata('order_number') ? "IRISPICTURE UPGRADE" : "IRISPICTURE",
                        'redirectUrl' => base_url('shop/checkout/payment_check_mollie'),
                        // 'webhookUrl' => base_url('shop/checkout/mollie_webhook'),
                        // 'webhookUrl' => base_url('shop/mollie/webhook'),
                        "metadata" => [
                            "land_id" => $this->session->userdata['payment_form']['land_id'],
                            "land_name" => $this->session->userdata['payment_form']['land_name'],
                            "store_id" => $this->session->userdata['payment_form']['store_id'],
                            "store_name" => $this->session->userdata['payment_form']['store_name'],
                            
                            "check_order_response" => $this->session->userdata['payment_form']['order_number'], //$check_order_response,
                            // "items" => $this->session->userdata['payment_form_items_for_mollie']
                        ], //musteri bilgilerini extra olarak metadata nin icine ekle payment te kontrol edilecek data ayri mi geliyor diye bak!!!
                        "orderNumber" => strval($this->session->userdata['payment_form']['order_number']),
                        "locale" => "de_DE",//bunu degistir ve kontrol et
                        // "locale" => $this->session->userdata['payment_form']['store_lang_code'],//"en_US",//bunu degistir ve kontrol et
                        "billingAddress" => [
                            "streetAndNumber" => $this->session->userdata['payment_form']['billing_street'].' '.$this->session->userdata['payment_form']['billing_street_no'],
                            "postalCode" => $this->session->userdata['payment_form']['billing_postcode'],
                            "city" => $this->session->userdata['payment_form']['billing_city'],
                            "country" => $this->session->userdata['payment_form']['store_lang_code'],
                            "givenName" => $this->session->userdata['payment_form']['billing_firstname'],
                            "familyName" => $this->session->userdata['payment_form']['billing_lastname'],
                            "email" => $this->session->userdata['payment_form']['billing_email'],
                            "phone" => $this->session->userdata['payment_form']['billing_phone']
                        ],
                        "shippingAddress" => [
                            "streetAndNumber" => $this->session->userdata['payment_form']['shipping_street'] ?: $this->session->userdata['payment_form']['billing_street'] .' '.$this->session->userdata['payment_form']['shipping_street_no'] ?: $this->session->userdata['payment_form']['billing_street_no'],
                            "postalCode" => $this->session->userdata['payment_form']['shipping_postcode'] ?: $this->session->userdata['payment_form']['billing_postcode'],
                            "city" => $this->session->userdata['payment_form']['shipping_city'] ?: $this->session->userdata['payment_form']['billing_city'],
                            "country" => $this->session->userdata['payment_form']['store_lang_code'] ?: $this->session->userdata['payment_form']['store_lang_code'],
                            "givenName" => $this->session->userdata['payment_form']['shipping_firstname'] ?: $this->session->userdata['payment_form']['billing_firstname'],
                            "familyName" => $this->session->userdata['payment_form']['shipping_lastname'] ?: $this->session->userdata['payment_form']['billing_lastname'],
                            "email" => $this->session->userdata['payment_form']['shipping_email'] ?: $this->session->userdata['payment_form']['billing_email'],
                            "phone" => $this->session->userdata['payment_form']['shipping_phone'] ?: $this->session->userdata['payment_form']['billing_phone']
                        ],
                        "lines" => $this->session->userdata['payment_form_items_for_mollie'],
                    ]);

                    print('<pre>');
                    print_r($payment);
                    print('</pre>');

                    exit;

                    $this->session->set_userdata('payment_id', $payment->id);
                    $this->session->set_userdata('check_order_response', $this->session->userdata['payment_form']['order_number']); //$check_order_response);

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

    public function update_order($update_order_data, $payment_method_update, $paid_update)
    {

        // print_r($update_order_data);exit; 
        // $update_order_data = json_decode(file_get_contents('php://input'), true);

        $error = '';
        $success = '';

        $valid = 1; //d251b311d066ceaa79ebe7cc6fb86dd6fe71eb48 //bilmiyorum

        if ($valid == 1) {

            $check_order = $this->Model_order->check_order($update_order_data['order_number']);
            // print_r($check_order);exit;

            $data = array(
                'billing_city'    => $update_order_data['billing_city'],
                'billing_comment'    => $update_order_data['billing_comment'],
                'billing_country'    => $update_order_data['billing_country'],
                'billing_email'    => $update_order_data['billing_email'],
                'billing_firstname'    => $update_order_data['billing_firstname'],
                'billing_lastname'    => $update_order_data['billing_lastname'],
                'billing_phone'    => $update_order_data['billing_phone'],
                'billing_postcode'    => $update_order_data['billing_postcode'],
                'billing_street'    => $update_order_data['billing_street'],
                'billing_street_no'    => $update_order_data['billing_street_no'],

                'shipping_city'    => $update_order_data['shipping_city'],
                'shipping_comment'    => $update_order_data['shipping_comment'],
                'shipping_country'    => $update_order_data['shipping_country'],
                'shipping_email'    => $update_order_data['shipping_email'],
                'shipping_firstname'    => $update_order_data['shipping_firstname'],
                'shipping_lastname'    => $update_order_data['shipping_lastname'],
                'shipping_phone'    => $update_order_data['shipping_phone'],
                'shipping_postcode'    => $update_order_data['shipping_postcode'],
                'shipping_street'    => $update_order_data['shipping_street'],
                'shipping_street_no'    => $update_order_data['shipping_street_no'],

                // 'coupon_code'    => $update_orde_data['coupon_code'],
                'discount_amount'    => $check_order->discount_amount + $this->session->userdata('discount_amount'), //bu urunun eski urunlerin fiyatlarini new total dan dusur
                'total'    => $update_order_data['total'],
                // 'total_update'    => $update_order_data['total_update'] //bunu hesapla sonra dinamik olacak
                'total_update'    => $check_order->total_update + $update_order_data['total_update'],
                // 'total_update'    => $update_order_data['total_update'];
                // 'status' => 'Passive'
                'payment_method_update' => $payment_method_update,
                'paid_update' => $paid_update,
            );

            $this->Model_order->update_order($update_order_data['order_number'], $data);
        }
    }

    public function update_order_item($get_update_item, $with_name_price = 0)
    {
        // $get_update_item = json_decode(file_get_contents('php://input'), true);
        // $form_data_update_item = array(); 

        $status = true;
        $message = 'ok';

        if ($with_name_price < 0) {
            $with_name_price = 0;
        }

        $item_update_total = $with_name_price;

        foreach ($get_update_item as $items) {

            $this->Model_order->update_order_item_delete($items['item_uniqid']); ///kiosk ta ileri geri yapican post ediliyor o yüzden datalari siliyouz duplicated olmasin diye
            $this->Model_order->check_update_order_item_reset($items['item_product_id'], $items['item_uniqid'], $items['order_number'], $data = array('item_update_total' => 0.00));

            $form_data_update_item = array(
                "item_id" => $items['item_product_id'],
                "item_uniqid" => $items['item_uniqid'],
                "item_id_old" => $items['item_id_old'],
                "item_name" => $items['item_name'],
                "item_price" => $items['item_price'],
                "item_qty" => $items['item_qty'],
                "item_eye_qty" => $items['item_eye_qty'],
                "item_image" => $items['item_image'],
                "item_currency_icon" => $items['item_currency_icon'],
                "item_currency_code" => $items['item_currency_code'],
                "item_lang_code" => $items['item_lang_code'],
                "item_subtotal" => $items['item_price'], //$items['item_price'] * $items['item_qty'],
                "is_updated" => $items['is_updated'],
                // "is_paid" => $items['is_paid'],
                // "comment" => $items['comment'],
                // "email" => $items['email'],
                "order_number" => $items['order_number'],
                "security_number" => $items['security_number']
            );

            $item_update_total += $items['item_price'];

            if ($items['is_updated'] === "update" || $items['is_updated'] === "extra") {

                $tot_item = $this->Model_order->check_order_item($items['order_number']);
                if ($tot_item > 0) {

                    $tot_update_item = $this->Model_order->check_update_order_item_updated($items['item_product_id'], $items['item_id_old'], $items['item_price'], $items['order_number']);
                    if (!$tot_update_item) {

                        $this->Model_order->update_order_item_updated($form_data_update_item);
                        $status =  true;
                        $message = "success: Product has been updated";
                    } else {
                        $status =  false;
                        $message = "warning: Product has already been updated";
                    }
                    
                } else {
                    //no product
                    $status =  false;
                    $message = "error: Product not found";
                }
            }

            $item_update_total_data = array(
                "item_update_total" => $item_update_total
            );

            if ($this->Model_order->update_order_item_update($items['item_uniqid'], $item_update_total_data)) {
                $status =  true;
                $message = "ok";
            }

            // $new_total = $items['item_subtotal'];
            $order_data = array(
                "with_name_price" => $with_name_price
            );
            if ($this->Model_order->update_order($items['order_number'], $order_data)) {
                $status =  true;
                $message = "ok";
            }
        }
    }

    public function success()
    {
        $success = '';
        $error = '';

        //ilerde payment status le hata sayfalari hazirla cancelled olan siparislerde de success görüntüleniyor
        // $payment = $this->mollie->payments->get($this->session->userdata('payment_id'));

        // echo $this->session->userdata('entityId');exit;
        
        if($this->session->userdata('payment_form')){
        
            if ($this->session->userdata('coupon')) {
                $this->Model_coupon->update_current_limit($this->session->userdata('coupon_code'));
            }

            $success = $this->lang->line('payment_success_message_alert');
            $this->session->set_flashdata('success', $success);

            echo $this->success_view();

            //Destroy all session
            $this->session->unset_userdata('order_number');
            $this->session->unset_userdata('order_number_token');
            $this->session->unset_userdata('keep_input_value');
            $this->session->unset_userdata('payment_form');
            $this->session->unset_userdata('coupon');
            $this->session->unset_userdata('coupon_code');
            $this->session->unset_userdata('discount_type');
            $this->session->unset_userdata('discount_amount');
            $this->session->unset_userdata('shipping_total');
            $this->session->unset_userdata('percent');
            $this->session->unset_userdata('payment_id');
            $this->session->unset_userdata('entityId');

            //Destroy Cart Session
            $this->cart->destroy();
        } else {
            redirect(base_url('shop'));
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

    public function set_flashdata_redirect($error, $url)
    {
        $this->session->set_flashdata('error', $error);
        redirect(base_url($url));
    }

    public function payment_check_mollie()
    {
        $success = '';
        $error = '';

        // echo 'initial tr id: '.$this->session->userdata('payment_id');

        $this->mollie_order_check($this->session->userdata('payment_id'));
        exit;
        
        $payment = $this->mollie->payments->get($this->session->userdata('payment_id'));

        print_r($payment);exit;

        $session_form_data = $this->session->userdata('payment_form');
        $session_form_data_item = $this->session->userdata('payment_form_items');
        $session_form_data['payment_method'] = $this->session->userdata('payment_method');

        // print_r($session_form_data_item);exit;

        //mollie check  payment_sent te olusturulan gecici kod u mollie gonderip gelen response metadata da kontrol ediyoruz      
        if ($payment->metadata->check_order_response !== $this->session->userdata('check_order_response')) {
            $this->shop_email->single_email(
                $session_form_data['store_lang_code'],
                "MollieError",
                $session_form_data['billing_email'],
                $session_form_data['order_number']
            );
            redirect(base_url('shop/checkout/overview'));
        }

        // if ($payment->status === "paid" || $payment->isPaid()) {
        if ($payment->status === "paid" || $payment->isPaid()) {

            $this->insert_order_data();

            $order_data = array(
                'paid' => 'isPaid'
            );
            $update_order = $this->Model_order->update_order($payment->metadata->check_order_response, $order_data);

            $this->shop_email->send_email(
                $this->session->userdata['payment_form']['store_lang_code'],
                "mollie",
                $this->session->userdata['payment_form']['billing_email'],
                $this->session->userdata['payment_form']['order_number']
            );
            
            //mollie webhook iptal edildi sonra bak
            redirect(base_url('shop/checkout/success'));
            
        } else {
            // $this->insert_order_data();
            // $this->shop_email->single_email(
            //     $session_form_data['store_lang_code'],
            //     "MollieError",
            //     $session_form_data['billing_email'],
            //     $session_form_data['order_number']
            // );
            // redirect(base_url('shop/checkout/overview'));
        }

        //mollie bazen datayi gonderemiyor yukardaki islemi tekrar check ediyoruz eger sisteme order dusmemisse yeniden ekliyoruz mollie den alinan datalarla
        $this->mollie_create_re_order($this->session->userdata('payment_id'));
        
    }
    
    public function payment_check_postfinance()
    {

        $payment = $this->apiClient->getTransactionCompletionService()->completeOnline($this->spaceId, $this->session->userdata('entityId'));

        $session_form_data = $this->session->userdata('payment_form');
        $session_form_data_item = $this->session->userdata('payment_form_items');
        $session_form_data['payment_method'] = $this->session->userdata('payment_method');

         
        if ($payment['state'] === 'SUCCESSFUL') {

            $this->insert_order_data();

            $order_data = array(
                'paid' => 'isPaid'
            );
            $update_order = $this->Model_order->update_order($session_form_data['order_number'], $order_data);

            $this->shop_email->send_email(
                $this->session->userdata['payment_form']['store_lang_code'],
                "mollie",
                $this->session->userdata['payment_form']['billing_email'],
                $this->session->userdata['payment_form']['order_number']
            );

            redirect(base_url('shop/checkout/success'));
        }elseif ($payment['state'] === 'PENDING' || $payment['state'] === 'AUTHORIZED' || $payment['state'] === 'FULFILL' || $payment['state'] === 'CONFIRMED' || $payment['state'] === 'COMPLETED') {

            $this->insert_order_data();

            $order_data = array(
                'paid' => 'isOpen'
            );
            $update_order = $this->Model_order->update_order($session_form_data['order_number'], $order_data);
    
            redirect(base_url('shop/checkout/success'));    
        } else {
            $this->shop_email->single_email(
                $session_form_data['store_lang_code'],
                "MollieError",
                $session_form_data['billing_email'],
                $session_form_data['order_number']
            );
            redirect(base_url('shop/checkout/overview'));
        }
    }

    function payment_postfinance($total )
    {
        // Setup API client
        $client = new \PostFinanceCheckout\Sdk\ApiClient($this->userId, $this->secret);

        // Create transaction
        $lineItem = new \PostFinanceCheckout\Sdk\Model\LineItemCreate();
        
        $lineItem->setName('IRISPICTURE');
        $lineItem->setUniqueId(time());
        $lineItem->setSku('irispicture');
        $lineItem->setQuantity(1);
        $lineItem->setAmountIncludingTax($total);
        $lineItem->setType(\PostFinanceCheckout\Sdk\Model\LineItemType::PRODUCT);

        $transactionPayload = new \PostFinanceCheckout\Sdk\Model\TransactionCreate();
        $transactionPayload->setCurrency('CHF');
        $transactionPayload->setLineItems(array($lineItem));
        $transactionPayload->setAutoConfirmationEnabled(true);

        $transactionPayload->setFailedUrl(base_url('shop/postfinance/fail'));
        $transactionPayload->setSuccessUrl(base_url('shop/checkout/payment_check_postfinance'));

        $transaction = $client->getTransactionService()->create($this->spaceId, $transactionPayload);

        // Create Payment Page URL:
        $redirectionUrl = $client->getTransactionPaymentPageService()->paymentPageUrl($this->spaceId, $transaction->getId());

        $this->session->set_userdata('entityId', $transaction->getId());
        header('Location: ' . $redirectionUrl);

    }

    public function insert_order_data()
    {
        if($this->session->userdata('payment_form')){
        
            $session_form_data = $this->session->userdata('payment_form');
            $session_form_data_item = $this->session->userdata('payment_form_items');
            $session_form_data['payment_method'] = $this->session->userdata('payment_method');
            $session_form_data['transaction_id'] = $this->session->userdata('payment_id');
            // $session_form_data['paid'] = "isPending";
    
                if($this->check_order($session_form_data['order_number']) == 0){
                    $this->Model_order->add($session_form_data);
                }
                foreach ($session_form_data_item as $item) {
                    if (!$this->Model_order->check_order_item_with_uniqid($item['item_uniqid'])) {
                        $this->Model_order->add_order_item($item);
                    }
                }
    
                if ($this->session->userdata('coupon')) {
                    $this->Model_coupon->update_current_limit($this->session->userdata('coupon_code'));
                }
        }
    }

    public function check_order($order_number)
    {
       return $this->Model_order->get_order($order_number) ? 1 : 0;
    }    

    public function mollie_check()
    {
        // $this->mollie->payments->page()
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
    
    public function mollie_order_check($order_id)
    {
        $order = $this->mollie->orders->get($order_id);
        print_r($order);
    }
}
