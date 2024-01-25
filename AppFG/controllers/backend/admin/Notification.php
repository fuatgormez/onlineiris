<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notification extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('id')) {
			redirect(base_url() . 'backend/admin/login');
			exit;
		}

		$this->load->model('backend/admin/Model_common');
		$this->load->model('backend/admin/Model_notification');

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
		$data['notification'] = $this->Model_notification->show();
		$data['notification_'] = $this->notification_->index();

		$this->load->view('backend/admin/view_header', $data);
		$this->load->view('backend/admin/view_notification', $data);
		$this->load->view('backend/admin/view_footer');
	}

	public function add()
	{
		$data['setting'] = $this->Model_common->get_setting_data();

		$error = '';
		$success = '';

		if (isset($_POST['form1'])) {

			$form_data = [];
			// print_r($this->input->post('to_user'));exit;

			$valid = 1;

			$path = $_FILES['photo']['name'];
			$path_tmp = $_FILES['photo']['tmp_name'];

			if ($path != '') {
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$file_name = basename($path, '.' . $ext);
				$ext_check = $this->Model_common->extension_check_photo($ext);
				if ($ext_check == FALSE) {
					$valid = 0;
					$error .= 'You must have to upload jpg, jpeg, gif or png file for featured photo<br>';
				} else {
					$next_id = $this->Model_notification->get_auto_increment_id();
					foreach ($next_id as $row) {
						$ai_id = $row['Auto_increment'];
					}

					$final_name = 'notification-' . $ai_id . '.' . $ext;
					move_uploaded_file($path_tmp, './public/uploads/notification/' . $final_name);

					$form_data['photo'] = $final_name;
				}
			}


			if ($valid == 1) {

				$to_user_id = array();
				$to_user_username = array();

				foreach($this->input->post('to_user') as  $row_to_user)
				{
					$to_user_explode = explode('@',$row_to_user);
					$to_user_id[] = $to_user_explode[0];
					$to_user_username[] = $to_user_explode[1];
				}
				
				$to_group_id = array();
				$to_group_name = array();

				foreach($this->input->post('to_group') as  $row_to_group)
				{
					$to_group_explode = explode('@',$row_to_group);
					$to_group_id[] = $to_group_explode[0];
					$to_group_name[] = $to_group_explode[1];
				}

				$form_data['title'] = $this->input->post('title');
				$form_data['content'] = $this->input->post('content');
				$form_data['to_user_id'] = json_encode($to_user_id);
				$form_data['to_user_username'] = json_encode($to_user_username);
				$form_data['to_group_id'] = json_encode($to_group_id);
				$form_data['to_group_name'] = json_encode($to_group_name);

				$this->Model_notification->add($form_data);

				$success = 'Notification is added successfully!';
				$this->session->set_flashdata('success', $success);
				redirect(base_url() . 'backend/admin/notification');
			} else {
				$this->session->set_flashdata('error', $error);
				redirect(base_url() . 'backend/admin/notification/add');
			}
		} else {
			$data['get_all_user'] = $this->Model_notification->get_all_user();
			$data['get_all_user_group'] = $this->Model_notification->get_all_user_group();

			$this->load->view('backend/admin/view_header', $data);
			$this->load->view('backend/admin/view_notification_add', $data);
			$this->load->view('backend/admin/view_footer');
		}
	}

	public function edit($id)
	{

		// If there is no notification in this id, then redirect
		$tot = $this->Model_notification->notification_check($id);
		if (!$tot) {
			redirect(base_url() . 'backend/admin/notification');
			exit;
		}

		$data['setting'] = $this->Model_common->get_setting_data();
		$error = '';
		$success = '';


		if (isset($_POST['form1'])) {

			$valid = 1;

			$path = $_FILES['photo']['name'];
			$path_tmp = $_FILES['photo']['tmp_name'];

			if ($path != '') {
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$file_name = basename($path, '.' . $ext);
				$ext_check = $this->Model_common->extension_check_photo($ext);
				if ($ext_check == FALSE) {
					$valid = 0;
					$error .= 'You must have to upload jpg, jpeg, gif or png file for featured photo<br>';
				}
			}

			if ($valid == 1) {
				$data['notification'] = $this->Model_notification->get_notification($id);

				if ($path == '') {

					$form_data['title'] = $this->input->post('title');
					$form_data['content'] = $this->input->post('content');
					$form_data['to_user'] = json_encode($this->input->post('to_user'));
					$form_data['to_group'] = json_encode($this->input->post('to_group'));

					$this->Model_notification->update($id, $form_data);
				} else {
					unlink('./public/uploads/notification/' . $data['notification']['photo']);

					$final_name = 'notification-' . $id . '.' . $ext;
					move_uploaded_file($path_tmp, './public/uploads/notification/' . $final_name);

					$form_data['title'] = $this->input->post('title');
					$form_data['content'] = $this->input->post('content');
					$form_data['to_user'] = json_encode($this->input->post('to_user'));
					$form_data['to_group'] = json_encode($this->input->post('to_group'));
					$form_data['photo'] = $final_name;
					
					$this->Model_notification->update($id, $form_data);
				}

				$success = 'Notification is updated successfully';
				$this->session->set_flashdata('success', $success);
				redirect(base_url() . 'backend/admin/notification');
			} else {
				$this->session->set_flashdata('error', $error);
				redirect(base_url() . 'backend/admin/notification/edit' . $id);
			}
		} else {
			$data['notification'] = $this->Model_notification->get_notification($id);
			$data['get_all_user'] = $this->Model_notification->get_all_user();
			$data['get_all_user_group'] = $this->Model_notification->get_all_user_group();
			$this->load->view('backend/admin/view_header', $data);
			$this->load->view('backend/admin/view_notification_edit', $data);
			$this->load->view('backend/admin/view_footer');
		}
	}

	public function delete($id)
	{
		// If there is no notification in this id, then redirect
		$tot = $this->Model_notification->notification_check($id);
		if (!$tot) {
			redirect(base_url() . 'backend/admin/notification');
			exit;
		}

		$data['notification'] = $this->Model_notification->get_notification($id);
		if ($data['notification']) {
			unlink('./public/uploads/notification/' . $data['notification']['photo']);
		}

		$this->Model_notification->delete($id);
		$success = 'Notification is deleted successfully';
		$this->session->set_flashdata('success', $success);
		redirect(base_url() . 'backend/admin/notification');
	}
}
