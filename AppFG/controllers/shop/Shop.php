<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        /**
         * fake ürün icin olusturulan coupon codunu kullanmissa normal ürünleri goremesin 
         */
        // if($this->session->userdata('coupon_for_upgrade'))
        //     redirect(base_url('shop/coupon/product'));
        $this->load->model('Model_common');
        $this->load->model('Model_service');
        $this->load->model('shop/Model_shopping_cart');

        // $this->output->cache(60);
        $this->load->library('cart');
		$this->load->library('set_store_url');
		$this->load->library('slug');
		$this->load->library('facebook_pixel');
		
        // $this->lang->load('file', $this->session->userdata('site_language') ?? $this->session->userdata('store_language'));
        $this->lang->load('file', $this->session->userdata('site_language') ?? 'en');

        // if(!in_array($this->session->userdata('id'),[1]))
        //     redirect(base_url());
    }

    public function index()
    {
        $data['setting'] = $this->Model_common->all_setting();
        $data['page_home'] = $this->Model_common->all_page_home();
        $data['page_about'] = $this->Model_common->all_page_about();
        $data['comment'] = $this->Model_common->all_comment();
        $data['social'] = $this->Model_common->all_social();

        //$check_category     = $this->Model_shopping_cart->all_product_category($store_lang_data);
        //$check_products     = $this->Model_shopping_cart->all_product($store_lang_data);

        $land_id = empty($this->session->userdata('land_id')) ? redirect(base_url('select_land')) : $this->session->userdata('land_id') ;
        $store_id = empty($this->session->userdata('store_id')) ? redirect(base_url('select_land')) : $this->session->userdata('store_id') ;
        $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url('select_land')) : $this->session->userdata('store_language') ;
        // $store_currency_icon = empty($this->session->userdata('currency_icon')) ? redirect(base_url()) : $this->session->userdata('currency_icon') ;
        // $store_currency_code = empty($this->session->userdata('currency_code')) ? redirect(base_url()) : $this->session->userdata('currency_code') ;

        //$data['product'] = $this->Model_shopping_cart->single_product($store_lang_data);
        // $data['products'] = $this->Model_shopping_cart->all_product($store_lang_data,$store_id);
        // $data['product_categories'] = $this->Model_shopping_cart->all_product_category($store_lang_data,$store_id);
		
        $data['product_categories'] = $this->Model_shopping_cart->all_product_category($store_lang_data);
        $data['product_category_photo'] = $this->Model_shopping_cart->all_product_category_photo();

        $data['services'] = $this->Model_service->all_service();

        $data['stores'] = $this->Model_common->get_all_store();
        $data['store_langs'] = $this->Model_common->get_all_store_value();

        $data['slug'] = $this->slug;
        $data['theme'] = $data['setting']['layout'];

        $this->load->view('layout/'.$data['setting']['layout'].'/view_header',$data);
        if($data['setting']['website_status_frontend'] === 'Active' || in_array($this->session->userdata('role'), ['Superadmin','Admin']))
        {
            // $this->load->view('facebook/view_fb_view_content', $data, TRUE);
            $this->load->view('layout/'.$data['setting']['layout'].'/shop/view_shop',$data);
        } else {
            $this->load->view('view_maintenance', $data);
        }
        $this->load->view('layout/'.$data['setting']['layout'].'/view_footer',$data);
    }
}