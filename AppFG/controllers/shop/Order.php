<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Order extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model_common');
        $this->load->model('shop/Model_order');
        $this->load->model('api/Model_shop');

        $this->load->library('cart');

        if($this->session->userdata('site_language')){
            $lang = $this->session->userdata('site_language');
        } elseif($this->session->userdata('store_language')) {
            $lang = $this->session->userdata('store_language');
        } else {
            $lang = "de";
        }
        $this->lang->load('file', $lang);
        //$this->output->cache(60);
    }

    public function index()
    {
        redirect(base_url('shop'));
    }

    public function customer_confirm_process()
    {
        
        $data['setting'] = $this->Model_common->all_setting();
        $data['page_home'] = $this->Model_common->all_page_home();
        $data['social'] = $this->Model_common->all_social();
        $data['theme'] = $data['setting']['layout'];

        $this->load->view('layout/' . $data['setting']['layout'] . '/view_header', $data);
        if ($data['setting']['website_status_frontend'] === 'Active' || in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) {
            $this->load->view('layout/' . $data['setting']['layout'] . '/shop/view_customer_confirm_process', $data);
        } else {
            $this->load->view('view_maintenance', $data);
        }
        $this->load->view('layout/' . $data['setting']['layout'] . '/view_footer', $data);
    }

    public function check()
    {
        if (intval($this->input->post('order_number'))) {
            $order_number = intval($this->input->post('order_number'));
            $chek_order = $this->Model_order->check_order($order_number);
            if ($chek_order) {
                exit(json_encode(array("status" => 200, "data" => $chek_order)));
            } else {
                exit(json_encode(array('responseStatus' => 404, 'responseMessage' => 'error')));
            }
        } else {
            exit(json_encode(array('responseStatus' => 404, 'responseMessage' => 'error')));
        }
    }

    public function confirm($order_number = "")
    {

        $data['for_mail'] = $this->Model_order->check_order($this->input->post('order_number'));
        $data['order_items'] = $this->Model_order->check_order_item($order_number);

        if ($this->input->post()) {
            if ($this->input->post('confirm_order') == 1) {
                $status_process = 6;
                $this->send_email($data['for_mail']->store_lang_code, "CustomerConfirmed", $data['for_mail']->billing_email);
            } else {
                $status_process = 13;
                $this->send_email($data['for_mail']->store_lang_code, "NotConfirmOrder", $data['for_mail']->billing_email);
            }
            $data = array(
                "freigabe" => $this->input->post('confirm_order'),
                "status_process" => $status_process
            );

            $data_customer = array(
                "freigabe" => $this->input->post('confirm_order'),
                "comment" => $this->input->post('comment'),
                "order_number" => $this->input->post('order_number')
            );

            $confirm_order = $this->Model_order->confirm_order($data_customer);
            $update_order = $this->Model_order->update_order($this->input->post('order_number'), $data);
            if ($confirm_order > 0 || $update_order > 0) {
                exit(json_encode(array("status" => "success")));
            } else {
                exit(json_encode(array("status" => "Error")));
            }
        }

        $data['setting'] = $this->Model_common->all_setting();
        $data['page_home'] = $this->Model_common->all_page_home();
        $data['social'] = $this->Model_common->all_social();
        $data['theme'] = $data['setting']['layout'];

        if (!empty($order_number)) {
            $data['order'] = $this->Model_order->check_order($order_number);
            // $data['order'] = $this->Model_order->customer_confirm_process($order_number);
            $data['order_image'] = $this->Model_order->get_order_image($order_number);

            if ($data['order'] == NULL || $data['order']->freigabe != 0) {
                redirect(base_url('shop'));
            }
        }

        $data['order_images_with_watermak'] = array();

        foreach ($data['order_image'] as $row_images) {
            $new_name = $order_number . "_" . uniqid() . ".jpg";
            $data['order_images_with_watermak'][] = $new_name;
            $this->watermark(
                $row_images['path'] . "/" . $row_images['image'],
                $new_name
            );
        }

        $this->load->view('layout/' . $data['setting']['layout'] . '/view_header', $data);
        $this->load->view('layout/' . $data['setting']['layout'] . '/shop/view_confirm', $data);
        $this->load->view('layout/' . $data['setting']['layout'] . '/view_footer', $data);
    }

    public function get_updatable_product($product_id, $land_id, $lang_code)
    {
        $this->load->model('shop/Model_shopping_cart');

        $get_product = $this->Model_shop->single_product($product_id);

        $updatable_products = $this->Model_shop->updatable_product($product_id, $land_id);

        // print_r($get_product);exit;
        // print_r($updatable_products);exit;
        $products = array();

        foreach ($updatable_products as $product) {
            // $products[] = $product['id'];
            // $products[] = $this->Model_shopping_cart->product_check($product['allow_product'], $lang_code);

            $product_check = $this->Model_shopping_cart->product_check($product['allow_product'], $lang_code);

            if ($product_check['product_price'] > $get_product['product_price']) {
                $products[] = $product_check;
            }
        }
        exit(json_encode($products));
    }

    public function send_email($lang_code = "de", $message_type = "", $email)
    {
        $this->load->model('Model_common');

        $send_email['mail'] = $this->Model_common->get_send_email($lang_code, $message_type);

        $data['setting'] = $this->Model_common->all_setting();

        // $message = json_encode($send_email['mail']);


        $this->load->library('email');

        $this->email->from($data['setting']['send_email_from']);
        $this->email->to($email);

        $this->email->subject($send_email['mail']['subject']);
        $this->email->message($send_email['mail']['message']);

        $this->email->set_mailtype("html");

        $this->email->send();
    }

    public function watermark($from, $new_name)
    {
        ini_set('xdebug.max_nesting_level', -1);
        $this->load->library('watermark');
        $to = "public/watermark_order_images/" . $new_name;

        $water_mark = "public/watermark.png";
        $this->watermark->apply($from, $to, $water_mark, 0);
    }

    public function upload_image($order_number)
    {
        echo $order_number;
    }
}
