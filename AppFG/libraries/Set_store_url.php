<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Set_store_url
{
    public $store;
    private $_CI;
    function __construct()
    {
        $this->_CI = &get_instance();
        $this->_CI->load->model('Model_common');

        if (base_url() === 'https://www.irispicture.com/' || base_url() === 'https://www.youririsfoto.com/') {
			$check_lang = $this->_CI->Model_common->store_check($this->_CI->session->userdata('store_id') ?: 14);
			if ($check_lang != NULL) {
				$array = array(
					'store_id' => $check_lang['id'],
					'store_name' => $check_lang['store_name'],
					'land_id' => $check_lang['land_id'],
					'land_name' => $check_lang['land_name'],
					'store_language' => $check_lang['lang_code'],
					'store_flag' => $check_lang['lang_flag'],
					// 'site_language' => $check_lang['lang_code'],
					'currency_code' => $check_lang['currency_code'],
					'currency_icon' => $check_lang['currency_icon'],
					'tax' => $check_lang['tax']
				);
				$this->_CI->session->set_userdata($array);
			}

        } else if (base_url() === 'https://irispicture.ch/') {
			$check_lang = $this->_CI->Model_common->store_check($this->_CI->session->userdata('store_id') ?: 1);
			if ($check_lang != NULL) {
				$array = array(
					'store_id' => $check_lang['id'],
					'store_name' => $check_lang['store_name'],
					'land_id' => $check_lang['land_id'],
					'land_name' => $check_lang['land_name'],
					'store_language' => $check_lang['lang_code'],
					'store_flag' => $check_lang['lang_flag'],
					// 'site_language' => $check_lang['lang_code'],
					'currency_code' => $check_lang['currency_code'],
					'currency_icon' => $check_lang['currency_icon'],
					'tax' => $check_lang['tax']
				);
				$this->_CI->session->set_userdata($array);
			}
        } else if (base_url() === 'https://www.fuatgormez.tech/irispicture/') {
			$check_lang = $this->_CI->Model_common->store_check($this->_CI->session->userdata('store_id') ?: 14);
			if ($check_lang != NULL) {
				$array = array(
					'store_id' => $check_lang['id'],
					'store_name' => $check_lang['store_name'],
					'land_id' => $check_lang['land_id'],
					'land_name' => $check_lang['land_name'],
					'store_language' => $check_lang['lang_code'],
					'store_flag' => $check_lang['lang_flag'],
					// 'site_language' => $check_lang['lang_code'],
					'currency_code' => $check_lang['currency_code'],
					'currency_icon' => $check_lang['currency_icon'],
					'tax' => $check_lang['tax']
				);
				$this->_CI->session->set_userdata($array);
			}
        } else if (base_url() === 'https://www.youririsfoto.be/') {
			$check_lang = $this->_CI->Model_common->store_check($this->_CI->session->userdata('store_id') ?: 68);
			if ($check_lang != NULL) {
				$array = array(
					'store_id' => $check_lang['id'],
					'store_name' => $check_lang['store_name'],
					'land_id' => $check_lang['land_id'],
					'land_name' => $check_lang['land_name'],
					'store_language' => $check_lang['lang_code'],
					'store_flag' => $check_lang['lang_flag'],
					// 'site_language' => $check_lang['lang_code'],
					'currency_code' => $check_lang['currency_code'],
					'currency_icon' => $check_lang['currency_icon'],
					'tax' => $check_lang['tax']
				);
				$this->_CI->session->set_userdata($array);
			}
        } else if (base_url() === 'https://www.youririsfoto.fr/') {//bu ayarlanmadi ayarla bunu be ayarlandi gecici olarak store eklenmemis
            $check_lang = $this->_CI->Model_common->store_check($this->_CI->session->userdata('store_id') ?: 68);
			if ($check_lang != NULL) {
				$array = array(
					'store_id' => $check_lang['id'],
					'store_name' => $check_lang['store_name'],
					'land_id' => $check_lang['land_id'],
					'land_name' => $check_lang['land_name'],
					'store_language' => $check_lang['lang_code'],
					'store_flag' => $check_lang['lang_flag'],
					// 'site_language' => $check_lang['lang_code'],
					'currency_code' => $check_lang['currency_code'],
					'currency_icon' => $check_lang['currency_icon'],
					'tax' => $check_lang['tax']
				);
				$this->_CI->session->set_userdata($array);
			}
        } else if (base_url() === 'https://www.youririsfoto.nl/') {
			$check_lang = $this->_CI->Model_common->store_check($this->_CI->session->userdata('store_id') ?: 80);
			if ($check_lang != NULL) {
				$array = array(
					'store_id' => $check_lang['id'],
					'store_name' => $check_lang['store_name'],
					'land_id' => $check_lang['land_id'],
					'land_name' => $check_lang['land_name'],
					'store_language' => $check_lang['lang_code'],
					'store_flag' => $check_lang['lang_flag'],
					// 'site_language' => $check_lang['lang_code'],
					'currency_code' => $check_lang['currency_code'],
					'currency_icon' => $check_lang['currency_icon'],
					'tax' => $check_lang['tax']
				);
				$this->_CI->session->set_userdata($array);
			}
        } else {
			$check_lang = $this->_CI->Model_common->store_check($this->_CI->session->userdata('store_id') ?: 14);
			if ($check_lang != NULL) {
				$array = array(
					'store_id' => $check_lang['id'],
					'store_name' => $check_lang['store_name'],
					'land_id' => $check_lang['land_id'],
					'land_name' => $check_lang['land_name'],
					'store_language' => $check_lang['lang_code'],
					'store_flag' => $check_lang['lang_flag'],
					// 'site_language' => $check_lang['lang_code'],
					'currency_code' => $check_lang['currency_code'],
					'currency_icon' => $check_lang['currency_icon'],
					'tax' => $check_lang['tax']
				);
				$this->_CI->session->set_userdata($array);
			}
		}
    }

    
    
}
