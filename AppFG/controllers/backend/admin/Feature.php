<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feature extends CI_Controller 
{
	function __construct() 
	{
		parent::__construct();
		if(!$this->session->userdata('id')) {
            redirect(base_url().'backend/admin/login');
            exit;
		}

		$this->load->model('backend/admin/Model_common');
		$this->load->model('backend/admin/Model_feature');
		
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
		$data['feature'] = $this->Model_feature->show();

		$this->load->view('backend/admin/view_header',$data);
		$this->load->view('backend/admin/view_feature',$data);
		$this->load->view('backend/admin/view_footer');
	}

	public function add()
	{
		$data['setting'] = $this->Model_common->get_setting_data();

		$error = '';
		$success = '';

		if(isset($_POST['form1'])) {

			$valid = 1;

			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			//$this->form_validation->set_rules('content', 'Content', 'trim|required');
			//$this->form_validation->set_rules('icon', 'Icon', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }
		    
		    if($valid == 1) 
		    {
		        $form_data = array(
					'name'    => $_POST['name'],
					'content' => $_POST['content'],
					'icon'    => $_POST['icon']
	            );
	            $this->Model_feature->add($form_data);

		        $success = 'Feature is added successfully!';
		        $this->session->set_flashdata('success',$success);
				redirect(base_url().'backend/admin/feature');
		    } 
		    else
		    {
		    	$this->session->set_flashdata('error',$error);
				redirect(base_url().'backend/admin/feature/add');
		    }
            
        } else {
            
            $this->load->view('backend/admin/view_header',$data);
			$this->load->view('backend/admin/view_feature_add',$data);
			$this->load->view('backend/admin/view_footer');
        }
		
	}

	public function edit($id)
	{
    	$tot = $this->Model_feature->feature_check($id);
    	if(!$tot) {
    		redirect(base_url().'backend/admin/feature');
        	exit;
    	}
       	
       	$data['setting'] = $this->Model_common->get_setting_data();
		$error = '';
		$success = '';


		if(isset($_POST['form1'])) 
		{

			$valid = 1;

			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			//$this->form_validation->set_rules('content', 'Content', 'trim|required');
			//$this->form_validation->set_rules('icon', 'Icon', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }
	    
		    if($valid == 1) 
		    {
		    	$data['feature'] = $this->Model_feature->getData($id);

	    		$form_data = array(
					'name'    => $_POST['name'],
					'content' => $_POST['content'],
					'icon'    => $_POST['icon']
	            );
	            $this->Model_feature->update($id,$form_data);
				
				$success = 'Feature is updated successfully';
				$this->session->set_flashdata('success',$success);
				redirect(base_url().'backend/admin/feature');
		    }
		    else
		    {
		    	$this->session->set_flashdata('error',$error);
				redirect(base_url().'backend/admin/feature/edit/'.$id);
		    }
           
		} else {
			$data['feature'] = $this->Model_feature->getData($id);
	       	$this->load->view('backend/admin/view_header',$data);
			$this->load->view('backend/admin/view_feature_edit',$data);
			$this->load->view('backend/admin/view_footer');
		}

	}

	public function delete($id) 
	{
    	$tot = $this->Model_feature->feature_check($id);
    	if(!$tot) {
    		redirect(base_url().'backend/admin/feature');
        	exit;
    	}

        $data['feature'] = $this->Model_feature->getData($id);
        if($data['feature']) {
            unlink('./public/uploads/'.$data['feature']['photo']);
        }

        $this->Model_feature->delete($id);
        $success = 'Feature is deleted successfully';
        $this->session->set_flashdata('success',$success);
        redirect(base_url().'backend/admin/feature');
    }

}