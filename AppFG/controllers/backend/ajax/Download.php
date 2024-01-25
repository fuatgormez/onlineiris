<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Download extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('id')) {
            redirect(base_url() . 'backend/admin/login');
            exit;
        }

        $this->load->model('backend/ajax/Model_download');

        $this->load->library('zip');
        $this->load->library('logger/logger');
        // print_r($this->Model_download->check_order("205281612036092"));

    }

    public function index()
    {
        redirect(base_url());
    }
    
    public function order_images_download($order_number)
    {
        ini_set('memory_limit', '-1');

        // $order_number = $this->input->post('order_number');

        $get_order = $this->Model_download->get_order($order_number);
        $get_order_item = $this->Model_download->get_order_item($order_number);
        $get_order_item_updated = $this->Model_download->get_order_item_updated($order_number);
        $order_images = $this->Model_download->check_order($order_number);

        try {
            if (in_array($get_order['paid'], ["isPaid", "paid"])) {
                
                if ($order_images) {

                    $item_list = PHP_EOL .
                        'Order Information ' . PHP_EOL . PHP_EOL .
                        '####################################' . PHP_EOL . PHP_EOL .
                        'Not: S = SELECTED bzw. Favorit' . PHP_EOL . PHP_EOL .
                        '######### Order Item List ##########' . PHP_EOL .
                        '___________________________________________________' . PHP_EOL . PHP_EOL;

                    foreach ($order_images as $image) {


                        $path = $image['path'] . $image['image'];
                        $ext = pathinfo($path, PATHINFO_EXTENSION);

                        $ext_check = $this->Model_download->extension_check_photo($ext);
                        if ($ext_check == TRUE) {

                            if($image['image_dublicated_name'] !== NULL){
                                $image_dublicated_name = "image_dublicated_name: " . $image["image_dublicated_name"] . PHP_EOL;
                            } else {
                                $this->zip->read_file($path);
                                $image_dublicated_name = '' ;
                            }
                            

                            $item_list .=
                                "image: " . $image["image"] . PHP_EOL .
                                "image_owner: " . $image["image_owner"] . PHP_EOL .
                                $image_dublicated_name .
                                "with_name: " . $image["with_name"] . PHP_EOL .
                                "created_at: " . $image["created_at"] . PHP_EOL .
                                "___________________________________________________" . PHP_EOL . PHP_EOL ;

                        }
                    }

                    $item_list .=  PHP_EOL . '######### Orijinal order items ##########' . PHP_EOL .  PHP_EOL .
                        '___________________________________________________' . PHP_EOL . PHP_EOL;

                    foreach ($get_order_item as $order_item) {
                        $item_list .= 'Item ID: ' . $order_item['item_product_id'] . PHP_EOL .
                            'Item Name: ' . $order_item['item_name'] . PHP_EOL .
                            'Qty: ' . $order_item['item_qty'] . PHP_EOL .
                            'Item Price: ' . $order_item['item_price'] . PHP_EOL .
                            'Subtotal: ' . $order_item['item_subtotal'] . PHP_EOL .
                            "___________________________________________________" . PHP_EOL . PHP_EOL;
                    }

                    $item_list .= '####################################' . PHP_EOL . PHP_EOL;


                    foreach ($get_order_item_updated as $order_item_updated) {
                        $item_list .= 'Item ID: ' . $order_item_updated['item_id'] . PHP_EOL .
                            'Item ID Old: ' . $order_item_updated['item_id_old'] . PHP_EOL .
                            'Item Name: ' . $order_item_updated['item_name'] . PHP_EOL .
                            'Qty: ' . $order_item_updated['item_qty'] . PHP_EOL .
                            'Item Price: ' . $order_item_updated['item_price'] . PHP_EOL .
                            'Subtotal: ' . $order_item_updated['item_subtotal'] . PHP_EOL .
                            'Update - Extra: ' . $order_item_updated['is_updated'] . PHP_EOL .
                            "___________________________________________________" . PHP_EOL . PHP_EOL;
                    }

                    $item_list .= '####################################' . PHP_EOL . PHP_EOL;

                    $item_list .= 'Paid: ' . $get_order['paid'] . PHP_EOL .
                        'Payment Method: ' . $get_order['payment_method'] . PHP_EOL .
                        'Paid Update: ' . $get_order['paid_update'] . PHP_EOL .
                        'Payment Method Update: ' . $get_order['payment_method_update'] . PHP_EOL;

                    $this->zip->add_data($order_number . ".txt", $item_list);

                    $this->zip->download($order_number . '.zip');
                    $this->logger->user($this->session->userdata('username'))->type('Order Update')->id(1)->token(sha1(mt_rand()))->comment('Order images downloaded from ' . $this->session->userdata('username') . ' | order_number -> ' . $order_number)->log();
                } else {
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                exit(json_encode(array('status' => 'not_paid')));
            } // if ispaid and ispaid_update
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    
    public function order_images_done_download($order_number)
    {//tbl_shop_order_item_upload_done
        ini_set('memory_limit', '-1');

        // $order_number = $this->input->post('order_number');

        $get_order = $this->Model_download->get_order($order_number);
        $get_order_item = $this->Model_download->get_order_item($order_number);
        $get_order_item_updated = $this->Model_download->get_order_item_updated($order_number);
        $order_images = $this->Model_download->check_order_done($order_number);
        // $order_images = $this->Model_download->check_order($order_number);

        try {
            if (in_array($get_order['paid'], ["isPaid", "paid"])) {
                
                if ($order_images) {

                    $item_list = PHP_EOL .
                        'Order Information ' . PHP_EOL . PHP_EOL .
                        '####################################' . PHP_EOL . PHP_EOL .
                        'Not: S = SELECTED bzw. Favorit' . PHP_EOL . PHP_EOL .
                        '######### Order Item List ##########' . PHP_EOL .
                        '___________________________________________________' . PHP_EOL . PHP_EOL;

                    foreach ($order_images as $image) {


                        $path = $image['path'] . $image['image'];
                        $ext = pathinfo($path, PATHINFO_EXTENSION);

                        $ext_check = $this->Model_download->extension_check_photo($ext);
                        if ($ext_check == TRUE) {

                            if($image['image_dublicated_name'] !== NULL){
                                $image_dublicated_name = "image_dublicated_name: " . $image["image_dublicated_name"] . PHP_EOL;
                            } else {
                                $this->zip->read_file($path);
                                $image_dublicated_name = '' ;
                            }
                            

                            $item_list .=
                                "image: " . $image["image"] . PHP_EOL .
                                "image_owner: " . $image["image_owner"] . PHP_EOL .
                                $image_dublicated_name .
                                "with_name: " . $image["with_name"] . PHP_EOL .
                                "created_at: " . $image["created_at"] . PHP_EOL .
                                "___________________________________________________" . PHP_EOL . PHP_EOL ;

                        }
                    }

                    $item_list .=  PHP_EOL . '######### Orijinal order items ##########' . PHP_EOL .  PHP_EOL .
                        '___________________________________________________' . PHP_EOL . PHP_EOL;

                    foreach ($get_order_item as $order_item) {
                        $item_list .= 'Item ID: ' . $order_item['item_product_id'] . PHP_EOL .
                            'Item Name: ' . $order_item['item_name'] . PHP_EOL .
                            'Qty: ' . $order_item['item_qty'] . PHP_EOL .
                            'Item Price: ' . $order_item['item_price'] . PHP_EOL .
                            'Subtotal: ' . $order_item['item_subtotal'] . PHP_EOL .
                            "___________________________________________________" . PHP_EOL . PHP_EOL;
                    }

                    $item_list .= '####################################' . PHP_EOL . PHP_EOL;


                    foreach ($get_order_item_updated as $order_item_updated) {
                        $item_list .= 'Item ID: ' . $order_item_updated['item_id'] . PHP_EOL .
                            'Item ID Old: ' . $order_item_updated['item_id_old'] . PHP_EOL .
                            'Item Name: ' . $order_item_updated['item_name'] . PHP_EOL .
                            'Qty: ' . $order_item_updated['item_qty'] . PHP_EOL .
                            'Item Price: ' . $order_item_updated['item_price'] . PHP_EOL .
                            'Subtotal: ' . $order_item_updated['item_subtotal'] . PHP_EOL .
                            'Update - Extra: ' . $order_item_updated['is_updated'] . PHP_EOL .
                            "___________________________________________________" . PHP_EOL . PHP_EOL;
                    }

                    $item_list .= '####################################' . PHP_EOL . PHP_EOL;

                    $item_list .= 'Paid: ' . $get_order['paid'] . PHP_EOL .
                        'Payment Method: ' . $get_order['payment_method'] . PHP_EOL .
                        'Paid Update: ' . $get_order['paid_update'] . PHP_EOL .
                        'Payment Method Update: ' . $get_order['payment_method_update'] . PHP_EOL;

                    $this->zip->add_data($order_number . ".txt", $item_list);

                    $this->zip->download($order_number . '.zip');
                    $this->logger->user($this->session->userdata('username'))->type('Order Update')->id(1)->token(sha1(mt_rand()))->comment('Order images downloaded from ' . $this->session->userdata('username') . ' | order_number -> ' . $order_number)->log();
                } else {
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                exit(json_encode(array('status' => 'not_paid')));
            } // if ispaid and ispaid_update
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
}
