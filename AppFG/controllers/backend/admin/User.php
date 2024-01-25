<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('id')) {
			redirect(base_url() . 'backend/admin/login');
			exit;
		}

		$this->load->model('backend/admin/Model_common');
		$this->load->model('backend/admin/Model_user');

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
		$data['all_users'] = $this->Model_user->get_all_user();

		$this->load->view('backend/admin/view_header', $data);
		$this->load->view('backend/admin/view_user', $data);
		$this->load->view('backend/admin/view_footer');
	}

	public function add()
	{

		$error = '';
		$success = '';

		$data['setting'] = $this->Model_common->get_setting_data();
		
		
		if (isset($_POST['form1'])) {

			$valid = 1;

			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('phone', 'Phone', 'trim|required|is_unique[tbl_user.phone]');
			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');

			if ($this->form_validation->run() == FALSE) {
				$valid = 0;
				$error = validation_errors();
			}

			if ($valid == 1) {
				
				$form_data = array(
					'username'     => $this->input->post('username'),
					'slug'     => $this->input->post('username'),
					'email'     => $this->input->post('email'),
					'phone'     => $this->input->post('phone'),
					'status'     => $this->input->post('status'),
					'role'     => $this->input->post('role'),
					'password'     => sha1( $this->input->post('password'))
				);
				$this->Model_user->add($form_data);
				$success = 'User Information is added successfully!';

				$this->session->set_flashdata('success', $success);
				redirect(base_url() . 'backend/admin/user');
			} else {
				$this->session->set_flashdata('error', $error);
				redirect(base_url() . 'backend/admin/user/add');
			}
		}


		$this->load->view('backend/admin/view_header', $data);
		$this->load->view('backend/admin/view_user_add', $data);
		$this->load->view('backend/admin/view_footer');
	}
	
	public function edit($id)
	{
		if ($this->session->userdata('id') != 1) {
			if ($id == 1) {
				redirect(base_url('backend/admin'));
			}
		}

		// If there is no User in this id, then redirect
		$tot = $this->Model_user->user_check($id);
		if (!$tot) {
			redirect(base_url() . 'backend/admin/user');
			exit;
		}

		$error = '';
		$success = '';

		$data['setting'] = $this->Model_common->get_setting_data();
		$data['user'] = $this->Model_user->get_user_data($id);

		if (isset($_POST['form1'])) {

			$valid = 1;

			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
			if($data['user']->phone !== $this->input->post('phone')) {
				$this->form_validation->set_rules('phone', 'Phone', 'trim|required|is_unique[tbl_user.phone]');
			}

			if ($this->form_validation->run() == FALSE) {
				$valid = 0;
				$error = validation_errors();
			}

			if ($valid == 1) {
				$form_data = array(
					'username'     => $this->input->post('username'),
					'slug'     => $this->input->post('slug'),
					'email'     => $this->input->post('email'),
					'phone'     => $this->input->post('phone'),
					'status'     => $this->input->post('status'),
					'role'     => $this->input->post('role'),
					'password' => $data['user']->phone !== sha1($this->input->post('password')) ? sha1($this->input->post('password')) : null 
				);
				$this->Model_user->update($id, $form_data);
				$success = 'User Information is updated successfully!';

				// $this->session->set_userdata($form_data);
				$this->session->set_flashdata('success', $success);

				$form_data[] = 	array_push($form_data, array('responseMessage' => $success));

				exit(json_encode($form_data));
			} else {
				$this->session->set_flashdata('error', $error);
				redirect(base_url() . 'backend/admin/user');
			}
		}

		if (isset($_POST['form2'])) {

			$valid = 1;
			$path = $_FILES['photo']['name'];
			$path_tmp = $_FILES['photo']['tmp_name'];
			if ($path != '') {
				
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$file_name = basename($path, '.' . $ext);
				$ext_check = $this->Model_common->extension_check_photo($ext);
				if ($ext_check == FALSE) {
					$valid = 0;
					$data['error'] = 'You must have to upload jpg, jpeg, gif or png file<br>';
				}
			} else {
				$valid = 0;
				$data['error'] = 'You must have to select a photo<br>';
			}
			if ($valid == 1) {
				// removing the existing photo
				unlink('public/uploads/user/' . $data['user']->photo);

				// updating the data
				$final_name = 'user-' .$id. '.' . $ext;
				move_uploaded_file($path_tmp, './public/uploads/user/' . $final_name);

				$form_data = array(
					'photo' => $final_name
				);
				$this->Model_user->update($id,$form_data);
				$success = 'Photo is updated successfully!';

				// $this->session->set_userdata($form_data);
				$this->session->set_flashdata('success', $success);
				redirect(base_url() . 'backend/admin/user/edit/'.$id);
			} else {
				$this->session->set_flashdata('error', $error);
				redirect(base_url() . 'backend/admin/user');
			}
		}

		$this->load->view('backend/admin/view_header', $data);
		$this->load->view('backend/admin/view_user_edit', $data);
		$this->load->view('backend/admin/view_footer');
	}
	public function delete($id) 
	{
		// If there is no User in this id, then redirect
    	$tot = $this->Model_user->user_check($id);
    	if(!$tot) {
    		redirect(base_url().'backend/admin/user');
        	exit;
    	}

        $this->Model_user->delete($id);
        $success = 'User is deleted successfully';
		$this->session->set_flashdata('success',$success);
		redirect(base_url().'backend/admin/user');
    }
}
