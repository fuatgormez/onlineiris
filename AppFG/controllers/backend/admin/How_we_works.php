<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class How_we_works extends CI_Controller
{
	function __construct() 
	{
		parent::__construct();
		if(!$this->session->userdata('id')) {
            redirect(base_url().'backend/admin/login');
            exit;
		}

		$this->load->model('backend/admin/Model_common');
		$this->load->model('backend/admin/Model_how_we_works');
		
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
		$data['how_we_works'] = $this->Model_how_we_works->show();

		$this->load->view('backend/admin/view_header',$data);
		$this->load->view('backend/admin/view_how_we_works',$data);
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
			$this->form_validation->set_rules('content', 'Content', 'trim|required');
			$this->form_validation->set_rules('icon', 'Icon', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }

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
		    	//$valid = 0;
		        $error .= 'You must have to select a photo for featured photo<br>';
		    }

		    
		    if($valid == 1) 
		    {
				$next_id = $this->Model_how_we_works->get_auto_increment_id();
				foreach ($next_id as $row) {
		            $ai_id = $row['Auto_increment'];
		        }

                if($_FILES["photo"]["size"]>0){
		            $final_name = 'how-we-works-'.$ai_id.'.'.$ext;
		            move_uploaded_file( $path_tmp, './public/uploads/'.$final_name );
                }else{
                    $final_name = '';
                }

		        $form_data = array(
					'name'    => $_POST['name'],
					'content' => $_POST['content'],
					'icon'    => $_POST['icon'],
					'photo'   => $final_name
	            );
	            $this->Model_how_we_works->add($form_data);

		        $success = 'How We Works Section is added successfully!';
		        $this->session->set_flashdata('success',$success);
				redirect(base_url().'backend/admin/how_we_works');
		    } 
		    else
		    {
		    	$this->session->set_flashdata('error',$error);
				redirect(base_url().'backend/admin/how_we_works/add');
		    }
            
        } else {
            
            $this->load->view('backend/admin/view_header',$data);
			$this->load->view('backend/admin/view_how_we_works_add',$data);
			$this->load->view('backend/admin/view_footer');
        }
		
	}

	public function edit($id)
	{
		
    	$tot = $this->Model_how_we_works->how_we_works_check($id);
    	if(!$tot) {
    		redirect(base_url().'backend/admin/how_we_works');
        	exit;
    	}
       	
       	$data['setting'] = $this->Model_common->get_setting_data();
		$error = '';
		$success = '';


		if(isset($_POST['form1'])) 
		{

			$valid = 1;

			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('content', 'Content', 'trim|required');
			$this->form_validation->set_rules('icon', 'Icon', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }

            $path = $_FILES['photo']['name'];
		    $path_tmp = $_FILES['photo']['tmp_name'];

		    if($path!='') {
		        $ext = pathinfo( $path, PATHINFO_EXTENSION );
		        $file_name = basename( $path, '.' . $ext );
		        $ext_check = $this->Model_common->extension_check_photo($ext);
		        if($ext_check == FALSE) {
		            //$valid = 0;
		            $error .= 'You must have to upload jpg, jpeg, gif or png file for featured photo<br>';
		        }
		    }

		    
		    if($valid == 1) 
		    {
		    	$data['how_we_works'] = $this->Model_how_we_works->getData($id);

                $form_data = array(
                    'name'    => $_POST['name'],
                    'content' => $_POST['content'],
                    'icon'    => $_POST['icon']
                );

		    	if($path == '') {
		            $this->Model_how_we_works->update($id,$form_data);
				}
				else {
					unlink('./public/uploads/'.$data['how_we_works']['photo']);

                    if($_FILES["photo"]["size"]>0){
                        $final_name = 'how-we-works-'.$id.'.'.$ext;
                        move_uploaded_file( $path_tmp, './public/uploads/'.$final_name );
                    }else{
                        $final_name = '';
                    }

		        	$form_data['photo'] = $final_name;

		            $this->Model_how_we_works->update($id,$form_data);
				}
				$success = 'How We Works Section is updated successfully';
				$this->session->set_flashdata('success',$success);
				redirect(base_url().'backend/admin/how_we_works');
		    }
		    else
		    {
		    	$this->session->set_flashdata('error',$error);
				redirect(base_url().'backend/admin/how_we_works/edit/'.$id);
		    }
           
		} else {
			$data['how_we_works'] = $this->Model_how_we_works->getData($id);
	       	$this->load->view('backend/admin/view_header',$data);
			$this->load->view('backend/admin/view_how_we_works_edit',$data);
			$this->load->view('backend/admin/view_footer');
		}

	}

	public function delete($id) 
	{
    	$tot = $this->Model_how_we_works->how_we_works_check($id);
    	if(!$tot) {
    		redirect(base_url().'backend/admin/how_we_works');
        	exit;
    	}

        $data['how_we_works'] = $this->Model_how_we_works->getData($id);
        if($data['how_we_works']) {
            unlink('./public/uploads/'.$data['how_we_works']['photo']);
        }

        $this->Model_how_we_works->delete($id);
        $success = 'How We Works Section is deleted successfully';
        $this->session->set_flashdata('success',$success);
        redirect(base_url().'backend/admin/how_we_works');
    }

}