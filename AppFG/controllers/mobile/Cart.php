<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart extends CI_Controller
{


    function __construct()
    {
        parent::__construct();

        
        if (empty($this->session->userdata('order_number_token'))) {redirect(base_url('mobile/home'));}
        

        $this->load->model('Model_common');
        $this->load->model('Model_service');
        $this->load->model('shop/Model_shopping_cart');
        $this->load->model('shop/Model_order');

        $this->load->library('cart');

        if(!$this->session->userdata('order_number_token'))
        	redirect(base_url('mobile/home'));
    }

    public function index()
    {
        redirect(base_url('mobile/home'));

        if (empty($this->cart->contents())) { redirect(base_url('mobile/home')); }

        $data['setting'] = $this->Model_common->all_setting();

        $this->load->view('layout/mobile/view_header', $data);
        if ($data['setting']['website_status_mobile'] === 'Active' || in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) {
            $this->load->view('layout/mobile/view_cart', $data);
        } else {
            $this->load->view('layout/mobile/view_maintenance', $data);
        }
        $this->load->view('layout/mobile/view_footer', $data);
    }

    public function add()
    {
        $error = '';
        $success = '';

        if ($this->input->is_ajax_request() && $this->input->method() == 'post') {
            if (isset($_POST['basket']) && $_POST['basket'] === "basket") {

                $valid = 1;

                $this->form_validation->set_rules('product_id', 'Product Id', 'trim|integer|xss_clean|required');

                if ($this->form_validation->run() == FALSE) {
                    $valid = 0;
                    $error .= validation_errors();
                }

                $product_check = $this->Model_shopping_cart->product_check($this->input->post('product_id'));

                if ($valid == 1) {
                    if ($product_check) {

                        $product_data = array(
                            "id" => $product_check["id"],
                            "name" => $product_check["category_name"] . " " . $product_check["product_name"],
                            "price" => number_format($product_check["product_price"], 2),
                            "qty" => 1,
                            "image" => $product_check["thumbnail"],
                        );

                        $this->cart->product_name_rules = '[:print:]';
                        $this->cart->insert($product_data);
                        $this->shipping_total();
                        //git test

                        $success = "item has been added successfully!";
                        exit(json_encode(array(
                            "cart_contents" => $this->cart->contents(),
                            "cart_item_amounts" => $this->cart->total_items(),
                            "cart_total" => number_format($this->cart->total(), 2),
                            "product" => $product_data,
                            "responseMessage" => $success,
                            "statusCode" => 200
                        )));
                    } else {
                        exit(json_encode(array(
                            "responseMessage" => "Product not found!",
                            "statusCode" => 404
                        )));
                    }
                }
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function update()
    {
        $error = '';
        $success = '';
        if ($this->input->is_ajax_request() && $this->input->method() == 'post') {
            $valid = 1;
            $this->form_validation->set_rules('product_id', 'Product Id', 'trim|integer|required');

            if ($this->form_validation->run() == FALSE) {
                $valid = 0;
                $error .= validation_errors();
            }

            $product_check = $this->Model_shopping_cart->product_check($this->input->post('product_id'));

            if ($valid == 1) {
                if ($product_check) {

                    $product_data = array(
                        "rowid" => $this->input->post('rowid'),
                        "qty" => $this->input->post('qty')
                    );


                    // print_r($product_data);
                    // exit;
                    $this->cart->update($product_data);
                    $this->shipping_total();

                    exit(json_encode(array(
                        "cart_contents" => $this->cart->contents(),
                        "cart_item_amounts" => $this->cart->total_items(),
                        "cart_subtotal" => number_format($this->subtotal(), 2),
                        "cart_total" => number_format($this->cart->total(), 2),
                        "product" => $product_check,
                        "responseMessage" => "Amount changed!",
                        "statusCode" => 200
                    )));
                } else {
                    exit(json_encode(array("responseMessage" => "Product not found!",)));
                }
            }
        } else {
            redirect(base_url(), 'refresh'); //Bad request!
        }
    }

    public function cart_contents()
    {
        exit(json_encode(array(
            "cart_contents" => $this->cart->contents(),
            "cart_item_amounts" => $this->cart->total_items(),
            "cart_total" => number_format($this->cart->total(), 2),
            "responseMessage" => 'All Cart Contents Items',
            "statusCode" => 200
        )));
    }

    public function load()
    {
        echo $this->view();
    }

    public function view()
    {
        $output = '';
        $output .= '
              <div class="table-responsive">
               <div align="right">
                <button type="button" id="clear_cart" class="btn btn-warning">Clear Cart</button>
               </div>
               <br />
               <table class="table table-bordered">
                <tr>
                 <th width="40%">Name</th>
                 <th width="15%">Quantity</th>
                 <th width="15%">Price</th>
                 <th width="15%">Total</th>
                 <th width="15%">Action</th>
                </tr>
            
              ';
        $count = 0;
        foreach ($this->cart->contents() as $items) {
            $count++;
            $output .= '
                       <tr> 
                        <td>' . $items["name"] . '</td>
                        <td>' . $items["qty"] . '</td>
                        <td>' . number_format($items["price"], 2) . '</td>
                        <td>' . number_format($items["subtotal"], 2) . '</td>
                        <td><i class="fa fa-2x fa-times-circle text-danger remove_inventory" id="' . $items["rowid"] . '"></i> </td>
                       </tr>
                       ';
        }
        $output .= '
                       <tr>
                        <td colspan="4" align="right">Total</td>
                        <td>' . number_format($this->cart->total(), 2) . '</td>
                       </tr>
                      </table>
                    
                      </div>
                      ';

        if ($count == 0) {
            $output = '<h3 align="center">Cart is Empty</h3>';
        }
        return $output;
    }

    public function shipping_total()
    {
        $this->session->set_userdata('shipping_total', number_format(9.99, 2));
        $this->shipping = $this->session->userdata('shipping_total');

        // foreach ($this->cart->contents() as $item) {
        //     $this->session->set_userdata('shipping_total', number_format(9.99, 2));
        //     $this->shipping = $this->session->userdata('shipping_total');
        // }
        return $this->shipping;
        // return $this->session->set_userdata(array("shipping_total" => $this->session->userdata('shipping_total') + $val ));
    }

    public function subtotal()
    {
        return $this->cart->total();
    }

    public function total()
    {
        return $this->cart->total();
    }

    public function proportion()
    {
        return $this->coupon_calculator();
    }

    public function coupon()
    {
        $error = '';
        $success = '';

        if ($this->input->is_ajax_request() && $this->input->method() == 'post') {

            $csrf_fg = $this->security->get_csrf_hash();

            $coupon_code = $this->input->post('coupon_code');

            $check_coupon_code = $this->Model_common->check_coupon_code($coupon_code);

            if (!empty($coupon_code) && $check_coupon_code > 0) {

                // if($check_coupon_code['discount_type'] === 'fixed_cart') {
                //     $coupon_value = $check_coupon_code['amount'];
                //     $this->coupon = $check_coupon_code['amount'];
                //     $this->coupon_currency_icon = '€';
                // } 
                // if($check_coupon_code['discount_type'] === 'percentage') {
                //     $coupon_value = 0;
                //     $this->coupon = $check_coupon_code['percent'];
                //     $this->coupon_currency_icon = '%';
                // }

                $coupon_value = $check_coupon_code['amount'];

                $coupon_data = array('coupon' => $coupon_value);
                $coupon_data = array('coupon_currency_icon' => '€');
                $coupon_code = array('coupon_code' => $coupon_code);
                $discount_type = array('discount_type' => $check_coupon_code['discount_type']);
                $discount_amount = array('discount_amount' => $coupon_value);
                $discount_percent = array('percent' => $coupon_value);

                $this->session->set_userdata($coupon_data);
                $this->session->set_userdata($coupon_code);
                $this->session->set_userdata($discount_amount);
                $this->session->set_userdata($discount_percent);
                $this->session->set_userdata($discount_type);

                //coupon codu var ise extra indirimleri sil
                $this->session->set_userdata('discount_amount', '0.00');

                if ($check_coupon_code['status'] === "Passive") {
                    exit(json_encode(array(
                        "csrf_fg" => $csrf_fg,
                        "responseMessage" => "Coupon Passive!",
                        "statusCode" => 100
                    )));
                } elseif (date('Y-m-d') > $check_coupon_code['valid_date_to'] || date('Y-m-d') < $check_coupon_code['valid_date_from']) {
                    exit(json_encode(array(
                        "responseMessage" => "Expired!",
                        "statusCode" => 101
                    )));
                } elseif ($check_coupon_code['current_limit'] > $check_coupon_code['max_limit']) {
                    exit(json_encode(array(
                        "responseMessage" => "Inadequate limit!",
                        "statusCode" => 102
                    )));
                } else {
                    $this->session->set_userdata('coupon', $check_coupon_code['amount']);
                    exit(json_encode(array(
                        "cart_subtotal" => number_format($this->subtotal(), 2) . " " . $this->currency_icon,
                        "cart_total" => number_format(($this->total() - $coupon_value) + $this->shipping_total(), 2) . " " . $this->currency_icon,
                        "cart_proportion" => number_format($this->proportion(), 2) . " " . $this->currency_icon,
                        "cart_coupon" => number_format($coupon_value, 2) . " " . $this->currency_icon,
                        "responseMessage" => "valid code",
                        "shipping" => $this->shipping_total(),
                        "statusCode" => 200
                    )));
                }
            } else {
                exit(json_encode(array(
                    "csrf_fg" => $csrf_fg,
                    "responseMessage" => "Coupon not found!",
                    "statusCode" => 404
                )));
            }
        } else {
            $error = 'Bad request!';
            redirect(base_url(), 'refresh');
        }
    }

    public function coupon_calculator()
    {
        // echo $this->session->userdata('discount_type'); //yüzde icin extra hesaplama yapilacak

        if ($this->session->userdata('coupon')) {
            $coupon = ($this->cart->total() - $this->session->userdata('coupon'));
            $tax = $coupon - ($coupon / 1.19);
        } else {
            $tax = $this->cart->total() - ($this->cart->total() / 1.19);
        }
        return $tax;
    }

    public function remove()
    {
        $error = '';
        $success = '';

        if ($this->input->is_ajax_request() && $this->input->method() == 'post') {

            if ($this->input->post('rowid')) {

                $data = array(
                    'rowid' => $this->input->post('rowid'),
                    'qty'   => 0
                );

                $this->cart->update($data);

                $success = 'Item has been removed!';

                $shipping_total = $this->shipping_total();

                exit(json_encode(array(
                    "cart_item_amounts" => $this->cart->total_items(),
                    "cart_subtotal" => number_format($this->subtotal(), 2) . " " . $this->currency_icon,
                    "cart_total" => $this->coupon ? number_format(($this->total() - $this->coupon) + $shipping_total, 2) . " " . $this->currency_icon : number_format($this->total() + $shipping_total, 2) . " " . $this->currency_icon,
                    // "cart_total" => $this->coupon ? number_format(($this->total() - $this->coupon) + $shipping, 2) . " " . $this->currency_icon : number_format($this->total(), 2) . " " . $this->currency_icon,
                    "cart_proportion" => number_format($this->proportion(), 2) . " " . $this->currency_icon,
                    "cart_coupon" => number_format($this->coupon, 2) . " " . $this->currency_icon,
                    "responseMessage" => $success,
                    "shipping_total" => $shipping_total,
                    "statusCode" => 200
                )));
            } else {
                exit(json_encode(array("responseMessage" => "Product not found!",)));
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function check_gift_product_no_price()
    {
        //Geschenk Poster Einzel 20x30 cm Poster 0.00 birden fazla eklenmesin
        foreach ($this->cart->contents() as $item) {
            if ($item['id'] == 220) {
                $data = array(
                    'rowid' => $item['rowid'],
                    'qty'   => 1
                );
                $this->cart->update($data);
            }
        }
    }

    public function check_gift_product($id)
    {
        //upgrade urunleri icin
        if (in_array($id, [221, 222, 223, 224, 225])) {
            // enginin actigi activation hediye urunu upgrade yapilmissa sil mit versandkosten
            foreach ($this->cart->contents() as $item) {
                if ($item['id'] == 220) {
                    $data = array(
                        'rowid' => $item['rowid'],
                        'qty'   => 0
                    );
                    $this->cart->update($data);
                }
            }
        }

        // geschenk olan urun geldiyse diger urunleri sessiondan kaldiriyoruz
        foreach ($this->cart->contents() as $item) {
            if ($item['id'] === 220) {
                // $qty = in_array($item['id'], [221, 222, 223, 224, 225]) ? 0 : 1;

                $data = array(
                    'rowid' => $item['rowid'],
                    'qty'   => 1
                );
                $this->cart->update($data);
            }
        }

        $this->shipping_total();
    }

    public function check_confirm_upgrade_clear($item_id_old)
    {
        foreach ($this->cart->contents() as $item) {
            if ($item['item_id_old'] == $item_id_old) {
                $product_data = array(
                    "rowid" => $item['rowid'],
                    "qty" => 0
                );
                $this->cart->update($product_data);
            }
        }
    }

    public function discount($order_number, $item_id_old)
    {
        $check_order = $this->Model_order->get_order($order_number);

        if ($check_order['paid'] === 'isPaid') {
            $check_order_item = $this->Model_order->check_order_item_single($order_number, $item_id_old);
            if ($check_order_item) {
                // $this->session->set_userdata('discount', $this->session->userdata('discount') + $check_order_item['item_price']);
                $this->discount_item = $check_order_item['item_price'];
            }
        }
    }
}
