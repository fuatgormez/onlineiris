<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ticket extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('id')) {
			redirect(base_url() . 'backend/admin/login');
			exit;
		}
		$this->load->model('backend/admin/Model_common');
		$this->load->model('backend/admin/Model_ticket');

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

		if (in_array($this->session->userdata('role'), ['Superadmin','Admin','Meister','Seller'])) {
			$data['ticket'] = $this->Model_ticket->show();
		} else {
			$data['ticket'] = $this->Model_ticket->show_user_tickect($this->session->userdata('id'));
		}


		$this->load->view('backend/admin/view_header', $data);
		$this->load->view('backend/admin/view_ticket', $data);
		$this->load->view('backend/admin/view_footer');
	}

	public function add()
	{
		$data['setting'] = $this->Model_common->get_setting_data();

		$error = '';
		$success = '';

		if (isset($_POST['form1'])) {

			$check_department = $this->Model_ticket->check_department($this->input->post('department_id'));
			if (!$check_department)
				redirect(base_url('backend/admin/ticket'));

			$valid = 1;

			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('message', 'Message', 'required');

			if ($this->form_validation->run() == FALSE) {
				$valid = 0;
				$error .= validation_errors();
			}

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
				$next_id = $this->Model_ticket->get_auto_increment_id();
				foreach ($next_id as $row) {
					$ai_id = $row['Auto_increment'];
				}

				$form_data = array(
					'user_id' => $this->session->userdata('id'),
					'username' => $this->session->userdata('username'),
					'department' => $check_department['department_name'],
					'urgency' => $this->input->post('urgency'),
					'title' => $this->input->post('title'),
					'message' => $this->input->post('message'),

				);
				$this->Model_ticket->add($form_data);


				if (isset($_FILES['photos']["name"]) && isset($_FILES['photos']["tmp_name"])) {

					$folder_date = date("d-m-Y");
					$current_folder = "./public/uploads/ticket_photos/"  . "/" . $folder_date . "/";

					if (!file_exists($current_folder)) {
						mkdir($current_folder, 0755, true);
					}

					$photos = array();
					$photos = $_FILES['photos']["name"];
					$photos = array_values(array_filter($photos));

					$photos_temp = array();
					$photos_temp = $_FILES['photos']["tmp_name"];
					$photos_temp = array_values(array_filter($photos_temp));

					$next_id1 = $this->Model_ticket->get_auto_increment_id1();
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
							$final_names[$m] = $z . '.' . $ext;
							move_uploaded_file($photos_temp[$i], $current_folder . $final_names[$m]);
							$m++;
							$z++;
						}
					}
				}

				for ($i = 0; $i < count($final_names); $i++) {
					$form_data = array(
						'ticket_id' => $ai_id,
						'photo'        => $final_names[$i]
					);
					$this->Model_ticket->add_photos($form_data);
				}


				$success = 'Ticket is added successfully!';
				$this->session->set_flashdata('success', $success);
				redirect(base_url() . 'backend/admin/ticket');
			} else {
				$this->session->set_flashdata('error', $error);
				redirect(base_url() . 'backend/admin/ticket/add');
			}
		} else {
			$data['all_ticket_department'] = $this->Model_ticket->all_ticket_department();
			$this->load->view('backend/admin/view_header', $data);
			$this->load->view('backend/admin/view_ticket_add', $data);
			$this->load->view('backend/admin/view_footer');
		}
	}

	public function edit($id)
	{
		$data['setting'] = $this->Model_common->get_setting_data();

		$error = '';
		$success = '';

		// If there is no ticket in this id, then redirect
		$tot = $this->Model_ticket->ticket_check($id);
		if (!$tot)
			redirect(base_url() . 'backend/admin/ticket');

		if ($this->session->userdata('role') !== "Superadmin")
			if ($tot['user_id'] != $this->session->userdata('id')) {
				redirect(base_url() . 'backend/admin/ticket');
			}

		if (isset($_POST['form1'])) {

			$check_department = $this->Model_ticket->check_department($this->input->post('department_id'));
			if (!$check_department)
				redirect(base_url('backend/admin/ticket'));

			$valid = 1;

			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('message', 'Message', 'required');

			if ($this->form_validation->run() == FALSE) {
				$valid = 0;
				$error .= validation_errors();
			}

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
				$next_id = $this->Model_ticket->get_auto_increment_id();
				foreach ($next_id as $row) {
					$ai_id = $row['Auto_increment'];
				}

				$form_data = array(
					// 'user_id' => $this->session->userdata('id'),
					// 'username' => $this->session->userdata('username'),
					'department' => $check_department['department_name'],
					'urgency' => $this->input->post('urgency'),
					'title' => $this->input->post('title'),
					'message' => $this->input->post('message'),

				);
				$this->Model_ticket->update($id, $form_data);

				if (isset($_FILES['photos']["name"]) && isset($_FILES['photos']["tmp_name"])) {
					$folder_date = date("d-m-Y", strtotime($tot['created_at']));
					$current_folder = "./public/uploads/ticket_photos/"  . "/" . $folder_date . "/";

					if (!file_exists($current_folder)) {
						mkdir($current_folder, 0755, true);
					}

					$photos = array();
					$photos = $_FILES['photos']["name"];
					$photos = array_values(array_filter($photos));

					$photos_temp = array();
					$photos_temp = $_FILES['photos']["tmp_name"];
					$photos_temp = array_values(array_filter($photos_temp));

					$next_id1 = $this->Model_ticket->get_auto_increment_id1();
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
							$final_names[$m] = $z . '.' . $ext;
							move_uploaded_file($photos_temp[$i], $current_folder . $final_names[$m]);
							$m++;
							$z++;
						}
					}
				}

				for ($i = 0; $i < count($final_names); $i++) {
					$form_data = array(
						'ticket_id' => $id,
						'photo'        => $final_names[$i]
					);
					$this->Model_ticket->add_photos($form_data);
				}

				$success = 'Ticket is edited successfully!';
				$this->session->set_flashdata('success', $success);
				redirect(base_url() . 'backend/admin/ticket');
			} else {
				$this->session->set_flashdata('error', $error);
				redirect(base_url() . 'backend/admin/ticket/add');
			}
		} else {
			$data['ticket'] = $this->Model_ticket->getData($id);
			$data['department'] = $this->Model_ticket->department();
			$data['ticket_photos'] = $this->Model_ticket->get_all_photos_by_ticket_id($id);
			$this->load->view('backend/admin/view_header', $data);
			$this->load->view('backend/admin/view_ticket_edit', $data);
			$this->load->view('backend/admin/view_footer');
		}
	}

	public function read($id)
	{
		$data['setting'] = $this->Model_common->get_setting_data();

		$error = '';
		$success = '';

		// If there is no ticket in this id, then redirect
		$tot = $this->Model_ticket->ticket_check($id);
		if (!$tot)
			redirect(base_url() . 'backend/admin/ticket');

		if (!in_array($this->session->userdata('role'), ['Superadmin','Admin','Meister','Seller']))
			if ($tot['user_id'] != $this->session->userdata('id')) {
				redirect(base_url() . 'backend/admin/ticket');
			}

		$data['ticket'] = $this->Model_ticket->getData($id);
		$data['ticket_detail'] = $this->Model_ticket->get_detail($id);
		$data['ticket_photos'] = $this->Model_ticket->get_all_photos_by_ticket_id($id);
		$this->load->view('backend/admin/view_header', $data);
		$this->load->view('backend/admin/view_ticket_read', $data);
		$this->load->view('backend/admin/view_footer');
	}

	public function answer($ticket_id)
	{
		$error = '';
		$success = '';

		// If there is no ticket in this id, then redirect
		$tot = $this->Model_ticket->ticket_check($ticket_id);
		if (!$tot)
			redirect(base_url() . 'backend/admin/ticket');

		if (isset($_POST['form1'])) {

			$valid = 1;

			$this->form_validation->set_rules('answer', 'Answer', 'required');

			if ($this->form_validation->run() == FALSE) {
				$valid = 0;
				$error .= validation_errors();
			}

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
				$next_id = $this->Model_ticket->get_auto_increment_id();
				foreach ($next_id as $row) {
					$ai_id = $row['Auto_increment'];
				}

				$form_data = array(
					'ticket_id' => $ticket_id,
					'user_id' => $this->session->userdata('id'),
					'username' => $this->session->userdata('username'),
					'answer' => $this->input->post('answer')
				);
				
				$insert_id = $this->Model_ticket->add_detail($form_data);
				
				$form_data_ticket = array(
					'status' => in_array($this->session->userdata('role'), ['Superadmin','Admin']) ? 'Close' : 'Open',
					'updated_at' => date("Y-m-d H:i:s")
				);
				$this->Model_ticket->update($ticket_id,$form_data_ticket);
				

				if (isset($_FILES['photos']["name"]) && isset($_FILES['photos']["tmp_name"])) {

					$folder_date = date("d-m-Y", strtotime($tot['created_at']));
					$current_folder = "./public/uploads/ticket_photos/"  . "/" . $folder_date . "/";

					if (!file_exists($current_folder)) {
						mkdir($current_folder, 0755, true);
					}

					$photos = array();
					$photos = $_FILES['photos']["name"];
					$photos = array_values(array_filter($photos));

					$photos_temp = array();
					$photos_temp = $_FILES['photos']["tmp_name"];
					$photos_temp = array_values(array_filter($photos_temp));

					$next_id1 = $this->Model_ticket->get_auto_increment_id1();
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
							$final_names[$m] = $z . '.' . $ext;
							move_uploaded_file($photos_temp[$i], $current_folder . $final_names[$m]);
							$m++;
							$z++;
						}
					}
				}

				for ($i = 0; $i < count($final_names); $i++) {
					$form_data = array(
						'ticket_id' => $ticket_id,
						'detail_id' => $insert_id,
						'photo'        => $final_names[$i]
					);
					$this->Model_ticket->add_photos($form_data);
				}

				$success = 'Answer is added successfully!';
				$this->session->set_flashdata('success', $success);
				redirect(base_url() . 'backend/admin/ticket');
			} else {
				$this->session->set_flashdata('error', $error);
				redirect(base_url() . 'backend/admin/ticket/add');
			}
		} else {
			redirect(base_url() . 'backend/admin/ticket/add');
		}
	}

	public function delete($id)
	{

		if (!in_array($this->session->userdata('role'), ['Superadmin'])) {
			redirect(base_url('backend/admin/ticket'));
		}

		$tot = $this->Model_ticket->ticket_check($id);
		if (!$tot) {
			redirect(base_url() . 'backend/admin/ticket');
			exit;
		}

		$ticket_photos = $this->Model_ticket->get_all_photos_by_ticket_id($id);
		foreach ($ticket_photos as $row) {
			unlink('./public/uploads/ticket_photos/' . date("d-m-Y", strtotime($tot['created_at'])) . '/' . $row['photo']);
		}

		//If there are no pictures in the folder, delete them completely.
		rmdir('./public/uploads/ticket_photos/' . date("d-m-Y", strtotime($tot['created_at'])));

		$this->Model_ticket->delete($id);
		$this->Model_ticket->delete_detail($id);
		$this->Model_ticket->delete_photos($id);

		$success = 'Ticket is deleted successfully';
		$this->session->set_flashdata('success', $success);
		redirect(base_url() . 'backend/admin/ticket');
	}

	public function single_photo_delete($photo_id = 0, $portfolio_id = 0)
	{

		$portfolio_photo = $this->Model_portfolio->portfolio_photo_by_id($photo_id);
		unlink('./public/uploads/portfolio_photos/' . $portfolio_photo['photo']);

		$this->Model_portfolio->delete_portfolio_photo($photo_id);

		redirect(base_url() . 'backend/admin/portfolio/edit/' . $portfolio_id);
	}

	public function close (int $id)
	{
		$form_data = array(
			'id' => $id,
			'status' => 'Close'
		);
		$this->Model_ticket->update($id, $form_data);

		redirect(base_url() . 'backend/admin/ticket');
	}
}
