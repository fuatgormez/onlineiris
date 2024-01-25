<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slider extends CI_Controller 
{
	function __construct() 
	{
		parent::__construct();
		if(!$this->session->userdata('id')) {
            redirect(base_url().'backend/admin/login');
            exit;
		}
		
        $this->load->model('backend/admin/Model_common');
        $this->load->model('backend/admin/Model_slider');

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

		$data['slider'] = $this->Model_slider->show();

		$this->load->view('backend/admin/view_header',$data);
		$this->load->view('backend/admin/view_slider',$data);
		$this->load->view('backend/admin/view_footer');
	}

	public function add()
	{
		$data['setting'] = $this->Model_common->get_setting_data();

		$error = '';
		$success = '';

		if(isset($_POST['form1'])) {

			$valid = 1;

            $path = $_FILES['photo']['name'];
		    $path_tmp = $_FILES['photo']['tmp_name'];

		    if($path!='') {
		        $ext = pathinfo( $path, PATHINFO_EXTENSION );
		        $file_name = basename( $path, '.' . $ext );
		        $ext_check = $this->Model_common->extension_check_photo($ext);
		        if($ext_check == FALSE) {
		            $valid = 0;
		            $error = 'You must have to upload jpg, jpeg, gif or png file for featured photo<br>';
		        }
		    } else {
		    	$valid = 0;
		        $error = 'You must have to select a photo for featured photo<br>';
		    }

		    if($valid == 1) {

				$next_id = $this->Model_slider->get_auto_increment_id();
				foreach ($next_id as $row) {
		            $ai_id = $row['Auto_increment'];
		        }

		        $final_name = 'slider-'.$ai_id.'.'.$ext;
		        move_uploaded_file( $path_tmp, './public/uploads/'.$final_name );

		        $form_data = array(
					'photo'        => $final_name,
					'heading'      => $_POST['heading'],
					'content'      => $_POST['content'],
					'button1_text' => $_POST['button1_text'],
					'button1_url'  => $_POST['button1_url'],
					'button2_text' => $_POST['button2_text'],
					'button2_url'  => $_POST['button2_url'],
					'position'     => $_POST['position']
	            );
	            $this->Model_slider->add($form_data);

	            $success = 'Slider is added successfully!';
	            $this->session->set_flashdata('success',$success);
	            redirect(base_url().'backend/admin/slider');
		    }
		    else {
		    	$this->session->set_flashdata('error',$error);
	            redirect(base_url().'backend/admin/slider/add');
		    }
        } else {
            $this->load->view('backend/admin/view_header',$data);
			$this->load->view('backend/admin/view_slider_add',$data);
			$this->load->view('backend/admin/view_footer');
        }
		
	}

	public function edit($id)
	{
		
    	// If there is no slider in this id, then redirect
    	$tot = $this->Model_slider->slider_check($id);
    	if(!$tot) {
    		redirect(base_url().'backend/admin/slider');
        	exit;
    	}
       	
       	$data['setting'] = $this->Model_common->get_setting_data();
		$error = '';
		$success = '';

		if(isset($_POST['form1'])) 
		{
			$valid = 1;

            $path = $_FILES['photo']['name'];
		    $path_tmp = $_FILES['photo']['tmp_name'];

		    if($path!='') {
		        $ext = pathinfo( $path, PATHINFO_EXTENSION );
		        $file_name = basename( $path, '.' . $ext );
		        $ext_check = $this->Model_common->extension_check_photo($ext);
		        if($ext_check == FALSE) {
		            $valid = 0;
		            $data['error'] = 'You must have to upload jpg, jpeg, gif or png file for featured photo<br>';
		        }
		    }

		    if($valid == 1) 
		    {
		    	$data['slider'] = $this->Model_slider->getData($id);

                $form_data = array(
                    'heading'      => $this->input->post('heading'),
                    'content'      => $this->input->post('content'),
                    'button1_text' => $this->input->post('button1_text'),
                    'button1_url'  => $this->input->post('button1_url'),
                    'button2_text' => $this->input->post('button2_text'),
                    'button2_url'  => $this->input->post('button2_url'),
                    'position'     => $this->input->post('position')
                );

		    	if($path == '') {
		            $this->Model_slider->update($id,$form_data);
				}
				else {
					unlink('./public/uploads/'.$data['slider']['photo']);

					$final_name = 'slider-'.$id.'.'.$ext;
		        	move_uploaded_file( $path_tmp, './public/uploads/'.$final_name );

		        	$form_data['photo'] = $final_name;

		            $this->Model_slider->update($id,$form_data);
				}
				
				$success = 'Slider is uploaded successfully!';
	            $this->session->set_flashdata('success',$success);
	            redirect(base_url().'backend/admin/slider');

		    } else {
				$this->session->set_flashdata('success',$success);
	            redirect(base_url().'backend/admin/slider/edit'.$id);
		    }
           
		} else {
			$data['slider'] = $this->Model_slider->getData($id);
	       	$this->load->view('backend/admin/view_header',$data);
			$this->load->view('backend/admin/view_slider_edit',$data);
			$this->load->view('backend/admin/view_footer');
		}

	}

	public function delete($id) 
	{
    	$tot = $this->Model_slider->slider_check($id);
    	if(!$tot) {
    		redirect(base_url().'backend/admin/slider');
        	exit;
    	}

        $data['slider'] = $this->Model_slider->getData($id);
        if($data['slider']) {
            unlink('./public/uploads/'.$data['slider']['photo']);
        }

        $this->Model_slider->delete($id);
        $success = 'Slider is deleted successfully!';
        $this->session->set_flashdata('success',$success);
        redirect(base_url().'backend/admin/slider');
    }

}