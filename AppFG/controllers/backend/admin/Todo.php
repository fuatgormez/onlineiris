<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Todo extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('id')) {
            redirect(base_url().'backend/admin/login');
            exit;
        }
        $this->load->library('logger/logger');

        $this->load->model('backend/admin/Model_common');
        $this->load->model('backend/admin/Model_todo');

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
        $data['todo'] = $this->Model_todo->show();

        $this->load->view('backend/admin/view_header', $data);
        $this->load->view('backend/admin/view_todo', $data);
        $this->load->view('backend/admin/view_footer');
    }

    public function add()
    {
        $data['setting'] = $this->Model_common->get_setting_data();

        $error = '';
        $success = '';

        if (isset($_POST['form1'])) {

            $valid = 1;

            $this->form_validation->set_rules('todo_title', 'TODO title', 'trim|required');
            $this->form_validation->set_rules('todo_content', 'TODO content', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $valid = 0;
                $error = validation_errors();
            }

            if ($valid == 1) {
                $form_data = array(
                    'todo_title'     => $this->input->post('todo_title'),
                    'todo_content'   => $this->input->post('todo_content'),
                    'is_completed'   => 0,
                );

                $this->Model_todo->add($form_data);

                $success = 'TODO is added successfully!';
                $this->session->set_flashdata('success', $success);

                $this->logger->user($this->session->userdata('username'))->type('todo')->id(1)->token(sha1(mt_rand()))->comment($success)->log();

                $form_data[] =     array_push($form_data, array('csrf_fg' => $this->security->get_csrf_hash(), 'responseMessage' => $success, 'url' => base_url('backend/admin/todo')));

                echo json_encode($form_data);
            } else {
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . 'backend/admin/todo');
            }
        } else {
            $this->load->view('backend/admin/view_header', $data);
            $this->load->view('backend/admin/view_todo_add', $data);
            $this->load->view('backend/admin/view_footer');
        }
    }

    public function edit($id)
    {

        // If there is no TODO in this id, then redirect
        $tot = $this->Model_todo->todo_check($id);
        if (!$tot) {
            redirect(base_url() . 'backend/admin/todo');
            exit;
        }

        $data['setting'] = $this->Model_common->get_setting_data();
        $error = '';
        $success = '';


        if (isset($_POST['form1'])) {
            $valid = 1;

            $this->form_validation->set_rules('todo_title', 'TODO title', 'trim|required');
            $this->form_validation->set_rules('todo_content', 'TODO content', 'required');

            if ($this->form_validation->run() == FALSE) {
                $valid = 0;
                $error = validation_errors();
            }

            if ($valid == 1) {
                $data['todo'] = $this->Model_todo->getData($id);

                $is_completed = $this->input->post('is_completed') ? 1 : 0;

                $form_data = array(
                    'todo_title'     => $this->input->post('todo_title'),
                    'todo_content'   => $this->input->post('todo_content'),
                    'is_completed'   => $is_completed
                );
                $this->Model_todo->update($id, $form_data);

                $success = 'TODO is updated successfully';
                $this->session->set_flashdata('success', $success);

                $this->logger->user($this->session->userdata('username'))->type('todo')->id(1)->token(sha1(mt_rand()))->comment($success)->log();

                redirect(base_url() . 'backend/admin/todo');
            } else {
                $this->session->set_flashdata('error', $error);

                $this->logger->user($this->session->userdata('username'))->type('todo')->id(1)->token(sha1(mt_rand()))->comment('Todo update error')->log();

                redirect(base_url() . 'backend/admin/todo');
            }
        } else {
            $data['todo'] = $this->Model_todo->getData($id);
            $this->load->view('backend/admin/view_header', $data);
            $this->load->view('backend/admin/view_todo_edit', $data);
            $this->load->view('backend/admin/view_footer');
        }
    }

    public function delete($id)
    {
        if (in_array($this->session->userdata('role'), ['Superadmin'])) {
            
            // If there is no TODO in this id, then redirect
            $tot = $this->Model_todo->todo_check($id);
            if (!$tot) {
                redirect(base_url() . 'backend/admin/todo');
                exit;
            }

            $this->Model_todo->delete($id);
            $message = 'TODO is deleted successfully';
            $this->session->set_flashdata('success', $message);

        } else {
            $message = 'You are not authorized to access!';
            $this->session->set_flashdata('error', $message);
        }
        

        $this->logger->user($this->session->userdata('username'))->type('todo')->id(1)->token(sha1(mt_rand()))->comment($message)->log();

        redirect(base_url() . 'backend/admin/todo');
    }
}
