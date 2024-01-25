<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Language extends CI_Controller 
{
	function __construct() 
	{
		parent::__construct();
		if(!$this->session->userdata('id')) {
            redirect(base_url().'backend/admin/login');
            exit;
		}
		
		$this->load->model('backend/admin/Model_common');
		$this->load->model('backend/admin/Model_language');
		
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

			foreach ($_POST['new_arr'] as $val) {
				$new_arr2[] = $val;
			}

			foreach ($_POST['new_arr1'] as $val) {
				$new_arr3[] = $val;
			}

			for($i=0;$i<count($new_arr2);$i++) {
				$form_data = array(
					'value' => $new_arr2[$i]
	            );
	            $this->Model_language->update($new_arr3[$i],$form_data);
			}

    		$success = 'Language data is updated successfully';
		    
		    $data['language'] = $this->Model_language->show();
	       	$this->session->set_flashdata('success',$success);

            $form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage'=> $success ));

            echo json_encode($form_data);
           
		} else {
			$data['language'] = $this->Model_language->show();
	       	$this->load->view('backend/admin/view_header',$data);
			$this->load->view('backend/admin/view_language',$data);
			$this->load->view('backend/admin/view_footer');
		}
	}

}