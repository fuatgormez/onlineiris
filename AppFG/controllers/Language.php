<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Language extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model_common');
        // $this->load->model('Model_language');
        //$this->output->cache(60);

        $this->load->library('cart');

    }

    public function index()
    {
        return redirect(base_url());
    }

    public function site($data)
    {
        // $langs = ['de','tr','nl','be','fr','en','dk','at'];
        // if (in_array($data, ['de','tr','nl','be','fr','en','dk','at'])) {

        if ($data) {
            $lang_code = array(
                'site_language' => $data
            );

        } else {
            $lang_code = array(
                'site_language' => 'en'
            );
        }

        $this->session->set_userdata($lang_code);

        redirect(base_url('shop'));
        // redirect($this->agent->referrer());

    }
    
    public function change($data)
    {
        $check_lang = $this->Model_common->get_all_store_lang_check($data);
        if ($check_lang) {
            $lang_code = array(
                'store_language' => $check_lang['lang_code']
            );

        } else {
            $lang_code = array(
                'store_language' => 'de'
            );
        }

        $this->session->set_userdata($lang_code);

        $this->cart->destroy();

        redirect(base_url('shop'));
        // redirect($this->agent->referrer());

    }

    public function select_store($store_id, $par = '')
    {
        $error = '';
        $this->cart->destroy();

        try {
            if (intval($store_id)) {

                $check_lang = $this->Model_common->store_check($store_id);

                if ($check_lang != NULL) {
                    $array = array(
                        'store_id' => $check_lang['id'],
                        'store_name' => $check_lang['store_name'],
                        'land_id' => $check_lang['land_id'],
                        'land_name' => $check_lang['land_name'],
                        'store_language' => $check_lang['lang_code'],
                        'store_flag' => $check_lang['lang_flag'],
                        'site_language' => $check_lang['lang_code'],
                        'currency_code' => $check_lang['currency_code'],
                        'currency_icon' => $check_lang['currency_icon'],
                        'tax' => $check_lang['tax']
                    );

                    $this->session->set_userdata($array);

                    redirect(base_url(!empty($par) ? 'shop/coupon/activation' : 'shop'));
                } else {
                    redirect(base_url());
                }
            } else {
                redirect(base_url('home'));
            }
        } catch (Exception $e) {
            redirect(base_url());
        }
    }
}
