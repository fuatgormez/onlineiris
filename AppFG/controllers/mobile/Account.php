<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Account extends CI_Controller
{
    private $auth;

    function __construct()
    {
        parent::__construct();

        $this->load->model('Model_common');
        $this->load->model('Model_user');

        $this->load->helper("cookie");
        // if($this->router->fetch_method() !== "logout")
    }

    public function index(){
        $this->session->userdata('id') ? redirect(base_url('mobile/shop')) : redirect(base_url('mobile/account/logout'));
    }

    public function login()
    {
        $data['setting'] = $this->Model_common->all_setting();
        $this->auth ? 'var' : 'yok';
        $error = '';

        if($this->session->userdata('id'))
            redirect(base_url('mobile/shop'));

        if (isset($_POST['form1'])){
            // Getting the form data
            $username = $this->input->post('username', true);
            $password = $this->input->post('password', true);

            // Checking the username
            $un = $this->Model_user->checkUsername($username);

            if (!$un) {
                // exit('!un');
                $error = 'Username is wrong!';
                $this->session->set_flashdata('error', $error);
                redirect(base_url('mobile/account/login'));
            } else {
                // When username found, checking the password
                $user_data = array(
                    'username' => $username,
                    'password' => sha1($password)
                );
                $pw = $this->Model_user->checkPassword($user_data);

                if (!$pw) {
                    // exit('!pw');
                    $error = 'Password is wrong!';
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url('mobile/account/login'));
                } else if($pw['status'] === "Passive") {
                    // exit('passive');
                    $error = 'Your account has been deactivated!';
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url('account/mobile/login'));
                } else {
                    // exit('remember:'.$this->input->post("remember", true));
                    $remember = $this->input->post("remember", true);
                    if ($remember == 1) {
                        $this->cookie->backendLogin();
                    } else {
                        delete_cookie("remember");
                    }

                    // When username and password both are correct
                    $array = array(
                        'id' => $pw['id'],
                        'username' => $pw['username'],
                        'password' => $pw['password'],
                        'firstname' => $pw['firstname'],
                        'lastname' => $pw['lastname'],
                        'email' => $pw['email'],
                        'photo' => $pw['photo'],
                        'role' => $pw['role'],
                        'status' => $pw['status']
                    );

                    $this->session->set_userdata($array);
                    redirect(base_url('mobile/shop'));
                }
            }
        } else {
            $this->load->view('layout/mobile/view_header', $data);
			if($data['setting']['website_status_mobile'] === 'Active' || in_array($this->session->userdata('role'), ['Superadmin','Admin']))
			{
				$this->load->view('layout/mobile/view_login',$data);
			} else {
				$this->load->view('layout/mobile/view_maintenance', $data);
			}
			$this->load->view('layout/mobile/view_footer', $data);
        }
    }

    function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('mobile/account/login'));
    }

    public function profile($id)
    {
        try {
            $data['setting'] = $this->Model_common->all_setting();
            $data['profile'] = $this->Model_user->getUserById($id);

            $this->load->view('layout/mobile/view_header', $data);
            if($data['setting']['website_status_mobile'] === 'Active' || in_array($this->session->userdata('role'), ['Superadmin','Admin']))
            {
                $this->load->view('layout/mobile/view_profile',$data);
            } else {
                $this->load->view('layout/mobile/view_maintenance', $data);
            }
            $this->load->view('layout/mobile/view_footer', $data);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function forgot_password()
    {
        if($this->session->userdata('id'))
            redirect(base_url('mobile/home'));
        try {
            $data['setting'] = $this->Model_common->all_setting();
            // $data['profile'] = $this->Model_user->getUserById($id);

            $this->load->view('layout/mobile/view_header', $data);
            if($data['setting']['website_status_mobile'] === 'Active' || in_array($this->session->userdata('role'), ['Superadmin','Admin']))
            {
                $this->load->view('layout/mobile/view_forgot_password',$data);
            } else {
                $this->load->view('layout/mobile/view_maintenance', $data);
            }
            $this->load->view('layout/mobile/view_footer', $data);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function sms_confirm()
    {
        if($this->session->userdata('id'))
            redirect(base_url('mobile/home'));
        try {

            if($this->input->post('phone')) {
                $valid = 1;
                $error = '';
                $this->form_validation->set_rules('phone', 'Mobile Number ', 'trim|required|regex_match[/^[0-9]{11}$/]'); //{10} for 10 digits number

                if($this->form_validation->run() == FALSE) {
                    $valid = 0;
                    $error .= validation_errors();
                }

                if($valid == 1) {
                    $sms_code = random_int(100000,999999);
                    $this->session->set_userdata('sms_code', $sms_code);

                    $this->load->library('sms');
                    $this->sms->twilio($sms_code);

                    $data['setting'] = $this->Model_common->all_setting();
                    // $data['profile'] = $this->Model_user->getUserById($id);
                    $this->load->view('layout/mobile/view_header', $data);
                    if($data['setting']['website_status_mobile'] === 'Active' || in_array($this->session->userdata('role'), ['Superadmin','Admin']))
                    {
                        $this->load->view('layout/mobile/view_sms_confirm',$data);
                    } else {
                        $this->load->view('layout/mobile/view_maintenance', $data);
                    }
                    $this->load->view('layout/mobile/view_footer', $data);
                } else {
                    $this->session->set_flashdata('error','Invalid Phone Number');
                    redirect(base_url('mobile/account/forgot-password'));
                }
            } else if(isset($_POST['sms_confirm'])) {

                $valid = 1;
                $error = '';
                $this->form_validation->set_rules('digit-1', 'code', 'trim|required|regex_match[/^[0-9]{1}$/]');
                $this->form_validation->set_rules('digit-2', 'code', 'trim|required|regex_match[/^[0-9]{1}$/]');
                $this->form_validation->set_rules('digit-3', 'code', 'trim|required|regex_match[/^[0-9]{1}$/]');
                $this->form_validation->set_rules('digit-4', 'code', 'trim|required|regex_match[/^[0-9]{1}$/]');
                $this->form_validation->set_rules('digit-5', 'code', 'trim|required|regex_match[/^[0-9]{1}$/]');
                $this->form_validation->set_rules('digit-6', 'code', 'trim|required|regex_match[/^[0-9]{1}$/]');

                if($this->form_validation->run() == FALSE) {
                    $valid = 0;
                    $error .= validation_errors();
                }

                if($valid == 0){
                    $this->session->set_flashdata('error', $error);
                    exit(json_encode(array('status' => 'invalid', 'message' => $error)));
                }

                $sms_code = $this->input->post('digit-1') . $this->input->post('digit-2') . $this->input->post('digit-3') . $this->input->post('digit-4') . $this->input->post('digit-5') . $this->input->post('digit-6');
                if($this->session->userdata('sms_code') == $sms_code){
                    exit(json_encode(array('status' => 'valid', 'message' => 'success')));
                } else {
                    exit(json_encode(array('status' => 'not_match', 'message' => 'The code does not match')));
                }
            } else {
                redirect(base_url('mobile/account/forgot-password'));
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function checkSession()
    {
        if ($this->session->userdata('id')) {
            $this->auth = true;
        } else {
            $this->auth = false;
        }
    }
}
