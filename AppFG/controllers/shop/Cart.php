<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart extends CI_Controller
{
    protected $langCart;
    protected $currency_icon;
    protected $currency_code;
    protected $coupon;
    protected $coupon_currency_icon;
    protected $gift_card;
    protected $shipping;
    protected $discount;
    protected $discount_item;

    function __construct()
    {
        parent::__construct();

        /**
         * fake ürün icin olusturulan coupon codunu kullanmissa normal ürünleri goremesin 
         */
        // if($this->session->userdata('confirm_for_upgrade'))
        // redirect(base_url('shop/coupon/product'));

        $this->load->model('Model_common');
        $this->load->model('Model_service');
        $this->load->model('shop/Model_shopping_cart');
        $this->load->model('shop/Model_order');

        if ($this->input->post('order_number')) {
            if (empty($this->session->userdata('store_language'))) {
                $check_order = $this->Model_order->check_order($this->input->post('order_number'));
                if ($check_order) {
                    $this->session->set_userdata('store_language', $check_order->store_lang_code);
                    $this->session->set_userdata('currency_icon', $check_order->store_currency_icon);
                    $this->session->set_userdata('currency_code', $check_order->store_currency_code);
                    $this->session->set_userdata('land_name', $check_order->land_name);
                    $this->session->set_userdata('store_name', $check_order->store_name);
                }
            }
        } else {
            $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url()) : $this->session->userdata('store_language');
        }


        $this->load->library('cart');
        $this->load->library('facebook_pixel');


        $this->lang->load('file', $this->session->userdata('site_language') ?? $this->session->userdata('store_language'));

        //Language set to default German -> lang_code = 'de'
        $this->langCart = $this->session->userdata('store_language');
        $this->currency_icon = $this->session->userdata('currency_icon');
        $this->currency_code = $this->session->userdata('currency_code');
        $this->coupon = $this->session->userdata('coupon');
        $this->coupon_currency_icon = $this->session->userdata('coupon_currency_icon');
        // $this->discount = $this->session->userdata('discount');

        // $this->cart->destroy();
        // print_r($this->cart->contents());exit;
        // exit($this->session->userdata('discount_amount'));

        // echo $this->session->userdata('discount');exit;
    }

    public function index()
    {

        if (empty($this->cart->contents())) {
            redirect(base_url('shop'));
            return;
        }

        $data['setting'] = $this->Model_common->all_setting();
        $data['page_home'] = $this->Model_common->all_page_home();
        $data['social'] = $this->Model_common->all_social();
        $data['services'] = $this->Model_service->all_service();

        $data['stores'] = $this->Model_common->get_all_store();
        $data['store_langs'] = $this->Model_common->get_all_store_value();


        $data['products'] = $this->cart->contents();
        //$data['product'] = $this->Model_shopping_cart->all_product();

        $data['description'] = 'Shopping Cart';

        $data['value'] = $this->cart->total();
        $data['pixel_id'] = $this->Model_common->all_setting()['facebook_init'];

        $data['theme'] = $data['setting']['layout'];

        //Rabatt hesaplaniyor cart sayfasina direkt ve ilk kez geliyorsa
        $this->discount_calc();


        $this->load->view('layout/' . $data['setting']['layout'] . '/view_header', $data);
        if ($data['setting']['website_status_frontend'] === 'Active' || in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) {
            // $this->load->view('facebook/view_fb_add_to_cart',$data);
            $this->load->view('layout/' . $data['setting']['layout'] . '/shop/view_cart', $data);
        } else {
            $this->load->view('view_maintenance', $data);
        }
        $this->load->view('layout/' . $data['setting']['layout'] . '/view_footer', $data);
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

                $product_check = $this->Model_shopping_cart->product_check($this->input->post('product_id'), $this->langCart);

                if ($valid == 1) {
                    if ($product_check) {

                        $product_data = array(
                            "id" => $product_check["id"],
                            "item_id_old" => $this->input->post("info") === "update" ? $this->input->post("item_id_old") : "",
                            "name" => $product_check["category_name"] . " " . $product_check["product_name"],
                            "price" => number_format($product_check["product_price"], 2),
                            "qty" => 1,
                            "eye_qty" => $product_check["eye_quantity"],
                            "image" => $product_check["thumbnail"],
                            "currency_icon" => $this->currency_icon,
                            "currency_code" => $this->currency_code,
                            "lang_code" => $this->langCart,
                            "product_type" => $product_check["product_type"],
                            "metadata" => [
                                "order_number" => $this->input->post("order_number"),
                                "order_type" => $this->input->post("info") === "update" ? "update" : "",
                                "item_type" => !empty($this->input->post("item_id_old")) ? 'update' : "",
                                "discount" => number_format($this->discount_item, 2)
                            ]
                        );

                        $this->cart->product_name_rules = '[:print:]';
                        $this->cart->insert($product_data);
                        //git test

                        //qty fazla gelirse tekrardan kontrol edip miktari 1 e set ediyoruz buraya sonradan tekrar bak
                        $this->check_gift_product_no_price();

                        $success = $this->lang->line('cart_popup_success_title');


                        exit(json_encode(array(
                            "cart_contents" => $this->cart->contents(),
                            "cart_item_amounts" => $this->cart->total_items(),
                            "cart_total" => number_format(($this->cart->total() + $this->shipping_total()) - $this->discount, 2) . " " . $this->currency_icon,
                            "cart_discount" => number_format($this->discount, 2)  . " " . $this->currency_icon,
                            "shipping_total" => $this->shipping_total()  . " " . $this->currency_icon,
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
            $error = 'Bad request!';
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

            $product_check = $this->Model_shopping_cart->product_check($this->input->post('product_id'), $this->langCart);

            if ($valid == 1) {
                if ($product_check) {

                    $this->discount_calc();
                    $this->check_gift_product($this->input->post('product_id'));

                    $product_data = array(
                        "rowid" => $this->input->post('rowid'),
                        "qty" => $this->input->post('qty'),
                        "product_price" => number_format($product_check['product_price'], 2),
                        "product_total" => number_format($this->input->post('qty') * $product_check['product_price'], 2) . " " . $this->currency_icon
                    );
                    $this->cart->update($product_data);

                    //qty fazla gelirse tekrardan kontrol edip miktari 1 e set ediyoruz buraya sonradan tekrar bak (cart insert or update den sonra gelmeli)
                    $this->check_gift_product_no_price();

                    $shipping_total = $this->shipping_total();

                    exit(json_encode(array(
                        "cart_contents" => $this->cart->contents(),
                        "cart_item_amounts" => $this->cart->total_items(),
                        "cart_subtotal" => number_format($this->subtotal(), 2) . " " . $this->currency_icon,
                        "cart_total" => $this->coupon ? number_format(($this->total() - $this->coupon) + $shipping_total, 2) . " " . $this->currency_icon : number_format(($this->total() - $this->discount) + $shipping_total, 2) . " " . $this->currency_icon,
                        "cart_proportion" => number_format($this->proportion(), 2) . " " . $this->currency_icon,
                        "cart_coupon" => number_format($this->coupon, 2) . " " . $this->currency_icon,
                        "cart_discount" => number_format($this->discount, 2)  . " " . $this->currency_icon,
                        "shipping_total" => $shipping_total  . " " . $this->currency_icon,
                        "product" => $product_data,
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
            "cart_total" => number_format(($this->cart->total() + $this->shipping_total()) - $this->discount, 2) . " " . $this->currency_icon,
            "cart_discount" => number_format($this->discount, 2)  . " " . $this->currency_icon,
            "shipping_total" => $this->shipping_total()  . " " . $this->currency_icon,
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
        $this->session->set_userdata('shipping_total', number_format(0.00, 2));
        $this->shipping = $this->session->userdata('shipping_total');

        foreach ($this->cart->contents() as $item) {
            if ($item['id'] == 220) {
                $this->session->set_userdata('shipping_total', number_format(2.90, 2));
                $this->shipping = $this->session->userdata('shipping_total');
            }
        }
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

    public function check_confirm_upgrade_qty($rowid)
    {
        $check_order_number = false;
        foreach ($this->cart->contents() as $item) {
            if ($item['rowid'] == $rowid) {
                //upgrade yapilan urunu kontrol ediyoruz birden fazla eklenmesine izin vermiyoruz
                if (!empty($item['metadata']['order_number'] || $item['metadata']['order_number'] != NULL)) {
                    $check_order_number = true;
                    return true;
                }
            }
        }
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

    public function discount_calc()
    {
        $discount_amount = 0;
        foreach ($this->cart->contents() as $item) {
            $discount_amount += $item['metadata']['discount'];
        }
        $this->discount = $discount_amount;
        $this->session->set_userdata('discount_amount', $this->discount);
    }
}
