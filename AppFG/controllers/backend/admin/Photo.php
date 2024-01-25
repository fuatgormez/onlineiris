<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Photo extends CI_Controller 
{
	function __construct() 
	{
		parent::__construct();
		if(!$this->session->userdata('id')) {
            redirect(base_url().'backend/admin/login');
            exit;
		}

		$this->load->model('backend/admin/Model_common');
		$this->load->model('backend/admin/Model_photo');
		
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
		$data['photo'] = $this->Model_photo->show();

		$this->load->view('backend/admin/view_header',$data);
		$this->load->view('backend/admin/view_photo',$data);
		$this->load->view('backend/admin/view_footer');
	}

	public function add()
	{
		$data['setting'] = $this->Model_common->get_setting_data();

		$error = '';
		$success = '';

		if(isset($_POST['form1'])) {

			$photos = array();
            $photos = $_FILES['photos']["name"];
            $photos = array_values(array_filter($photos));

            $photos_temp = array();
            $photos_temp = $_FILES['photos']["tmp_name"];
            $photos_temp = array_values(array_filter($photos_temp));

            $next_id1 = $this->Model_photo->get_auto_increment_id();
            foreach ($next_id1 as $row1) {
                $ai_id1 = $row1['Auto_increment'];
            }

            $z = $ai_id1;
            $m = 0;
            $final_names = array();
            for ($i = 0; $i < count($photos); $i++) {
                $ext = pathinfo($photos[$i], PATHINFO_EXTENSION);
                $ext_check = $this->Model_common->extension_check_photo($ext);
                if ($ext_check == FALSE) {
                    // Nothing to do, just skip
                } else {
                    $final_names[$m] = $z . '.' . strtolower($ext);
                    move_uploaded_file($photos_temp[$i], "./public/uploads/photos/" . $final_names[$m]);
					$form_data = array('photo_name' =>$final_names[$i]);
					$this->Model_photo->add($form_data);
                    $m++;
                    $z++;
                }
            }
			$success = 'Photo is add successfully';
			$this->session->set_flashdata('success',$success);
			redirect(base_url('backend/admin/photo'));
        } else {
            $this->load->view('backend/admin/view_header',$data);
			$this->load->view('backend/admin/view_photo_add',$data);
			$this->load->view('backend/admin/view_footer');
        }
	}

	public function edit($id)
	{
		
    	// If there is no photo in this id, then redirect
    	$tot = $this->Model_photo->photo_check($id);
    	if(!$tot) {
    		redirect(base_url().'backend/admin/photo');
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
		            $error .= 'You must have to upload jpg, jpeg, gif or png file for featured photo<br>';
		        }
		    } else {
		    	$valid = 0;
		        $error .= 'You must have to select a photo<br>';
		    }

		    if($valid == 1)
		    {
		    	$data['photo'] = $this->Model_photo->getData($id);

				unlink('./public/uploads/'.$data['photo']['photo_name']);

				$final_name = 'photo-'.$id.'.'.$ext;
	        	move_uploaded_file( $path_tmp, './public/uploads/photos/'.$final_name );

	        	$form_data = array(
					'photo_name' => $final_name
	            );
	            $this->Model_photo->update($id,$form_data);

				$success = 'Photo is updated successfully';
				$this->session->set_flashdata('success',$success);
				redirect(base_url().'backend/admin/photo');
		    }
		    else
		    {
		    	$this->session->set_flashdata('error',$error);
				redirect(base_url().'backend/admin/photo/edit'.$id);
		    }
           
		} else {
			$data['photo'] = $this->Model_photo->getData($id);
	       	$this->load->view('backend/admin/view_header',$data);
			$this->load->view('backend/admin/view_photo_edit',$data);
			$this->load->view('backend/admin/view_footer');
		}

	}

	public function delete($id) 
	{
		// If there is no photo in this id, then redirect
    	$tot = $this->Model_photo->photo_check($id);
    	if(!$tot) {
    		redirect(base_url().'backend/admin/photo');
        	exit;
    	}

        $data['photo'] = $this->Model_photo->getData($id);
        if($data['photo']) {
            unlink('./public/uploads/photos/'.$data['photo']['photo_name']);
        }

        $this->Model_photo->delete($id);
        $success = 'Photo is deleted successfully';
		$this->session->set_flashdata('success',$success);
        redirect(base_url().'backend/admin/photo');
    }

}