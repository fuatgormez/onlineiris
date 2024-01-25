<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cookie extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model_common');

        //        $this->output->cache(60);
        // $this->lang->load('file', $this->session->userdata('site_language') ?? 'de');
    }

    public function index()
    {
        // redirect(base_url());
    }

    public function ed8b172ad0e4433f9868511b6c91a76726702082()
    {
        $error = '';

        

        $this->load->helper('cookie');
        if (isset($_POST['form1'])) {

            $valid = 1;

            $this->form_validation->set_rules('required_cookie', 'Cookie', 'trim|integer|xss_clean');
            $this->form_validation->set_rules('google_analytics_term', 'Google Analytics Term', 'trim|integer|xss_clean');
            $this->form_validation->set_rules('facebook_tracking_term', 'Facebook Tracking Term', 'trim|integer|xss_clean');
            $this->form_validation->set_rules('affiliate_marketing_term', 'Affiliate Marketing Term', 'trim|integer|xss_clean');
            $this->form_validation->set_rules('youtube_term', 'Youtube Term', 'trim|integer|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $valid = 0;
                $error .= validation_errors();
            }

            $required_cookie = $this->input->post('required_cookie');
            $google_analytics_term = $this->input->post('google_analytics_term');
            $facebook_tracking_term = $this->input->post('facebook_tracking_term');
            $affiliate_marketing_term = $this->input->post('affiliate_marketing_term');
            $youtube_term = $this->input->post('youtube_term');

            if ($valid == 1) {

                $required_cookie = array(
                    'name'   => 'required_cookie',
                    'value'  => 'enabled',
                    'expire' => '31536000',
                    'path'   => '/'
                );
                $this->input->set_cookie($required_cookie);

                if (isset($google_analytics_term) && $google_analytics_term == 1) {
                    $google_analytics_term = array(
                        'name'   => 'google_analytics_term',
                        'value'  => 'enabled',
                        'expire' => '31536000',
                        'path'   => '/'
                    );
                    $this->input->set_cookie($google_analytics_term);
                } else {
                    delete_cookie('google_analytics_term');
                }

                if (isset($facebook_tracking_term) && $facebook_tracking_term == 1) {
                    $facebook_tracking_term = array(
                        'name'   => 'facebook_tracking_term',
                        'value'  => 'enabled',
                        'expire' => '31536000',
                        'path'   => '/'
                    );
                    $this->input->set_cookie($facebook_tracking_term);
                } else {
                    delete_cookie('facebook_tracking_term');
                }

                if (isset($affiliate_marketing_term) && $affiliate_marketing_term == 1) {
                    $affiliate_marketing_term = array(
                        'name'   => 'affiliate_marketing_term',
                        'value'  => 'enabled',
                        'expire' => '31536000',
                        'path'   => '/'
                    );
                    $this->input->set_cookie($affiliate_marketing_term);
                } else {
                    delete_cookie('affiliate_marketing_term');
                }

                if (isset($youtube_term) && $youtube_term == 1) {
                    $youtube_term = array(
                        'name'   => 'youtube_term',
                        'value'  => 'enabled',
                        'expire' => '31536000',
                        'path'   => '/'
                    );
                    $this->input->set_cookie($youtube_term);
                } else {
                    delete_cookie('youtube_term');
                }
            }
        } else {
            $required_cookie = array(
                'name'   => 'required_cookie',
                'value'  => 'enabled',
                'expire' => '31536000',
                'path'   => '/'
            );
            $this->input->set_cookie($required_cookie);
            
            $google_analytics_term = array(
                'name'   => 'google_analytics_term',
                'value'  => 'enabled',
                'expire' => '31536000',
                'path'   => '/'
            );
            $this->input->set_cookie($google_analytics_term);

            $facebook_tracking_term = array(
                'name'   => 'facebook_tracking_term',
                'value'  => 'enabled',
                'expire' => '31536000',
                'path'   => '/'
            );
            $this->input->set_cookie($facebook_tracking_term);

            $affiliate_marketing_term = array(
                'name'   => 'affiliate_marketing_term',
                'value'  => 'enabled',
                'expire' => '31536000',
                'path'   => '/'
            );
            $this->input->set_cookie($affiliate_marketing_term);

            $youtube_term = array(
                'name'   => 'youtube_term',
                'value'  => 'enabled',
                'expire' => '31536000',
                'path'   => '/'
            );
            $this->input->set_cookie($youtube_term);
        }

        redirect($this->agent->referrer());

        //         sha1('fuat') ed8b172ad0e4433f9868511b6c91a76726702082

    }
}
