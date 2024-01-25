<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('id')) {
            redirect(base_url().'backend/admin/login');
            exit;
		}

		$this->load->model('backend/admin/Model_common');
		$this->load->model('backend/admin/Model_page');

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
		$data['setting'] = $this->Model_common->get_setting_data();
		$data['page_home'] = $this->Model_page->show_home();
		$data['page_about'] = $this->Model_page->show_about();
		$data['page_job'] = $this->Model_page->show_job();
		$data['page_impressum'] = $this->Model_page->show_impressum();
		$data['page_datenschutz'] = $this->Model_page->show_datenschutz();
		$data['page_agb'] = $this->Model_page->show_agb();
		$data['page_wiederruf'] = $this->Model_page->show_wiederruf();
		$data['page_faq'] = $this->Model_page->show_faq();
		$data['page_service'] = $this->Model_page->show_service();
		$data['page_testimonial'] = $this->Model_page->show_testimonial();
		$data['page_news'] = $this->Model_page->show_news();
		$data['page_contact'] = $this->Model_page->show_contact();
		$data['page_search'] = $this->Model_page->show_search();
		$data['page_term'] = $this->Model_page->show_term();
		$data['page_privacy'] = $this->Model_page->show_privacy();
		$data['page_team'] = $this->Model_page->show_team();
		$data['page_portfolio'] = $this->Model_page->show_portfolio();
		$data['page_event'] = $this->Model_page->show_event();

		$this->load->view('backend/admin/view_header', $data);
		$this->load->view('backend/admin/view_page', $data);
		$this->load->view('backend/admin/view_footer');
	}

	public function update()
	{
		$error = '';
		$success = '';

		$data['page_home'] = $this->Model_page->show_home();

		if (isset($_POST['form_home'])) {
			$form_data = array(
				'title'                 => $this->input->post('title'),
				'meta_keyword'          => $this->input->post('meta_keyword'),
				'meta_description'      => $this->input->post('meta_description')
			);
			$this->Model_page->update_home($form_data);
			$success = 'Home page meta information is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			exit(json_encode($form_data));
		}

		if (isset($_POST['form_home_welcome'])) {
			// $form_data["token"] = $this->security->get_csrf_hash();

			//  $token = $this->security->get_csrf_hash();

			$form_data = array(
				'home_welcome_title'       => $this->input->post('home_welcome_title'),
				'home_welcome_subtitle'    => $this->input->post('home_welcome_subtitle'),
				'home_welcome_text'        => $this->input->post('home_welcome_text'),
				'home_welcome_video'       => $this->input->post('home_welcome_video'),
				'home_welcome_pbar1_text'  => $this->input->post('home_welcome_pbar1_text'),
				'home_welcome_pbar1_value' => $this->input->post('home_welcome_pbar1_value'),
				'home_welcome_pbar2_text'  => $this->input->post('home_welcome_pbar2_text'),
				'home_welcome_pbar2_value' => $this->input->post('home_welcome_pbar2_value'),
				'home_welcome_pbar3_text'  => $this->input->post('home_welcome_pbar3_text'),
				'home_welcome_pbar3_value' => $this->input->post('home_welcome_pbar3_value'),
				'home_welcome_pbar4_text'  => $this->input->post('home_welcome_pbar4_text'),
				'home_welcome_pbar4_value' => $this->input->post('home_welcome_pbar4_value'),
				'home_welcome_pbar5_text'  => $this->input->post('home_welcome_pbar5_text'),
				'home_welcome_pbar5_value' => $this->input->post('home_welcome_pbar5_value'),
				'home_welcome_status'      => $this->input->post('home_welcome_status')
			);

			$this->Model_page->update_home($form_data);
			$success = 'Home page welcome information is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
		}

		if (isset($_POST['form_home_welcome_video_bg'])) {
			$valid = 1;
			$path = $_FILES['home_welcome_video_bg']['name'];
			$path_tmp = $_FILES['home_welcome_video_bg']['tmp_name'];
			if ($path != '') {
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$file_name = basename($path, '.' . $ext);
				$ext_check = $this->Model_common->extension_check_photo($ext);
				if ($ext_check == FALSE) {
					$valid = 0;
					$error = 'You must have to upload jpg, jpeg, gif or png file<br>';
				}
			} else {
				$valid = 0;
				$error = 'You must have to select a photo<br>';
			}
			if ($valid == 1) {
				// removing the existing photo
				unlink('./public/uploads/' . $data['page_home']['home_welcome_video_bg']);

				// updating the data
				$final_name = 'home_welcome_video_bg' . '.' . $ext;
				move_uploaded_file($path_tmp, './public/uploads/' . $final_name);

				$form_data = array(
					'home_welcome_video_bg' => $final_name
				);
				$this->Model_page->update_home($form_data);

				$success = 'Home page welcome video background is updated successfully!';
				$this->session->set_flashdata('success', $success);

				redirect(base_url() . 'backend/admin/page');
			} else {
				$this->session->set_flashdata('error', $error);
				redirect(base_url() . 'backend/admin/page');
			}
		}

		if (isset($_POST['form_home_why_choose'])) {
			$form_data = array(
				'home_why_choose_title'    => $_POST['home_why_choose_title'],
				'home_why_choose_subtitle' => $_POST['home_why_choose_subtitle'],
				'home_why_choose_status'   => $_POST['home_why_choose_status']
			);
			$this->Model_page->update_home($form_data);
			$success = 'Home page why choose us information is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
		}

		if (isset($_POST['form_home_why_choose_photo'])) {
			$valid = 1;
			$path = $_FILES['home_why_choose_photo']['name'];
			$path_tmp = $_FILES['home_why_choose_photo']['tmp_name'];
			if ($path != '') {
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$file_name = basename($path, '.' . $ext);
				$ext_check = $this->Model_common->extension_check_photo($ext);
				if ($ext_check == FALSE) {
					$valid = 0;
					$error = 'You must have to upload jpg, jpeg, gif or png file<br>';
				}
			} else {
				$valid = 0;
				$error = 'You must have to select a photo<br>';
			}
			if ($valid == 1) {
				// removing the existing photo
				unlink('./public/uploads/' . $data['page_home']['home_why_choose_photo']);

				// updating the data
				$final_name = 'home_why_choose_photo' . '.' . $ext;
				move_uploaded_file($path_tmp, './public/uploads/' . $final_name);

				$form_data = array(
					'home_why_choose_photo' => $final_name
				);
				$this->Model_page->update_home($form_data);

				$success = 'Home page why choose photo is updated successfully!';
				$this->session->set_flashdata('success', $success);
				redirect(base_url() . 'backend/admin/page');
			} else {
				$this->session->set_flashdata('error', $error);
				redirect(base_url() . 'backend/admin/page');
			}
		}

		if (isset($_POST['form_home_how_we_works'])) {
			$form_data = array(
				'home_how_we_works_title'    => $_POST['home_how_we_works_title'],
				'home_how_we_works_subtitle' => $_POST['home_how_we_works_subtitle'],
				'home_how_we_works_status'   => $_POST['home_how_we_works_status']
			);
			$this->Model_page->update_home($form_data);
			$success = 'Home page how we works information is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
			return;
		}

		if (isset($_POST['form_home_how_we_works_photo'])) {
			$valid = 1;
			$path = $_FILES['home_how_we_works_photo']['name'];
			$path_tmp = $_FILES['home_how_we_works_photo']['tmp_name'];
			if ($path != '') {
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$file_name = basename($path, '.' . $ext);
				$ext_check = $this->Model_common->extension_check_photo($ext);
				if ($ext_check == FALSE) {
					$valid = 0;
					$error = 'You must have to upload jpg, jpeg, gif or png file<br>';
				}
			} else {
				$valid = 0;
				$error = 'You must have to select a photo<br>';
			}
			if ($valid == 1) {
				// removing the existing photo
				unlink('./public/uploads/' . $data['page_home']['home_how_we_works_photo']);

				// updating the data
				$final_name = 'home_how_we_works_photo' . '.' . $ext;
				move_uploaded_file($path_tmp, './public/uploads/' . $final_name);

				$form_data = array(
					'home_how_we_works_photo' => $final_name
				);
				$this->Model_page->update_home($form_data);

				$success = 'Home page how we works photo is updated successfully!';
				$this->session->set_flashdata('success', $success);
				redirect(base_url() . 'backend/admin/page');
			} else {
				$this->session->set_flashdata('error', $error);
				redirect(base_url() . 'backend/admin/page');
			}
		}

		if (isset($_POST['form_home_feature'])) {
			$form_data = array(
				'home_feature_title'    => $this->input->post('home_feature_title'),
				'home_feature_subtitle' => $this->input->post('home_feature_subtitle'),
				'home_feature_status'   => $this->input->post('home_feature_status')
			);
			$this->Model_page->update_home($form_data);
			$success = 'Home page feature information is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
		}

		if (isset($_POST['form_home_feature_photo'])) {
			$valid = 1;
			$path = $_FILES['home_feature_photo']['name'];
			$path_tmp = $_FILES['home_feature_photo']['tmp_name'];
			if ($path != '') {
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$file_name = basename($path, '.' . $ext);
				$ext_check = $this->Model_common->extension_check_photo($ext);
				if ($ext_check == FALSE) {
					$valid = 0;
					$error = 'You must have to upload jpg, jpeg, gif or png file<br>';
				}
			} else {
				$valid = 0;
				$error = 'You must have to select a photo<br>';
			}
			if ($valid == 1) {
				// removing the existing photo
				unlink('./public/uploads/' . $data['page_home']['home_feature_photo']);

				// updating the data
				$final_name = 'home_feature_photo' . '.' . $ext;
				move_uploaded_file($path_tmp, './public/uploads/' . $final_name);

				$form_data = array(
					'home_feature_photo' => $final_name
				);
				$this->Model_page->update_home($form_data);

				$success = 'Home page feature photo is updated successfully!';
				$this->session->set_flashdata('success', $success);
				redirect(base_url() . 'backend/admin/page');
			} else {
				$this->session->set_flashdata('error', $error);
				redirect(base_url() . 'backend/admin/page');
			}
		}

		if (isset($_POST['form_home_team_photo'])) {
			$valid = 1;
			$path = $_FILES['home_team_photo']['name'];
			$path_tmp = $_FILES['home_team_photo']['tmp_name'];
			if ($path != '') {
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$file_name = basename($path, '.' . $ext);
				$ext_check = $this->Model_common->extension_check_photo($ext);
				if ($ext_check == FALSE) {
					$valid = 0;
					$error = 'You must have to upload jpg, jpeg, gif or png file<br>';
				}
			} else {
				$valid = 0;
				$error = 'You must have to select a photo<br>';
			}
			if ($valid == 1) {
				// removing the existing photo
				unlink('./public/uploads/' . $data['page_home']['home_team_photo']);

				// updating the data
				$final_name = 'home_team_photo' . '.' . $ext;
				move_uploaded_file($path_tmp, './public/uploads/' . $final_name);

				$form_data = array(
					'home_team_photo' => $final_name
				);
				$this->Model_page->update_home($form_data);

				$success = 'Home page team photo is updated successfully!';
				$this->session->set_flashdata('success', $success);
				redirect(base_url() . 'backend/admin/page');
			} else {
				$this->session->set_flashdata('error', $error);
				redirect(base_url() . 'backend/admin/page');
			}
		}

		if (isset($_POST['form_home_service'])) {
			$form_data = array(
				'home_service_title'    => $_POST['home_service_title'],
				'home_service_subtitle' => $_POST['home_service_subtitle'],
				'home_service_status'   => $_POST['home_service_status']
			);
			$this->Model_page->update_home($form_data);
			$success = 'Home page service information is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
		}

		if (isset($_POST['form_home_service_photo'])) {
			$valid = 1;
			$path = $_FILES['home_service_photo']['name'];
			$path_tmp = $_FILES['home_service_photo']['tmp_name'];
			if ($path != '') {
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$file_name = basename($path, '.' . $ext);
				$ext_check = $this->Model_common->extension_check_photo($ext);
				if ($ext_check == FALSE) {
					$valid = 0;
					$error = 'You must have to upload jpg, jpeg, gif or png file<br>';
				}
			} else {
				$valid = 0;
				$error = 'You must have to select a photo<br>';
			}
			if ($valid == 1) {
				// removing the existing photo
				unlink('./public/uploads/' . $data['page_home']['home_service_photo']);

				// updating the data
				$final_name = 'home_service_photo' . '.' . $ext;
				move_uploaded_file($path_tmp, './public/uploads/' . $final_name);

				$form_data = array(
					'home_service_photo' => $final_name
				);
				$this->Model_page->update_home($form_data);

				$success = 'Home page service photo is updated successfully!';
				$this->session->set_flashdata('success', $success);
				redirect(base_url() . 'backend/admin/page');
			} else {
				$this->session->set_flashdata('error', $error);
				redirect(base_url() . 'backend/admin/page');
			}
		}

		if (isset($_POST['form_home_counter_text'])) {
			$form_data = array(
				'counter_1_title' => $_POST['counter_1_title'],
				'counter_1_value' => $_POST['counter_1_value'],
				'counter_1_icon'  => $_POST['counter_1_icon'],
				'counter_2_title' => $_POST['counter_2_title'],
				'counter_2_value' => $_POST['counter_2_value'],
				'counter_2_icon'  => $_POST['counter_2_icon'],
				'counter_3_title' => $_POST['counter_3_title'],
				'counter_3_value' => $_POST['counter_3_value'],
				'counter_3_icon'  => $_POST['counter_3_icon'],
				'counter_4_title' => $_POST['counter_4_title'],
				'counter_4_value' => $_POST['counter_4_value'],
				'counter_4_icon'  => $_POST['counter_4_icon'],
				'counter_status'  => $_POST['counter_status']
			);
			$this->Model_page->update_home($form_data);
			$success = 'Home page counter information is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
		}

		if (isset($_POST['form_home_counter_photo'])) {
			$valid = 1;
			$path = $_FILES['counter_photo']['name'];
			$path_tmp = $_FILES['counter_photo']['tmp_name'];
			if ($path != '') {
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$file_name = basename($path, '.' . $ext);
				$ext_check = $this->Model_common->extension_check_photo($ext);
				if ($ext_check == FALSE) {
					$valid = 0;
					$error = 'You must have to upload jpg, jpeg, gif or png file<br>';
				}
			} else {
				$valid = 0;
				$error = 'You must have to select a photo<br>';
			}
			if ($valid == 1) {
				// removing the existing photo
				unlink('./public/uploads/' . $data['page_home']['counter_photo']);

				// updating the data
				$final_name = 'counter' . '.' . $ext;
				move_uploaded_file($path_tmp, './public/uploads/' . $final_name);

				$form_data = array(
					'counter_photo' => $final_name
				);
				$this->Model_page->update_home($form_data);

				$success = 'Home page counter photo is updated successfully!';
				$this->session->set_flashdata('success', $success);
				redirect(base_url() . 'backend/admin/page');
			} else {
				$this->session->set_flashdata('error', $error);
				redirect(base_url() . 'backend/admin/page');
			}
		}

		if (isset($_POST['form_home_portfolio'])) {
			$form_data = array(
				'home_portfolio_title'    => $_POST['home_portfolio_title'],
				'home_portfolio_subtitle' => $_POST['home_portfolio_subtitle'],
				'home_portfolio_status'   => $_POST['home_portfolio_status']
			);
			$this->Model_page->update_home($form_data);
			$success = 'Home page portfolio information is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
		}

		if (isset($_POST['form_home_portfolio_photo'])) {
			$valid = 1;
			$path = $_FILES['home_portfolio_photo']['name'];
			$path_tmp = $_FILES['home_portfolio_photo']['tmp_name'];
			if ($path != '') {
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$file_name = basename($path, '.' . $ext);
				$ext_check = $this->Model_common->extension_check_photo($ext);
				if ($ext_check == FALSE) {
					$valid = 0;
					$error = 'You must have to upload jpg, jpeg, gif or png file<br>';
				}
			} else {
				$valid = 0;
				$error = 'You must have to select a photo<br>';
			}
			if ($valid == 1) {
				// removing the existing photo
				unlink('./public/uploads/' . $data['page_home']['home_portfolio_photo']);

				// updating the data
				$final_name = 'home_portfolio_photo' . '.' . $ext;
				move_uploaded_file($path_tmp, './public/uploads/' . $final_name);

				$form_data = array(
					'home_portfolio_photo' => $final_name
				);
				$this->Model_page->update_home($form_data);

				$success = 'Home page portfolio photo is updated successfully!';
				$this->session->set_flashdata('success', $success);
				redirect(base_url() . 'backend/admin/page');
			} else {
				$this->session->set_flashdata('error', $error);
				redirect(base_url() . 'backend/admin/page');
			}
		}

		if (isset($_POST['form_home_booking'])) {
			$form_data = array(
				'home_booking_form_title' => $_POST['home_booking_form_title'],
				'home_booking_faq_title'  => $_POST['home_booking_faq_title'],
				'home_booking_status'     => $_POST['home_booking_status']
			);
			$this->Model_page->update_home($form_data);
			$success = 'Home page booking information is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
			exit;
		}

		if (isset($_POST['form_home_booking_photo'])) {
			$valid = 1;
			$path = $_FILES['home_booking_photo']['name'];
			$path_tmp = $_FILES['home_booking_photo']['tmp_name'];
			if ($path != '') {
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$file_name = basename($path, '.' . $ext);
				$ext_check = $this->Model_common->extension_check_photo($ext);
				if ($ext_check == FALSE) {
					$valid = 0;
					$error = 'You must have to upload jpg, jpeg, gif or png file<br>';
				}
			} else {
				$valid = 0;
				$error = 'You must have to select a photo<br>';
			}
			if ($valid == 1) {
				// removing the existing photo
				unlink('./public/uploads/' . $data['page_home']['home_booking_photo']);

				// updating the data
				$final_name = 'home_booking_photo' . '.' . $ext;
				move_uploaded_file($path_tmp, './public/uploads/' . $final_name);

				$form_data = array(
					'home_booking_photo' => $final_name
				);
				$this->Model_page->update_home($form_data);

				$success = 'Home page booking photo is updated successfully!';
				$this->session->set_flashdata('success', $success);
				redirect(base_url() . 'backend/admin/page');
			} else {
				$this->session->set_flashdata('error', $error);
				redirect(base_url() . 'backend/admin/page');
			}
		}

		if (isset($_POST['form_home_team'])) {
			$form_data = array(
				'home_team_title'    => $_POST['home_team_title'],
				'home_team_subtitle' => $_POST['home_team_subtitle'],
				'home_team_status'   => $_POST['home_team_status']
			);
			$this->Model_page->update_home($form_data);
			$success = 'Home page team information is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
		}

		if (isset($_POST['form_home_team_photo'])) {
			$valid = 1;
			$path = $_FILES['home_team_photo']['name'];
			$path_tmp = $_FILES['home_team_photo']['tmp_name'];
			if ($path != '') {
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$file_name = basename($path, '.' . $ext);
				$ext_check = $this->Model_common->extension_check_photo($ext);
				if ($ext_check == FALSE) {
					$valid = 0;
					$error = 'You must have to upload jpg, jpeg, gif or png file<br>';
				}
			} else {
				$valid = 0;
				$error = 'You must have to select a photo<br>';
			}
			if ($valid == 1) {
				// removing the existing photo
				unlink('./public/uploads/' . $data['page_home']['home_team_photo']);

				// updating the data
				$final_name = 'home_team_photo' . '.' . $ext;
				move_uploaded_file($path_tmp, './public/uploads/' . $final_name);

				$form_data = array(
					'home_team_photo' => $final_name
				);
				$this->Model_page->update_home($form_data);

				$success = 'Home page team photo is updated successfully!';
				$this->session->set_flashdata('success', $success);
				redirect(base_url() . 'backend/admin/page');
			} else {
				$this->session->set_flashdata('error', $error);
				redirect(base_url() . 'backend/admin/page');
			}
		}

		if (isset($_POST['form_home_pricing_table'])) {
			$form_data = array(
				'home_ptable_title'    => $_POST['home_ptable_title'],
				'home_ptable_subtitle' => $_POST['home_ptable_subtitle'],
				'home_ptable_status'   => $_POST['home_ptable_status']
			);
			$this->Model_page->update_home($form_data);
			$success = 'Home page pricing table information is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
		}

		if (isset($_POST['form_home_pricing_photo'])) {
			$valid = 1;
			$path = $_FILES['home_ptable_photo']['name'];
			$path_tmp = $_FILES['home_ptable_photo']['tmp_name'];
			if ($path != '') {
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$file_name = basename($path, '.' . $ext);
				$ext_check = $this->Model_common->extension_check_photo($ext);
				if ($ext_check == FALSE) {
					$valid = 0;
					$error = 'You must have to upload jpg, jpeg, gif or png file<br>';
				}
			} else {
				$valid = 0;
				$error = 'You must have to select a photo<br>';
			}
			if ($valid == 1) {
				// removing the existing photo
				unlink('./public/uploads/' . $data['page_home']['home_pricing_photo']);

				// updating the data
				$final_name = 'home_ptable_photo' . '.' . $ext;
				move_uploaded_file($path_tmp, './public/uploads/' . $final_name);

				$form_data = array(
					'home_ptable_photo' => $final_name
				);
				$this->Model_page->update_home($form_data);

				$success = 'Home page pricing photo is updated successfully!';
				$this->session->set_flashdata('success', $success);
				redirect(base_url() . 'backend/admin/page');
			} else {
				$this->session->set_flashdata('error', $error);
				redirect(base_url() . 'backend/admin/page');
			}
		}

		if (isset($_POST['form_home_testimonial'])) {
			$form_data = array(
				'home_testimonial_title'    => $_POST['home_testimonial_title'],
				'home_testimonial_subtitle' => $_POST['home_testimonial_subtitle'],
				'home_testimonial_status'   => $_POST['home_testimonial_status']
			);
			$this->Model_page->update_home($form_data);
			$success = 'Home page testimonial information is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
		}

		if (isset($_POST['form_home_testimonial_photo'])) {
			$valid = 1;
			$path = $_FILES['home_testimonial_photo']['name'];
			$path_tmp = $_FILES['home_testimonial_photo']['tmp_name'];
			if ($path != '') {
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$file_name = basename($path, '.' . $ext);
				$ext_check = $this->Model_common->extension_check_photo($ext);
				if ($ext_check == FALSE) {
					$valid = 0;
					$error = 'You must have to upload jpg, jpeg, gif or png file<br>';
				}
			} else {
				$valid = 0;
				$error = 'You must have to select a photo<br>';
			}
			if ($valid == 1) {
				// removing the existing photo
				unlink('./public/uploads/' . $data['page_home']['home_testimonial_photo']);

				// updating the data
				$final_name = 'home_testimonial_photo' . '.' . $ext;
				move_uploaded_file($path_tmp, './public/uploads/' . $final_name);

				$form_data = array(
					'home_testimonial_photo' => $final_name
				);
				$this->Model_page->update_home($form_data);

				$success = 'Home page testimonial photo is updated successfully!';
				$this->session->set_flashdata('success', $success);
				redirect(base_url() . 'backend/admin/page');
			} else {
				$this->session->set_flashdata('error', $error);
				redirect(base_url() . 'backend/admin/page');
			}
		}

		if (isset($_POST['form_home_blog'])) {
			$form_data = array(
				'home_blog_title'    => $this->input->post('home_blog_title'),
				'home_blog_subtitle' => $this->input->post('home_blog_subtitle'),
				'home_blog_item'     => $this->input->post('home_blog_item'),
				'home_blog_status'   => $this->input->post('home_blog_status')
			);
			$this->Model_page->update_home($form_data);
			$success = 'Home page blog information is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
		}

		if (isset($_POST['form_home_blog_photo'])) {
			$valid = 1;
			$path = $_FILES['home_blog_photo']['name'];
			$path_tmp = $_FILES['home_blog_photo']['tmp_name'];
			if ($path != '') {
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$file_name = basename($path, '.' . $ext);
				$ext_check = $this->Model_common->extension_check_photo($ext);
				if ($ext_check == FALSE) {
					$valid = 0;
					$error = 'You must have to upload jpg, jpeg, gif or png file<br>';
				}
			} else {
				$valid = 0;
				$error = 'You must have to select a photo<br>';
			}
			if ($valid == 1) {
				// removing the existing photo
				unlink('./public/uploads/' . $data['page_home']['home_blog_photo']);

				// updating the data
				$final_name = 'home_blog_photo' . '.' . $ext;
				move_uploaded_file($path_tmp, './public/uploads/' . $final_name);

				$form_data = array(
					'home_blog_photo' => $final_name
				);
				$this->Model_page->update_home($form_data);

				$success = 'Home page blog photo is updated successfully!';
				$this->session->set_flashdata('success', $success);
				redirect(base_url() . 'backend/admin/page');
			} else {
				$this->session->set_flashdata('error', $error);
				redirect(base_url() . 'backend/admin/page');
			}
		}

		if (isset($_POST['form_about'])) {
			$form_data = array(
				'about_heading' => $this->input->post('about_heading'),
				'about_content' => $this->input->post('about_content'),
				'mt_about'      => $this->input->post('mt_about'),
				'mk_about'      => $this->input->post('mk_about'),
				'md_about'      => $this->input->post('md_about')
			);
			$this->Model_page->update_about($form_data);
			$success = 'About Page Setting is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
		}

		if (isset($_POST['form_job'])) {
			$form_data = array(
				'job_heading' => $this->input->post('job_heading'),
				'job_content' => $this->input->post('job_content'),
				'mt_job'      => $this->input->post('mt_job'),
				'mk_job'      => $this->input->post('mk_job'),
				'md_job'      => $this->input->post('md_job')
			);
			$this->Model_page->update_job($form_data);
			$success = 'Job Page Setting is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
		}

		if (isset($_POST['form_impressum'])) {
			$form_data = array(
				'impressum_heading' => $this->input->post('impressum_heading'),
				'impressum_content' => $this->input->post('impressum_content'),
				'mt_impressum'      => $this->input->post('mt_impressum'),
				'mk_impressum'      => $this->input->post('mk_impressum'),
				'md_impressum'      => $this->input->post('md_impressum')
			);
			$this->Model_page->update_impressum($form_data);
			$success = 'Impressum Page Setting is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
		}

		if (isset($_POST['form_datenschutz'])) {
			$form_data = array(
				'datenschutz_heading' => $this->input->post('datenschutz_heading'),
				'datenschutz_content' => $this->input->post('datenschutz_content'),
				'mt_datenschutz'      => $this->input->post('mt_datenschutz'),
				'mk_datenschutz'      => $this->input->post('mk_datenschutz'),
				'md_datenschutz'      => $this->input->post('md_datenschutz')
			);
			$this->Model_page->update_datenschutz($form_data);
			$success = 'Datenschutz Page Setting is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
		}
		
		if (isset($_POST['form_agb'])) {
			$form_data = array(
				'agb_heading' => $this->input->post('agb_heading'),
				'agb_content' => $this->input->post('agb_content'),
				'mt_agb'      => $this->input->post('mt_agb'),
				'mk_agb'      => $this->input->post('mk_agb'),
				'md_agb'      => $this->input->post('md_agb')
			);
			$this->Model_page->update_agb($form_data);
			$success = 'Agb Page Setting is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
		}
		
		if (isset($_POST['form_wiederruf'])) {
			$form_data = array(
				'wiederruf_heading' => $this->input->post('wiederruf_heading'),
				'wiederruf_content' => $this->input->post('wiederruf_content'),
				'mt_wiederruf'      => $this->input->post('mt_wiederruf'),
				'mk_wiederruf'      => $this->input->post('mk_wiederruf'),
				'md_wiederruf'      => $this->input->post('md_wiederruf')
			);
			$this->Model_page->update_wiederruf($form_data);
			$success = 'Wiederruf Page Setting is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
		}

		if (isset($_POST['form_faq'])) {
			$form_data = array(
				'faq_heading' => $this->input->post('faq_heading'),
				'mt_faq'      => $this->input->post('mt_faq'),
				'mk_faq'      => $this->input->post('mk_faq'),
				'md_faq'      => $this->input->post('md_faq')
			);
			$this->Model_page->update_faq($form_data);
			$success = 'FAQ Page Setting is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
		}

		if (isset($_POST['form_service'])) {
			$form_data = array(
				'service_heading' => $this->input->post('service_heading'),
				'mt_service'      => $this->input->post('mt_service'),
				'mk_service'      => $this->input->post('mk_service'),
				'md_service'      => $this->input->post('md_service')
			);
			$this->Model_page->update_service($form_data);
			$success = 'Service Page Setting is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
		}

		if (isset($_POST['form_testimonial'])) {
			$form_data = array(
				'testimonial_heading' => $this->input->post('testimonial_heading'),
				'mt_testimonial'      => $this->input->post('mt_testimonial'),
				'mk_testimonial'      => $this->input->post('mk_testimonial'),
				'md_testimonial'      => $this->input->post('md_testimonial')
			);
			$this->Model_page->update_testimonial($form_data);
			$success = 'Testimonial Page Setting is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
		}

		if (isset($_POST['form_news'])) {
			$form_data = array(
				'news_heading' => $this->input->post('news_heading'),
				'mt_news'      => $this->input->post('mt_news'),
				'mk_news'      => $this->input->post('mk_news'),
				'md_news'      => $this->input->post('md_news')
			);
			$this->Model_page->update_news($form_data);
			$success = 'News Page Setting is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
		}

		if (isset($_POST['form_event'])) {
			$form_data = array(
				'event_heading' => $this->input->post('event_heading'),
				'mt_event'      => $this->input->post('mt_event'),
				'mk_event'      => $this->input->post('mk_event'),
				'md_event'      => $this->input->post('md_event')
			);
			$this->Model_page->update_event($form_data);
			$success = 'Event Page Setting is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
		}

		if (isset($_POST['form_contact'])) {
			$form_data = array(
				'contact_heading' => $this->input->post('contact_heading'),
				'contact_address' => $this->input->post('contact_address'),
				'contact_email'   => $this->input->post('contact_email'),
				'contact_phone'   => $this->input->post('contact_phone'),
				'contact_map'     => $this->input->post('contact_map'),
				'mt_contact'      => $this->input->post('mt_contact'),
				'mk_contact'      => $this->input->post('mk_contact'),
				'md_contact'      => $this->input->post('md_contact')
			);
			$this->Model_page->update_contact($form_data);
			$success = 'Contact Page Setting is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
		}

		if (isset($_POST['form_search'])) {
			$form_data = array(
				'search_heading' => $this->input->post('search_heading'),
				'mt_search'      => $this->input->post('mt_search'),
				'mk_search'      => $this->input->post('mk_search'),
				'md_search'      => $this->input->post('md_search')
			);
			$this->Model_page->update_search($form_data);
			$success = 'Search Page Setting is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
		}

		if (isset($_POST['form_term'])) {
			$form_data = array(
				'term_heading' => $this->input->post('term_heading'),
				'term_content' => $this->input->post('term_content'),
				'mt_term'      => $this->input->post('mt_term'),
				'mk_term'      => $this->input->post('mk_term'),
				'md_term'      => $this->input->post('md_term')
			);
			$this->Model_page->update_term($form_data);
			$success = 'Term Page Setting is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
		}

		if (isset($_POST['form_privacy'])) {
			$form_data = array(
				'privacy_heading' => $this->input->post('privacy_heading'),
				'privacy_content' => $this->input->post('privacy_content'),
				'mt_privacy'      => $this->input->post('mt_privacy'),
				'mk_privacy'      => $this->input->post('mk_privacy'),
				'md_privacy'      => $this->input->post('md_privacy')
			);
			$this->Model_page->update_privacy($form_data);
			$success = 'Privacy Page Setting is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
		}

		if (isset($_POST['form_team'])) {
			$form_data = array(
				'team_heading' => $this->input->post('team_heading'),
				'mt_team'      => $this->input->post('mt_team'),
				'mk_team'      => $this->input->post('mk_team'),
				'md_team'      => $this->input->post('md_team')
			);
			$this->Model_page->update_team($form_data);
			$success = 'Team Page Setting is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
		}

		if (isset($_POST['form_portfolio'])) {
			$form_data = array(
				'portfolio_heading' => $this->input->post('portfolio_heading'),
				'mt_portfolio'      => $this->input->post('mt_portfolio'),
				'mk_portfolio'      => $this->input->post('mk_portfolio'),
				'md_portfolio'      => $this->input->post('md_portfolio')
			);
			$this->Model_page->update_portfolio($form_data);
			$success = 'Portfolio Page Setting is updated successfully!';
			$this->session->set_flashdata('success', $success);

			$form_data[] = 	array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success));

			echo json_encode($form_data);
		}
	}
}
