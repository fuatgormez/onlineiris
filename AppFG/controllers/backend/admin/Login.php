<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper("cookie");
        $this->load->library('logger/logger');

        $this->load->model('backend/admin/Model_login');
    }

    public function index()
    {
        if ($this->session->userdata('id')) {
            redirect(base_url() . 'backend/admin/dashboard');
        }
        $error = '';

        $data['setting'] = $this->Model_login->get_setting_data();
        $data['all_land'] = $this->Model_login->get_all_land();

        if (isset($_POST['form1'])) {

            // Getting the form data
            $username = $this->input->post('username', true);
            $password = $this->input->post('password', true);
            $remember = $this->input->post('password', true);

            $land_id = $this->input->post('land_id', true);

            // Checking the username
            $un = $this->Model_login->check_user($username);

            if (!$un) {
                $error = 'Username is wrong!';
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . 'backend/admin');
            } else {

                $check_land = $this->Model_login->check_land($land_id);

                if (empty($check_land)) {
                    $this->session->set_flashdata('error', 'Country information not found!');
                    redirect(base_url() . 'backend/admin');
                }

                // When username found, checking the password
                $user_data = array(
                    'username' => $username,
                    'password' => sha1($password)
                );
                $pw = $this->Model_login->check_password($user_data);

                if (!$pw) {

                    $error = 'Password is wrong!';
                    $this->session->set_flashdata('error', $error);
                    $this->logger->user($username)->type('login')->id(1)->token(sha1(mt_rand()))->comment($error)->log();
                    redirect(base_url() . 'backend/admin');
                } else if($pw['status'] === "Passive") {
                    $error = 'Your account has been deactivated!';
                    $this->session->set_flashdata('error', $error);
                    $this->logger->user($username)->type('login error')->id(1)->token(sha1(mt_rand()))->comment($error)->log();
                    redirect(base_url() . 'backend/admin');
                } else {

                    $remember = $this->input->post("remember", true);

                    if ($remember == 1) {
                        $cookie = array(
                            'name'   => 'remember',
                            'value'  => '1',
                            'expire' => '31536000',
                            'path'   => '/'
                        );
                        $this->input->set_cookie($cookie);
                    } else {
                        delete_cookie("remember");
                    }

                    // When username and password both are correct
                    $array = array(
                        'id' => $pw['id'],
                        'username' => $pw['username'],
                        'password' => $pw['password'],
                        'photo' => $pw['photo'],
                        'role' => $pw['role'],
                        'status' => $pw['status'],
                        'land_id' => $check_land['store_value_id'],
                        'land_name' => $check_land['land_name'],
                        'lang_code' => $check_land['lang_code'],
                        'currency_code' => $check_land['currency_code'],
                        'currency_icon' => $check_land['currency_icon']
                    );

                    $this->session->set_userdata($array);

                    $this->logger->user($this->session->userdata('username'))->type('login')->id(1)->token(sha1(mt_rand()))->comment('Login was successfully!')->log();

                    redirect(base_url('backend/admin/dashboard'));
                }
            }
        } else {
            $this->load->view('backend/admin/view_login', $data);
        }
    }

    function logout()
    {
        $this->logger->user($this->session->userdata('username'))->type('logout')->id(1)->token(sha1(mt_rand()))->comment('Logout was successfully!')->log();

        $this->session->sess_destroy();
        redirect(base_url('backend/admin'));
    }
}
