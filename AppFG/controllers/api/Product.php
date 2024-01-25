<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
      	$this->load->model('Model_common');
      	$this->load->model('api/Model_shop');
	}

	public function index()
	{
		exit('access denied');
	}

	public function all_product($land_id, $lang)
	{
		exit(json_encode($this->Model_shop->all_product($land_id, $lang)));
	}
	
	public function display_xml($land_id = 16, $lang_code = "de")
    {
        header("Content-type: text/xml");

        $this->load->dbutil();
        $this->output->set_content_type('text/xml');
        
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        // create root element
        $root = $dom->createElement("aaa");
        $root = $dom->createElement("rss");

        // $result = $dom->createElement('result');
        
        // $root = $dom->createElement("channel");
        $root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:g', base_url());
        $dom->appendChild($root);
        
        $root->appendChild($dom->createElement('result'));


        // create child element

        $title = $dom->createElement("title");
        $root->appendChild($title);

        $titleText = $dom->createTextNode("IRISPICTURE");
        $title->appendChild($titleText);

        $link = $dom->createElement("link");
        $root->appendChild($link);

        $linkText = $dom->createTextNode(base_url());
        $link->appendChild($linkText);

        $description = $dom->createElement("description");
        $root->appendChild($description);

        $descriptionText = $dom->createTextNode("Dein IRIS, Dein FOTO");
        $description->appendChild($descriptionText);

        $products = $this->Model_shop->xml_all_product($land_id, $lang_code);

        foreach ($products as $product) {

            //items
            $item = $dom->createElement("item");
            $root->appendChild($item);

            $gid = $dom->createElement("g:id", $product['product_id']);
            $item->appendChild($gid);

            $gtitle = $dom->createElement("g:title", $product['category_name'] . ' ' . $product['product_name']);
            $item->appendChild($gtitle);

            // $gdescription = $dom->createElement("g:description", html_entity_decode($product['content']));
            // $gdescription = $dom->createElement("g:description", $product['description'] ? $product['description'] : " ");
            $gdescription = $dom->createElement("g:description", $product['description'] ? $product['description'] : " ");
            $item->appendChild($gdescription);

            $glink = $dom->createElement("g:link", base_url('shop/product/detail/' . $product['id']));
            $item->appendChild($glink);

            $gimagelink = $dom->createElement("g:image_link", base_url('public/uploads/product_photos/thumbnail/' . $product['thumbnail']));
            $item->appendChild($gimagelink);

            $gavailability = $dom->createElement("g:availability", $product['product_price'] > 0 ? "in stock" : "out of stock");
            $item->appendChild($gavailability);

            $gprice = $dom->createElement("g:price", $product['product_price'] . " EUR");
            $item->appendChild($gprice);

            // $ggtin = $dom->createElement("g:gtin", $product['id'].$product['product_id'].$product['category_id'].$product['product_lang_id'].$product['land_id']);
            // $item->appendChild($ggtin);

            $gmpn = $dom->createElement("g:mpn", $product['product_id']);
            $item->appendChild($gmpn);

            $gbrand = $dom->createElement("g:brand", "IRISPICTURE");
            $item->appendChild($gbrand);

            $gcondition = $dom->createElement("g:condition", "new");
            $item->appendChild($gcondition);

            $gproduct_category = $dom->createElement("g:product_category", $product['category_name']);
            $item->appendChild($gproduct_category);
        }

        // save and display tree
        // $dom->save('sitemap.xml');
        print_r($dom->saveXML());
    }

    public function xml()
    {
        // Send the headers
        header("Content-type: text/xml");
        $this->load->dbutil();
        $this->output->set_content_type('text/xml');

        $this->load->library('set_store_url');
        $this->load->library('slug');
        
        $data['products'] = $this->Model_shop->xml_all_product($this->session->userdata('land_id'), $this->session->userdata('store_language'));
        $this->load->view('view_product_xml',$data);
        
    }

    public function get_single($product_id)
    {
        $product = $this->Model_shop->single_product($product_id);
        if($product) {
            exit(json_encode(array('status' => 200, 'price' => $product['product_price_old'],'category_id' => $product['category_id'] )));
        } else {
            exit(json_encode(array('status' => 404)));
        }
    }
}
