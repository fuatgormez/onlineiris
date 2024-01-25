<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Sitemap extends CI_Controller
{

    private $all_service;
    private $store_lang_data;
    private $land_id;
    private $store_id;
    private $products;
    private $product_categories;

    function __construct()
    {
        parent::__construct();

        $this->load->model('Model_sitemap');
        $this->load->model('shop/Model_shopping_cart');
        
        $this->load->library('slug');
        $this->load->library('set_store_url');
        $this->lang->load('file', $this->session->userdata('site_language') ?? $this->session->userdata('store_language'));

        $this->store_lang_data =  $this->session->userdata('store_language');
        $this->land_id =  $this->session->userdata('land_id');
        $this->store_id =  $this->session->userdata('store_id');

        $this->products = $this->Model_shopping_cart->all_product($this->store_lang_data, $this->land_id);
        $this->product_categories = $this->Model_shopping_cart->all_product_category($this->store_lang_data);
        print_r($this->products);
        exit;

    }

    public function index()
    {
        echo "sitemaps";
    }

    public function xml()
    {
        // $this->Model_sitemap->add(base_url(), date('Y-m-d', time()), 'monthly', 1);
        // $this->Model_sitemap->add(base_url().'about', date('Y-m-d', time()), 'monthly', 0.5);
        // $this->Model_sitemap->add(base_url().'photo-gallery', date('Y-m-d', time()), 'monthly', 1);
        // $this->Model_sitemap->add(base_url().'impressum', date('Y-m-d', time()), 'monthly', 0.5);
        // $this->Model_sitemap->add(base_url().'datenschutz', date('Y-m-d', time()), 'monthly', 0.5);
        // $this->Model_sitemap->add(base_url().'faq', date('Y-m-d', time()), 'monthly', 1);
        // $this->Model_sitemap->add(base_url().'contact', date('Y-m-d', time()), 'monthly', 0.5);
        // $this->Model_sitemap->add(base_url().'service', date('Y-m-d', time()), 'monthly', 1);

        $date = date('c',time());

        // print_r($this->products);exit;
        foreach ($this->product_categories as $product_category) {
            foreach ($this->products as $product) {
                $this->Model_sitemap->add(base_url('product/'.$this->slug->url($product_category['category_name']).'/'.$this->slug->url($product['product_name']).'/'. $product['id']), $date, 'monthly', 1);
            }
        }

        $this->Model_sitemap->output('sitemapindex');
    }


}