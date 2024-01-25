<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Comment extends CI_Controller 
{
	function __construct() 
	{
		parent::__construct();
		if(!$this->session->userdata('id')) {
            redirect(base_url().'backend/admin/login');
            exit;
        }
		
		$this->load->model('backend/admin/Model_common');
		$this->load->model('backend/admin/Model_comment');
		
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
       	
		$error = '';
		$success = '';

		if(isset($_POST['form1'])) 
		{
			$valid = 1;

			$this->form_validation->set_rules('code_body', 'Comment Body Code', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error = validation_errors();
            }
            
		    if($valid == 1) 
		    {
		    	$data['comment'] = $this->Model_comment->show();

	    		$form_data = array(
					'code_body'  => $_POST['code_body']
	            );
	            $this->Model_comment->update($form_data);
				
				$success = 'Comment Body Code is updated successfully';
				$this->session->set_flashdata('success',$success);
				redirect(base_url().'backend/admin/comment');
		    }
		    else
		    {
		    	$this->session->set_flashdata('error',$error);
				redirect(base_url().'backend/admin/comment');
		    }
           
		} else {
			$data['comment'] = $this->Model_comment->show();
	       	$this->load->view('backend/admin/view_header',$data);
			$this->load->view('backend/admin/view_comment',$data);
			$this->load->view('backend/admin/view_footer');
		}

	}


}