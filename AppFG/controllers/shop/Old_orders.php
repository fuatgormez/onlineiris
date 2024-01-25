<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Old_orders extends CI_Controller
{
    public $mollie;

    function __construct()
    {
        parent::__construct();
        $this->load->model('Model_common');
        $this->load->model('Model_service');
        $this->load->model('shop/Model_order');
        $this->load->model('api/Model_coupon');
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

        //When the order is isPaid, end the session! Don't forget!
        $order_number_token = rand(100, 1000) . time();
        $security_number_token = rand(100, 1000) . time();
        $this->session->set_userdata('order_number_token', $order_number_token);
        $this->session->set_userdata('security_number_token', $security_number_token);

        $data['methods'] = $this->mollie->methods->allActive();

        $this->load->view('layout/' . $data['setting']['layout'] . '/view_header', $data);
        $this->load->view('layout/' . $data['setting']['layout'] . '/shop/view_old_orders', $data);
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
                                "item_product_id" => $item['id'],
                                "item_uniqid" => $item_uniqid,
                                "item_name" => $item['name'],
                                "item_price" => $item['price']
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

                        "payment_method" => 'creditCard',
                        "order_type" => $this->input->post('order_type'),
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

                        "client_ip_address" => $_SERVER['REMOTE_ADDR'],
                        "client_user_agent" => $_SERVER['HTTP_USER_AGENT'],

                        // "store_id" => $this->session->userdata('store_id'),
                        // "store_name" => $this->session->userdata('store_name'),
                        // "land_id" => $this->session->userdata('land_id'),
                        // "land_name" => $this->session->userdata('land_name'),

                        "coupon_code"    => $this->session->userdata('coupon_code'),
                        "discount_amount"  => $this->session->userdata('coupon') ? $this->session->userdata('coupon') : $this->session->userdata('discount_amount'),
                        // "discount_amount"  => $this->session->userdata('discount_amount'),
                        "shipping_total" => $this->session->userdata('shipping_total'),
                        // "total" => $this->cart->total() - $this->session->userdata('discount_amount'),
                        // "total" => $this->session->userdata('discount_amount') > 0 ? number_format($total - $this->session->userdata('discount_amount'),2) : $total,
                        "total" => $total,
                        "total_update" => $total_update,
                        "transaction_id" => ''
                    );

                    $this->session->set_userdata('payment_form_items_for_mollie', $form_data_item_for_mollie);
                    $this->session->set_userdata('payment_form_items', $form_data_item);
                    $this->session->set_userdata('payment_form', $form_data);

                    redirect(base_url('shop/old_orders/payment'));
                } else {
                    redirect(base_url('shop/old_orders'));
                }
            } else {
                $this->session->set_flashdata('error', $error);
                redirect(base_url('shop/old_orders'));
            }
        }
    }

    public function payment()
    {
        //Check if the Cart is empty!
        if (!empty($this->cart->contents())) {


            if ($this->session->userdata["payment_form"]['payment_method'] === "creditCard") {

                $session_form_data = $this->session->userdata('payment_form');
                $session_form_data_item = $this->session->userdata('payment_form_items');

                
                // $session_form_data['payment_method'] = $this->session->userdata('payment_method');
                $session_form_data['total'] = ($session_form_data['total'] - $session_form_data['discount_amount']) + $this->session->userdata('shipping_total');
                $session_form_data['paid'] = "isPaid";


                $this->Model_order->add($session_form_data);
                
                foreach ($session_form_data_item as $item) {
                    if(!$this->Model_order->check_order_item_with_uniqid($item['item_uniqid']))
                    {
                        $this->Model_order->add_order_item($item);
                    }
                }

                if ($this->session->userdata('coupon')) {
                    $this->Model_coupon->update_current_limit($this->session->userdata('coupon_code'));
                }

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
                $this->session->unset_userdata('payment_method');
                $this->session->unset_userdata('payment_form');
                $this->session->unset_userdata('payment_form_items');
                $this->session->unset_userdata('coupon');
                $this->session->unset_userdata('discount_amount');

                //Destroy Cart Session
                $this->cart->destroy();
            }
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
}
