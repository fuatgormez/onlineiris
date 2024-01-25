<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Checkout_kiosk extends CI_Controller
{
    protected $mollie;
    protected $token = "e58753aaf7a14d7c22017e6e198beb1034759bea";

    function __construct()
    {
        parent::__construct();

        $this->load->library('logger/logger');

        $this->load->model('Model_common');
        $this->load->model('Model_service');
        $this->load->model('shop/Model_coupon');
        $this->load->model('shop/Model_order');
        $this->load->model('shop/Model_order_kiosk');
        //        $this->load->model('shop/Model_shopping_cart');

        $this->load->library('shop_email');

        $this->lang->load('file', $this->session->userdata('store_language') ?? 'de');

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

        $data['setting'] = $this->Model_common->all_setting();
        $data['page_home'] = $this->Model_common->all_page_home();
        $data['social'] = $this->Model_common->all_social();
        $data['services'] = $this->Model_service->all_service();

        $data['description'] = 'Shopping Cart';

        $data['stores'] = $this->Model_common->get_all_store();
        $data['store_langs'] = $this->Model_common->get_all_store_lang();


        $data['theme'] = $data['setting']['layout'];


        //When the order is isPaid, end the session! Don't forget!
        // $order_number_token = rand(100, 1000) . time();
        // $this->session->set_userdata('order_number_token', $order_number_token);


        $this->load->view('layout/' . $data['setting']['layout'] . '/view_header', $data);
        $this->load->view('layout/' . $data['setting']['layout'] . '/shop/view_checkout', $data);
        $this->load->view('layout/' . $data['setting']['layout'] . '/view_footer', $data);
    }

    public function add()
    {

        try {

            $get_kiosk_data = json_decode(file_get_contents('php://input'), true);

            $error = '';
            $success = '';

            $get_store = $this->Model_order_kiosk->get_store($get_kiosk_data['store_id']);

            // print_r($get_store);
            // exit;

            $order_number = rand(100, 100000) . time();
            $security_number = rand(100, 100000) . time();

            $form_data = array(
                "billing_firstname" => $get_kiosk_data['billing_firstname'],
                "billing_lastname" => $get_kiosk_data['billing_lastname'],
                "billing_email" => $get_kiosk_data['billing_email'],
                "billing_phone" => $get_kiosk_data['billing_phone'],
                "billing_street" => $get_kiosk_data['billing_street'],
                "billing_street_no" => $get_kiosk_data['billing_street_no'],
                "billing_postcode" => $get_kiosk_data['billing_postcode'],
                "billing_city" => $get_kiosk_data['billing_city'],
                "billing_country" => $get_kiosk_data['billing_country'],
                "billing_comment" => $get_kiosk_data['billing_comment'],

                // "shipping_firstname" => $get_kiosk_data['shippingFirstName'],
                // "shipping_lastname" => $get_kiosk_data['shippingLastName'],
                // "shipping_email" => $get_kiosk_data['shippingEmail'],
                // "shipping_phone" => $get_kiosk_data['shippingPhone'],
                // "shipping_street" => $get_kiosk_data['shippingStreet'],
                // "shipping_street_no" => $get_kiosk_data['shippingStreetNo'],
                // "shipping_postcode" => $get_kiosk_data['shippingPostCode'],
                // "shipping_city" => $get_kiosk_data['shippingCity'],
                // "shipping_country" => $get_kiosk_data['shippingCountry'],
                // "shipping_comment" => $get_kiosk_data['shippingComment'],

                // "shipping_firstname" => $this->input->post('shippingFirstName'),
                // "shipping_lastname" => $this->input->post('shippingLastName'),
                // "shipping_email" => $this->input->post('shippingEmail'),
                // "shipping_phone" => $this->input->post('shippingPhone'),
                // "shipping_street" => $this->input->post('shippingStreet'),
                // "shipping_street_no" => $this->input->post('shippingStreetNo'),
                // "shipping_postcode" => $this->input->post('shippingPostCode'),
                // "shipping_city" => $this->input->post('shippingCity'),
                // "shipping_country" => $this->input->post('shippingCountry'),
                // "shipping_comment" => $this->input->post('shippingComment'),

                // "payment_method" => $this->input->post('payment_method'), //gegen_vorkasse  // bu kisim dinamik olacak
                //"payment_method" => "kreditcard", //gegen_vorkasse  // bu kisim dinamik olacak
                "order_type" => "kiosk",
                "order_number" => $order_number,
                "security_number" => $security_number,

                "store_currency_code" => $get_store['currency_code'],
                "store_currency_icon" => $get_store['currency_icon'],
                "store_lang_code" => $get_store['lang_code'],
                "store_id" => $get_kiosk_data['store_id'],
                "store_name" => $get_store['store_name'],
                "land_name" => $get_store['land_name'],
                "land_id" => $get_store['land_id'],
                "kiosk_device_id" => $get_kiosk_data['kiosk_device_id'],

                'coupon_code'    => $get_kiosk_data['coupon_code'],
                'discount_amount'    => $get_kiosk_data['discount_amount'],
                "total" => $get_kiosk_data['total'],
                "paid" => "isOpen"
            );

            $insert_order = $this->Model_order_kiosk->add_order($form_data);

            // $form_data_item = [];

            foreach ($get_kiosk_data['OrderItems'] as $items) {
                for ($i = 0; $i < $items['item_qty']; $i++) {
                    // $form_data_item[] = array(
                    $form_data_item = array(
                        "item_name" => $items['item_name'],
                        "item_product_id" => $items['item_product_id'],
                        "item_uniqid" => mt_rand(1200, 999999999),
                        "item_price" => $items['item_price'],
                        "item_qty" => 1, //$items['item_qty'],
                        "item_eye_qty" => $items['item_eye_qty'],
                        "item_image" => $items['item_image'],
                        "item_currency_icon" => $items['item_currency_icon'],
                        "item_currency_code" => $items['item_currency_code'],
                        "item_lang_code" => $items['item_lang_code'],
                        "item_subtotal" => $items['item_subtotal'],
                        "order_number" => $order_number,
                        "security_number" => $security_number
                    );
                    $this->Model_order_kiosk->add_order_item($form_data_item);
                }
            }


            if ($insert_order > 0) {
                $this->logger->user('kiosk')->type('Shop Kiosk:' . $get_kiosk_data['kiosk_device_id'])->id(1)->token(sha1(mt_rand()))->comment('New order added -> ' . $order_number)->log();
                $response_data = array('order_number' => $order_number, 'security_number' => $security_number);
                exit(json_encode(array('status' => true, 'message' => 'success', 'data' => $response_data)));
            } else {
                $this->logger->user('kiosk')->type('Shop Kiosk:' . $get_kiosk_data['kiosk_device_id'])->id(1)->token(sha1(mt_rand()))->comment('New order could not added -> ' . $order_number)->log();
                exit(json_encode(array('status' => false, 'message' => 'error', 'data' => '')));
            }
        } catch (Exception $e) {
            exit(json_encode(array('status' => false, 'message' => 'error', 'data' => '')));
        }
    }

    public function update_order()
    {
        try {
            $update_order_data = json_decode(file_get_contents('php://input'), true);

            $error = '';
            $success = '';

            $valid = 1; //d251b311d066ceaa79ebe7cc6fb86dd6fe71eb48 //bilmiyorum

            if ($valid == 1) {

                $check_order_kiosk = $this->Model_order_kiosk->check_order($update_order_data['order_number']);

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
                    'discount_amount'    => $update_order_data['discount'],
                    'total_update'    => $check_order_kiosk['total_update'] ? $update_order_data['total_update'] + $check_order_kiosk['total_update'] : $update_order_data['total_update']
                    // 'total_update'    => $update_order_data['total_update'];
                    // 'status' => 'Passive'
                );

                $result = $this->Model_order_kiosk->update_order($update_order_data['order_number'], $data);

                if ($result == 1) {
                    exit(json_encode(array("status" => true, "message" => "success", "data" => "ok")));
                } else {
                    exit(json_encode(array("status" => false, "message" => "error", "data" => "no")));
                }
            }
        } catch (Exception $e) {
            exit(json_encode(array('status' => false, 'message' => 'error', 'data' => 'no')));
        }
    }

    public function update_order_item($order_number, $security_number = 0, $item_id_old, $item_uniqid, $with_name_price = 0)
    {
        try {
            $get_update_item = json_decode(file_get_contents('php://input'), true);

            // $form_data_update_item = array();        

            $status = true;
            $message = 'ok';

            if ($with_name_price < 0) {
                $with_name_price = 0;
            }

            $this->Model_order_kiosk->update_order_item_delete($item_uniqid); ///kiosk ta ileri geri yapican post ediliyor o yüzden datalari siliyouz duplicated olmasin diye
            $this->Model_order_kiosk->check_update_order_item_reset($item_id_old, $item_uniqid, $order_number, $data = array('item_update_total' => 0.00));

            $item_update_total = $with_name_price;

            foreach ($get_update_item as $items) {

                $form_data_update_item = array(
                    "item_id" => $items['item_id'],
                    "item_uniqid" => $item_uniqid, //$items['item_uniqid'],
                    "item_id_old" => $items['item_product_id'],
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
                    "order_number" => $order_number,
                    "security_number" => $security_number
                );

                $item_update_total += $items['item_price'];

                if ($items['is_updated'] === "update" || $items['is_updated'] === "extra") {

                    $tot_item = $this->Model_order_kiosk->check_order_item($order_number);
                    if ($tot_item > 0) {

                        $tot_update_item = $this->Model_order_kiosk->check_update_order_item_updated($items['item_id'], $items['item_product_id'], $items['item_price'], $order_number);
                        if (!$tot_update_item) {

                            $this->Model_order_kiosk->update_order_item_updated($form_data_update_item);
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
            }

            $item_update_total_data = array(
                "item_update_total" => $item_update_total
            );

            if ($this->Model_order_kiosk->update_order_item_update($item_uniqid, $item_update_total_data)) {
                $status =  true;
                $message = "ok";
            }

            // $new_total = $items['item_subtotal'];
            $order_data = array(
                "with_name_price" => $with_name_price
            );
            if ($this->Model_order_kiosk->update_order($order_number, $order_data)) {
                $status =  true;
                $message = "ok";
            }


            $this->logger->user('kiosk')->type('Shop Kiosk Update Item')->id(1)->token(sha1(mt_rand()))->comment('Order items has been updated -> ' . $order_number)->log();

            exit(json_encode(array('status' => $status, 'message' => $message, 'data' => $order_number)));
        } catch (Exception $e) {
            exit(json_encode(array('status' => false, 'message' => 'error', 'data' => '')));
        }
    }

    public function update_order_item_image()
    {
        try {
            $error = "";
            // token ekle
            // coklu siparislerde daha once cekilen resim secildiyse resmi tekrar yukleme 0=yukle 1=yukleme
            if ($_POST['item_id_duplicated'] == 0) {

                if (isset($_FILES['photo']["name"]) && isset($_FILES['photo']["tmp_name"])) {

                    $valid = 1;

                    $path = $_FILES['photo']['name'];
                    $path_tmp = $_FILES['photo']['tmp_name'];

                    if ($path != '') {
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $file_name = basename($path, '.' . $ext);
                        $ext_check = $this->Model_common->extension_check_photo($ext);
                        if ($ext_check == FALSE) {
                            $valid = 0;
                            $error .= 'You must have to upload cr2,jpg, jpeg, gif or png file for featured photo<br>';
                        }
                    } else {
                        $valid = 0;
                        $error .= 'You must have to select a photo for featured photo<br>';
                    }

                    if ($valid == 1) {
                        // $ai_id = rand(1000, 10000) . time();

                        $ai_id = rand(1000, 10000);

                        $path = $_POST['image']; // gönderilen resim rename ediliyor (IPTAL SERKAN YAPIYOR)

                        $check_order_kiosk = $this->Model_order_kiosk->check_order($_POST['order_number']);
                        $folder_date = date("d-m-Y", strtotime($check_order_kiosk['date_purchased']));

                        $current_folder = "public/uploads/shop/order_kiosk_upload/" . str_replace(' ', '', trim(strtolower($_POST['land_name']))) . "/" . str_replace(' ', '', trim(strtolower($_POST['store_name']))) . "/" . $folder_date . "/" . intval($_POST['order_number']) . "/";

                        if (!file_exists($current_folder)) {
                            mkdir($current_folder, 0755, true);
                        }

                        if (move_uploaded_file($path_tmp, $current_folder . $path)) {
                            $form_data = array(
                                'order_number' => intval($_POST['order_number']),
                                'item_id' => intval($_POST['item_id']),
                                'item_uniqid' => intval($_POST['item_uniqid']),
                                'item_id_extra' => intval($_POST['item_id_extra']),
                                'item_id_duplicated' => 0,
                                'with_name' => $_POST['with_name'],
                                'with_name_price' => $_POST['with_name_price'],
                                'image' => $path,
                                'image_owner' => $_POST['image_owner'],
                                'is_extra' => $_POST['is_extra'],
                                'is_selected' => $_POST['is_selected'],
                                'is_completed_uniqid' => $_POST['is_completed_uniqid'],
                                'qty' => $_POST['qty'],
                                'total' => $_POST['total'],
                                'path' => $current_folder
                            );

                            if (file_exists($current_folder . $path)) {
                                ///duplicated kayitlari sil
                                $this->Model_order_kiosk->update_order_item_upload_delete(intval($_POST['item_uniqid']), $path); 
                                $insert = $this->Model_order_kiosk->add_order_item_photo($form_data);

                                if ($insert > 0) {
                                    $status_process = array('status_process' => 2);
                                    $this->Model_order_kiosk->update_order(intval($_POST['order_number']), $status_process);
                                    exit(json_encode(array("status" => true, "message" => "success", "data" => "ok")));
                                } else {
                                    exit(json_encode(array("status" => false, "message" => "error", "data" => "Could not save to database!")));
                                }
                            } else {
                                exit(json_encode(array("status" => false, "message" => "error", "data" => "no")));
                            }
                        } else {
                            exit(json_encode(array("status" => false, "message" => "Image could not be uploaded!", "data" => "no")));
                        }
                    } else {
                        exit(json_encode(array("status" => false, "message" => "error", "data" => "no")));
                    }
                }
            } else {

                $form_data = array(
                    'order_number' => intval($_POST['order_number']),
                    'item_id' => intval($_POST['item_id']),
                    'item_uniqid' => intval($_POST['item_uniqid']),
                    'item_id_extra' => intval($_POST['item_id_extra']),
                    'item_id_duplicated' => $_POST['item_id_duplicated'],
                    'image_dublicated_name' => $_POST['image_dublicated_name'],
                    'with_name' => $_POST['with_name'],
                    'with_name_price' => $_POST['with_name_price'],
                    'image' => $_POST['image'],
                    'image_owner' => $_POST['image_owner'],
                    'is_extra' => $_POST['is_extra'],
                    'is_selected' => $_POST['is_selected'],
                    'qty' => $_POST['qty'],
                    'total' => $_POST['total'],
                    'path' => $_POST['current_folder']
                );

                if (file_exists($_POST['current_folder'] . $_POST['image'])) {
                    $insert = $this->Model_order_kiosk->add_order_item_photo($form_data);

                    if ($insert > 0) {
                        $status_process = array('status_process' => 2);
                        $this->Model_order_kiosk->update_order(intval($_POST['order_number']), $status_process);
                        exit(json_encode(array("status" => true, "message" => "success", "data" => "ok")));
                    } else {
                        exit(json_encode(array("status" => false, "message" => "error", "data" => "Could not save to database!")));
                    }
                } else {
                    exit(json_encode(array("status" => false, "message" => "error", "data" => "no")));
                }
            }
        } catch (Exception $e) {
            exit(json_encode(array('status' => false, 'message' => 'error', 'data' => '')));
        }
    }
    
    public function update_order_item_image_old()
    {
        try {
            $error = "";
            // token ekle
            // coklu siparislerde daha once cekilen resim secildiyse resmi tekrar yukleme 0=yukle 1=yukleme
            if ($_POST['item_id_duplicated'] == 0) {

                exit('amk');

                if (isset($_FILES['photo']["name"]) && isset($_FILES['photo']["tmp_name"])) {

                    $valid = 1;

                    $path = $_FILES['photo']['name'];
                    $path_tmp = $_FILES['photo']['tmp_name'];

                    if ($path != '') {
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $file_name = basename($path, '.' . $ext);
                        $ext_check = $this->Model_common->extension_check_photo($ext);
                        if ($ext_check == FALSE) {
                            $valid = 0;
                            $error .= 'You must have to upload cr2,jpg, jpeg, gif or png file for featured photo<br>';
                        }
                    } else {
                        $valid = 0;
                        $error .= 'You must have to select a photo for featured photo<br>';
                    }

                    if ($valid == 1) {
                        // $ai_id = rand(1000, 10000) . time();

                        $ai_id = rand(1000, 10000);

                        $path = $_POST['image']; // gönderilen resim rename ediliyor

                        $check_order_kiosk = $this->Model_order_kiosk->check_order(intval($_POST['order_number']));
                        $folder_date = date("d-m-Y", strtotime($check_order_kiosk['date_purchased']));
                        // $folder_date = date("d-m-Y");

                        $current_folder = "public/uploads/shop/order_kiosk_upload/" . str_replace(' ', '', trim(strtolower($_POST['land_name']))) . "/" . str_replace(' ', '', trim(strtolower($_POST['store_name']))) . "/" . $folder_date . "/" . intval($_POST['order_number']) . "/";

                        if (!file_exists($current_folder)) {
                            mkdir($current_folder, 0755, true);
                        }

                        if (move_uploaded_file($path_tmp, $current_folder . $path)) {
                            $form_data = array(
                                'order_number' => intval($_POST['order_number']),
                                'item_id' => intval($_POST['item_id']),
                                'item_uniqid' => intval($_POST['item_uniqid']),
                                'item_id_extra' => intval($_POST['item_id_extra']),
                                'item_id_duplicated' => 0,
                                'with_name' => $_POST['with_name'],
                                'with_name_price' => $_POST['with_name_price'],
                                'image' => $path,
                                'image_owner' => $_POST['image_owner'],
                                'is_extra' => $_POST['is_extra'],
                                'is_selected' => $_POST['is_selected'],
                                'is_completed_uniqid' => $_POST['is_completed_uniqid'],
                                'qty' => $_POST['qty'],
                                'total' => $_POST['total'],
                                'path' => $current_folder
                            );

                            if (file_exists($current_folder . $path)) {
                                $insert = $this->Model_order_kiosk->add_order_item_photo($form_data);

                                if ($insert > 0) {
                                    $status_process = array('status_process' => 2);
                                    $this->Model_order_kiosk->update_order(intval($_POST['order_number']), $status_process);
                                    exit(json_encode(array("status" => true, "message" => "success", "data" => "ok")));
                                } else {
                                    exit(json_encode(array("status" => false, "message" => "error", "data" => "Could not save to database!")));
                                }
                            } else {
                                exit(json_encode(array("status" => false, "message" => "error", "data" => "no")));
                            }
                        } else {
                            exit(json_encode(array("status" => false, "message" => "Image could not be uploaded!", "data" => "no")));
                        }
                    } else {
                        exit(json_encode(array("status" => false, "message" => "error", "data" => "no")));
                    }
                }
            } else {

                $form_data = array(
                    'order_number' => intval($_POST['order_number']),
                    'item_id' => intval($_POST['item_id']),
                    'item_uniqid' => intval($_POST['item_uniqid']),
                    'item_id_extra' => intval($_POST['item_id_extra']),
                    'item_id_duplicated' => $_POST['item_id_duplicated'],
                    'image_dublicated_name' => $_POST['image_dublicated_name'],
                    'with_name' => $_POST['with_name'],
                    'with_name_price' => $_POST['with_name_price'],
                    'image' => $_POST['image'],
                    'image_owner' => $_POST['image_owner'],
                    'is_extra' => $_POST['is_extra'],
                    'is_selected' => $_POST['is_selected'],
                    'qty' => $_POST['qty'],
                    'total' => $_POST['total'],
                    'path' => $_POST['current_folder']
                );

                if (file_exists($_POST['current_folder'] . $_POST['image'])) {
                    $insert = $this->Model_order_kiosk->add_order_item_photo($form_data);

                    if ($insert > 0) {
                        $status_process = array('status_process' => 2);
                        $this->Model_order_kiosk->update_order(intval($_POST['order_number']), $status_process);
                        exit(json_encode(array("status" => true, "message" => "success", "data" => "ok")));
                    } else {
                        exit(json_encode(array("status" => false, "message" => "error", "data" => "Could not save to database!")));
                    }
                } else {
                    exit(json_encode(array("status" => false, "message" => "error", "data" => "no")));
                }
            }
        } catch (Exception $e) {
            exit(json_encode(array('status' => false, 'message' => 'error', 'data' => '')));
        }
    }

    public function payment($order_number, $item_id = 0, $item_uniqid = 0, $token, $payment_method, $mail_step, $order_upgrade = "normal")
    {
        // $get_kiosk_data_payment = json_decode(file_get_contents('php://input'), true);

        if ($token === $this->token) {

            $url_for_postfinance = base_url() . $this->uri->segment('1') .'/'. $this->uri->segment('2');

            $check_order_kiosk = $this->Model_order_kiosk->check_order($order_number);
            $check_update_order_item = $this->Model_order_kiosk->check_update_order_item($item_uniqid);

            if ($mail_step === "banktransfer_step_1" || $mail_step === "banktransfer_step_2") {
                if ($payment_method === "bankTransfer") {
                    redirect(base_url() . 'shop/checkout_kiosk/success/' . $order_number . "/" . $payment_method . "/" . $order_upgrade . "/" . $token . "/" . $mail_step . "/" . $item_id . "/" . $item_uniqid);
                }
            }

            if ($mail_step === "mollie_step_1" || $mail_step === "mollie_step_2") {

                if ($order_upgrade === "orderupgrade") {
                    if ($check_order_kiosk['paid'] !== "isPaid") {
                        $total = $check_order_kiosk['total'] + $check_order_kiosk['total_update'];
                    } else {
                        $total = $check_order_kiosk['total_update'];
                    }
                } else {
                    $total = $check_order_kiosk['total'];
                }

                //https://irispicture.ch/shop/checkout_kiosk/payment/
                //base_url ile tobias i bul
                //tobias icin ödeme koy (postfinance) mollie i kaldir

                                

                if ('https://irispicture.ch/shop/checkout_kiosk' === $url_for_postfinance) {
                    //only for www.irispicture.ch (postfinance)
                    return $this->payment_postfinance($order_number, number_format($total, 2), $item_id, $item_uniqid, $token, $payment_method, $mail_step, $order_upgrade);
                } 

                $payment = $this->mollie->payments->create([
                    'amount' => [
                        'currency' => $check_order_kiosk['store_currency_code'],
                        // 'value' => $total
                        'value' => number_format($total, 2)
                    ],
                    'description' => 'IRISPICTURE KIOSK',
                    'redirectUrl' => base_url('shop/checkout_kiosk/success/') . $order_number . "/" . $payment_method . "/" . $order_upgrade . "/" . $this->token . "/" . $mail_step . "/" . $item_id . "/" . $item_uniqid,
                    // 'redirectUrl' => base_url('shop/checkout_kiosk/success/') . $order_number . "/" . $security_number
                    "metadata" => [
                        "store_name" => $check_order_kiosk['store_name'],
                        "check_order_response" => $order_number,

                        "billing_firstname" => $check_order_kiosk['billing_firstname'],
                        "billing_lastname" => $check_order_kiosk['billing_lastname'],
                        "billing_email" => $check_order_kiosk['billing_email'],
                        "billing_phone" => $check_order_kiosk['billing_phone'],
                        "billing_street" => $check_order_kiosk['billing_street'],
                        "billing_street_no" => $check_order_kiosk['billing_street_no'],
                        "billing_postcode" => $check_order_kiosk['billing_postcode'],
                        "billing_city" => $check_order_kiosk['billing_city'],
                        "billing_country" => $check_order_kiosk['billing_country'],
                        "billing_comment" => $check_order_kiosk['billing_comment']
                    ]
                ]);

                $this->session->set_userdata('payment_id', $payment->id);

                $this->logger->user('kiosk')->type('Shop Payment Kiosk')->id(1)->token(sha1(mt_rand()))->comment('New order payment -> ' . $order_number)->log();

                header("Location: " . $payment->getCheckoutUrl(), true, 303);
            }

            if ($mail_step === "mollie_step_3" || $mail_step === "mollie_step_4") {

                if (empty($check_order_kiosk)) {
                    exit(json_encode(array('status' => false, 'message' => 'Order not found!')));
                }
                // print_r($this->Model_order_kiosk->check_update_order_item($item_uniqid));
                // print_r($check_update_order_item);
                if (empty($check_update_order_item)) {
                    exit(json_encode(array('status' => false, 'message' => 'Order items not found!')));
                }

                /**
                 * Calc 
                 */
                // $item_total = 0;
                // foreach ($check_update_order_item_single as $calc_total) {
                //     $item_total += $calc_total['item_subtotal'];
                // }

                // $with_name_total = $check_order_kiosk['with_name_price'];

                // $total = $item_total + $with_name_total;

                // $update_item_total = array(
                //     "item_update_total" => $total
                // );
                // // echo "Total: " . $total;
                // $this->Model_order_kiosk->check_update_order_item_single_update_paid($item_id, $order_number, $update_item_total);

                if ('https://irispicture.ch/shop/checkout_kiosk' === $url_for_postfinance) {
                    //only for www.irispicture.ch (postfinance)
                    return $this->payment_postfinance($order_number, number_format($check_update_order_item['item_update_total'], 2), $item_id, $item_uniqid, $token, $payment_method, $mail_step, $order_upgrade);
                } 

                $payment = $this->mollie->payments->create([
                    'amount' => [
                        'currency' => $check_order_kiosk['store_currency_code'],
                        'value' => number_format($check_update_order_item['item_update_total'], 2)
                    ],
                    'description' => 'IRISPICTURE KIOSK',
                    'redirectUrl' => base_url('shop/checkout_kiosk/success/') . $order_number . "/" . $payment_method . "/" . $order_upgrade . "/" . $this->token . "/" . $mail_step . "/" . $item_id . "/" . $item_uniqid,
                    // 'redirectUrl' => base_url('shop/checkout_kiosk/success/') . $order_number . "/" . $security_number
                    "metadata" => [
                        "billing_firstname" => $check_order_kiosk['billing_firstname'],
                        "billing_lastname" => $check_order_kiosk['billing_lastname'],
                        "billing_email" => $check_order_kiosk['billing_email'],
                        "billing_phone" => $check_order_kiosk['billing_phone'],
                        "check_order_response" => $order_number
                    ]
                ]);

                $this->session->set_userdata('payment_id', $payment->id);

                $this->logger->user('kiosk')->type('Shop Payment Kiosk')->id(1)->token(sha1(mt_rand()))->comment('Update order payment -> ' . $order_number)->log();

                header("Location: " . $payment->getCheckoutUrl(), true, 303);
            }
        } else {
            redirect(base_url('shop'));
        }
    }

    public function success($order_number, $payment_method = "mollie", $order_upgrade = "normal", $token, $mail_step, $item_id = 0, $item_uniqid = 0)
    {
        $success = '';
        $error = '';
        $paid = '';

        if ($token !== $this->token) {
            exit('access denied!');
        }

        $get_order_kiosk_email = $this->Model_order_kiosk->check_order($order_number);
        $check_order_item_uniqid = $this->Model_order_kiosk->check_order_item_uniqid($item_uniqid);
        // $check_order_item_email = $this->Model_order_kiosk->check_order_item_email($item_id, $order_number);


        //bu kisimda coupon codu control edilecek current limit artirillacak bu update olacak bu kisma model eklenecek

        /**
         * banktransfer_step_1 kiosk mollie ödeme (ilk order add)
         * banktransfer_step_2 mollie ödeme (Çekim öncesi banktransferi mollie ile ödeme)
         * banktransfer_step_3 mollie ödeme (Çekim sonrası update ödeme)
         */

        // if ($mail_step === "banktransfer_step_1") {
        //     $message_type_bank = "AfterShootingBilling";
        // } else if ($mail_step === "banktransfer_step_2") {
        //     $message_type_bank = "Kioskpaymentshooting";
        // } else if ($mail_step === "banktransfer_step_3") {
        //     $message_type_bank = "AfterShootingBilling";
        // }

        if ($payment_method === "bankTransfer") {

            if ($order_upgrade === "orderupgrade") {
                $paid_field = "paid_update";
                $payment_method_field = "payment_method_update";
            } else {
                $paid_field = "paid";
                $payment_method_field = "payment_method";
            }

            $paid = "isPending";
            $data = array($paid_field => $paid, $payment_method_field => $payment_method);

            $result = $this->Model_order_kiosk->confirmed_order($order_number, $data);

            if ($result == 1) {
                $this->logger->user('kiosk')->type('Shop Payment Success Kiosk')->id(1)->token(sha1(mt_rand()))->comment('Banktransfer has been successfully -> ' . $order_number)->log();

                if ($mail_step === "banktransfer_step_1") {
                    $message_type_bank = "AfterShootingBilling";
                    $this->shop_email->send_email($get_order_kiosk_email['store_lang_code'], "AfterShootingBilling", $get_order_kiosk_email['billing_email'], $order_number);
                } else if ($mail_step === "banktransfer_step_2") {
                    $this->shop_email->send_email_single_banktransfer_kiosk($order_number, $item_uniqid);
                    // $message_type_bank = "AfterShootingBilling";
                    // $this->shop_email->send_email_uniqid($get_order_kiosk_email['store_lang_code'], "AfterShootingBilling", $check_order_item_uniqid['email'], $order_number);
                }

                // $this->shop_email->send_email($get_order_kiosk_email['store_lang_code'], $message_type_bank, $get_order_kiosk_email['billing_email'], $order_number);

                $paid = true;
                $message = "success";
                $data = "";
                exit(json_encode(array('status' => $paid, 'message' => $message, 'data' => '')));
            } else {
                $paid = false;
                $message = "error";
                $data = "";
                exit(json_encode(array('status' => $paid, 'message' => $message, 'data' => '')));
            }
        }

        $url_for_postfinance = base_url() . $this->uri->segment('1') .'/'. $this->uri->segment('2') .'/'. $this->uri->segment('3');

        // exit($url_for_postfinance);
        if ('https://irispicture.ch/shop/checkout_kiosk/success' === $url_for_postfinance) {

            if ($mail_step === "mollie_step_1") {
                $message_type_mollie = "mollie";
            } else if ($mail_step === "mollie_step_2") { //shooting update
                $message_type_mollie = "Kioskpaymentshooting";
            } else if ($mail_step === "mollie_step_3") {
                $message_type_mollie = "AfterShootingMollie";
                $this->shop_email->send_email($get_order_kiosk_email['store_lang_code'], "Kioskpaymentshooting", $get_order_kiosk_email['billing_email'], $order_number);
            } else if ($mail_step === "mollie_step_4") {
                $message_type_mollie = "AfterShootingMollie"; //ödemeniz alindi maili
                $this->shop_email->send_email_uniqid($get_order_kiosk_email['store_lang_code'], "Kioskpaymentshootinguniq", $check_order_item_uniqid['email'], $order_number);
            }

            // $this->shop_email->send_email($get_order_kiosk_email['store_lang_code'], $message_type_mollie, $get_order_kiosk_email['billing_email'], $order_number);

            
            //only for www.irispicture.ch (postfinance)
            exit("POSTFINANCE: The transaction is successful, please continue from the kiosk!");
        }

        $payment = $this->mollie->payments->get($this->session->userdata('payment_id'));

        $session_form_data = $this->session->userdata('payment_form');

        if ($payment->metadata->check_order_response == $order_number) {
            if ($payment->isPaid()) {

                if ($get_order_kiosk_email['coupon_code'] && $get_order_kiosk_email['discount_amount'] > 0) {
                    $data_add_coupon_spend = array(
                        'total' => $get_order_kiosk_email['discount_amount'],
                        'code' => $get_order_kiosk_email['coupon_code']
                    );

                    $data_update_coupon = array(
                        'current_limit' => +1
                    );

                    $this->Model_coupon->update_coupon($get_order_kiosk_email['coupon_code'], $data_update_coupon);
                    $this->Model_coupon->add_coupon_spend($data_add_coupon_spend);
                }

                if ($order_upgrade === "orderupgrade") {
                    $data = array(
                        "paid" => "isPaid",
                        "paid_update" => "isPaid",
                        "payment_method_update" => $payment_method
                    );
                } else {
                    $data = array(
                        "paid" => "isPaid",
                        "payment_method" => $payment_method
                    );
                }

                $this->Model_order_kiosk->confirmed_order($order_number, $data);

                $this->logger->user('kiosk')->type('Shop Payment Success Kiosk')->id(1)->token(sha1(mt_rand()))->comment('Payment has been successfully -> ' . $order_number)->log();

                /**
                 * mollie_step_1 kiosk mollie ödeme (ilk order add)
                 * mollie_step_2 mollie ödeme (Çekim öncesi banktransferi mollie ile ödeme)
                 * mollie_step_3 mollie ödeme (Çekim sonrası update ödeme)
                 */

                if ($mail_step === "mollie_step_1") {
                    $message_type_mollie = "mollie";
                } else if ($mail_step === "mollie_step_2") { //shooting update
                    $message_type_mollie = "Kioskpaymentshooting";
                } else if ($mail_step === "mollie_step_3") {
                    $message_type_mollie = "AfterShootingMollie";
                    $this->shop_email->send_email($get_order_kiosk_email['store_lang_code'], "Kioskpaymentshooting", $get_order_kiosk_email['billing_email'], $order_number);
                } else if ($mail_step === "mollie_step_4") {
                    $message_type_mollie = "AfterShootingMollie"; //ödemeniz alindi maili
                    $this->shop_email->send_email_uniqid($get_order_kiosk_email['store_lang_code'], "Kioskpaymentshootinguniq", $check_order_item_uniqid['email'], $order_number);
                }

                $this->shop_email->send_email($get_order_kiosk_email['store_lang_code'], $message_type_mollie, $get_order_kiosk_email['billing_email'], $order_number);

                if ($mail_step === "mollie_step_3" || $mail_step === "mollie_step_4") {
                    $update_item_data = array(
                        'is_paid' => 1
                    );
                    $this->Model_order_kiosk->check_update_order_item_updated_single_update_paid($item_uniqid, $update_item_data);
                }
            }
        } else {

            if ($order_upgrade === "orderupgrade") {
                $paid_field = "paid_update";
                $payment_method_field = "payment_method_update";
            } else {
                $paid_field = "paid";
                $payment_method_field = "payment_method";
            }

            //işlemler başarısız ise isfailed olarak ayarla
            $paid = "isFailed";

            $data = array($paid_field => $paid, $payment_method_field => $payment_method);

            $this->Model_order_kiosk->confirmed_order($order_number, $data);

            echo "Payment isFailed.";

            redirect(base_url('shop'));
        }

        //        print_r($session_form_data);

        exit("The transaction is successful, please continue from the kiosk!");
    }
    public function payment_check_postfinance($order_number, $payment_method,$order_upgrade,$token, $mail_step,$item_id, $item_uniqid)
    {
        // Setup API client
        $spaceId = 18373;
        $userId = 43756;
        $secret = 'vU3cr7wSlPVO+uRlg1t0C9cXHSsNsiaEun5i8WY7wtk=';
        $client = new \PostFinanceCheckout\Sdk\ApiClient($userId, $secret);

        $check_order_kiosk = $this->Model_order_kiosk->check_order($order_number);
        
        
            
         //test bittikten sonra bu kismi yukaridani akfif et (if blogunu)   
        // $payment = 'SUCCESSFUL';
        // if ($payment === 'SUCCESSFUL') {
            
        $payment = $client->getTransactionCompletionService()->completeOnline($spaceId, $this->session->userdata('entityId'));
        if ($payment['state'] === 'SUCCESSFUL') {
            if ($order_upgrade === "orderupgrade") {
                $data = array(
                    "paid" => "isPaid",
                    "paid_update" => "isPaid",
                    "payment_method_update" => 'postfinance'//$payment_method
                );
            } else {
                $data = array(
                    "paid" => "isPaid",
                    "payment_method" => 'postfinance'//$payment_method
                );
            }

            $this->Model_order_kiosk->confirmed_order($order_number, $data);

            if ($mail_step === "mollie_step_3" || $mail_step === "mollie_step_4") {
                $update_item_data = array(
                    'is_paid' => 1
                );
                $this->Model_order_kiosk->check_update_order_item_updated_single_update_paid($item_uniqid, $update_item_data);
            }

            $this->shop_email->send_email(
                $check_order_kiosk['store_lang_code'],
                "mollie",
                $check_order_kiosk['billing_email'],
                $order_number
            );
            
            redirect(base_url('shop/checkout_kiosk/success/' . $order_number . "/" . $payment_method . "/" . $order_upgrade . "/" . $token . "/" . $mail_step . "/" . $item_id . "/" . $item_uniqid));
        }elseif ($payment['state'] === 'PENDING' || $payment['state'] === 'AUTHORIZED' || $payment['state'] === 'FULFILL' || $payment['state'] === 'CONFIRMED' || $payment['state'] === 'COMPLETED') {

            $order_data = array(
                'paid' => 'isOpen'
            );
            $update_order = $this->Model_order->update_order($session_form_data['order_number'], $order_data);
                
        } else {
            $this->shop_email->single_email(
                $session_form_data['store_lang_code'],
                "MollieError",
                $session_form_data['billing_email'],
                $order_number
            );
        }
    }

    function payment_postfinance($order_number, $total, $item_id, $item_uniqid, $token, $payment_method, $mail_step, $order_upgrade)
    {
        //test icin 
        // header('Location: ' . base_url('shop/checkout_kiosk/payment_check_postfinance/'. $order_number . "/" . $payment_method . "/" . $order_upgrade . "/" . $token . "/" . $mail_step . "/" . $item_id . "/" . $item_uniqid));
        // exit('dur bi amk');
        // Setup API client
        $spaceId = 18373;
        $userId = 43756;
        $secret = 'vU3cr7wSlPVO+uRlg1t0C9cXHSsNsiaEun5i8WY7wtk=';
        $client = new \PostFinanceCheckout\Sdk\ApiClient($userId, $secret);

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
        $transactionPayload->setSuccessUrl(base_url('shop/checkout_kiosk/payment_check_postfinance/'. $order_number . "/" . $payment_method . "/" . $order_upgrade . "/" . $token . "/" . $mail_step . "/" . $item_id . "/" . $item_uniqid));
        $transaction = $client->getTransactionService()->create($spaceId, $transactionPayload);

        
        // Create Payment Page URL:
        $redirectionUrl = $client->getTransactionPaymentPageService()->paymentPageUrl($spaceId, $transaction->getId());

        if(!empty($transaction->getId())){
            $this->session->set_userdata('entityId', $transaction->getId());
            header('Location: ' . $redirectionUrl);
        } else {
            header("refresh: 1;");
        }
    }
}
