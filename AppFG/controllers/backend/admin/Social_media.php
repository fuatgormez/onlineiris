<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Social_media extends CI_Controller 
{
	function __construct() 
	{
		parent::__construct();
		if(!$this->session->userdata('id')) {
            redirect(base_url().'backend/admin/login');
            exit;
		}
		
        $this->load->model('backend/admin/Model_common');
        $this->load->model('backend/admin/Model_social_media');

		$data['setting'] = $this->Model_common->get_setting_data();

		if (!in_array($this->session->userdata('role'), ['Superadmin'])) {
			if ($data['setting']['website_status_backend'] === "Passive") {
				$data['message'] = $data['setting']['website_status_backend_message'];
				redirect(base_url('backend/info'));
			}
		}
    }

	public function index()
	{
       	
       	$data['setting'] = $this->Model_common->get_setting_data();
		$error = '';
		$success = '';

		if(isset($_POST['form1']))
		{
			$this->Model_social_media->update('Facebook',array('social_url'    => $this->input->post('facebook')));
			$this->Model_social_media->update('Twitter',array('social_url'     => $this->input->post('twitter')));
			$this->Model_social_media->update('LinkedIn',array('social_url'    => $this->input->post('linkedin')));
			$this->Model_social_media->update('Google Plus',array('social_url' => $this->input->post('googleplus')));
			$this->Model_social_media->update('Pinterest',array('social_url'   => $this->input->post('pinterest')));
			$this->Model_social_media->update('Youtube',array('social_url'     => $this->input->post('youtube')));
			$this->Model_social_media->update('Instagram',array('social_url'   => $this->input->post('instagram')));
			$this->Model_social_media->update('Tumblr',array('social_url'      => $this->input->post('tumblr')));
			$this->Model_social_media->update('Flickr',array('social_url'      => $this->input->post('flickr')));
			$this->Model_social_media->update('Reddit',array('social_url'      => $this->input->post('reddit')));
			$this->Model_social_media->update('Snapchat',array('social_url'    => $this->input->post('snapchat')));
			$this->Model_social_media->update('WhatsApp',array('social_url'    => $this->input->post('whatsapp')));
			$this->Model_social_media->update('Quora',array('social_url'       => $this->input->post('quora')));
			$this->Model_social_media->update('StumbleUpon',array('social_url' => $this->input->post('stumbleupon')));
			$this->Model_social_media->update('Delicious',array('social_url'   => $this->input->post('delicious')));
			$this->Model_social_media->update('Digg',array('social_url'        => $this->input->post('digg')));

		
			$success = 'Social Media is updated successfully';
		    
			$this->session->set_flashdata('success',$success);
			redirect(base_url().'backend/admin/social_media');
           
		} else {
			$data['social'] = $this->Model_social_media->show();
	       	$this->load->view('backend/admin/view_header',$data);
			$this->load->view('backend/admin/view_social_media',$data);
			$this->load->view('backend/admin/view_footer');
		}

	}

}