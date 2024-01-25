<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset_password extends CI_Controller 
{

    function __construct() 
    {
        parent::__construct();

        $data['setting'] = $this->Model_common->get_setting_data();

		if (!in_array($this->session->userdata('role'), ['Superadmin'])) {
			if ($data['setting']['website_status_backend'] === "Passive") {
				$data['message'] = $data['setting']['website_status_backend_message'];
				redirect(base_url('backend/info'));
			}
		}
        
        $this->load->model('backend/admin/Model_reset_password');
    }

    public function index($email=0,$token=0)
    {
        $tot = $this->Model_reset_password->check_url($email,$token);
        if(!$tot) {
            redirect(base_url().'admin');
            exit;
        }

        $error = '';
        $success = '';
        $data['setting'] = $this->Model_reset_password->get_setting_data();
        
        if(isset($_POST['form1'])) {
            $valid = 1;

            $this->form_validation->set_rules('new_password', 'Password', 'trim|required');
            $this->form_validation->set_rules('re_password', 'Retype Password', 'trim|required|matches[new_password]');

            if($this->form_validation->run() == FALSE) {
                $valid = 0;
                $error = validation_errors();
            }

            if($valid == 1) 
            {
                $form_data = array(
                    'password' => sha1($_POST['new_password']),
                    'token'    => ''
                );
                $this->Model_reset_password->update($email,$form_data);
                $success = 'Password is updated successfully!';
                $this->session->set_flashdata('success',$success);
                redirect(base_url().'backend/admin/reset_password/success');
            }
            else
            {
                $this->session->set_flashdata('error',$error);
                $data['var1'] = $email;
                $data['var2'] = $token;
                $this->load->view('backend/admin/view_reset_password',$data);
            }
        } else {
            $data['var1'] = $email;
            $data['var2'] = $token;
            $this->load->view('backend/admin/view_reset_password',$data);
        }        
    }

    public function success() 
    {
        $data['setting'] = $this->Model_reset_password->get_setting_data();
        $this->load->view('backend/admin/view_reset_password_success',$data);
    }
}
