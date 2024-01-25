<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Store extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('id')) {
            redirect(base_url() . 'backend/admin/login');
        }

        $this->load->library('logger/logger');

        $this->load->model('backend/admin/Model_common');
        $this->load->model('backend/shop/Model_store');

        $data['setting'] = $this->Model_common->get_setting_data();

        if (!in_array($this->session->userdata('role'), ['Superadmin'])) {
            if ($data['setting']['website_status_backend'] === "Passive") {
                $data['message'] = $data['setting']['website_status_backend_message'];
                redirect(base_url('backend/info'));
            }
        }

        $this->load->library('slug');
    }

    public function index()
    {
        $data['setting'] = $this->Model_common->get_setting_data();

        $data['store'] = $this->Model_store->show();

        $this->load->view('backend/admin/view_header', $data);
        $this->load->view('backend/shop/view_store', $data);
        $this->load->view('backend/admin/view_footer');
    }

    public function add()
    {
        $data['setting'] = $this->Model_common->get_setting_data();

        $error = '';
        $success = '';


        if (isset($_POST['form1'])) {

            $valid = 1;

            $this->form_validation->set_rules('store_name', 'Store Name', 'trim|required');
            $this->form_validation->set_rules('land_name', 'Land Name', 'trim|required');
            $this->form_validation->set_rules('currency_code', 'Currency Code', 'trim|required');
            $this->form_validation->set_rules('currency_icon', 'Currency Icon', 'trim|required');
            $this->form_validation->set_rules('tax', 'Tax', 'trim|numeric|required');
            $this->form_validation->set_rules('lang_code', 'Language Code', 'trim|required');
            $this->form_validation->set_rules('lang_flag', 'Language Flag', 'trim|required');
            $this->form_validation->set_rules('store_email', 'Store Email', 'trim|valid_email');

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
            } else {
                //		    	$valid = 0;
                //		        $error .= 'You must have to select a photo for featured photo<br>';
            }

            if ($valid == 1) {

                $slug = $this->slug->url($this->input->post('store_name'));

                if (!empty($ext)) {
                    $next_id = $this->Model_store->get_auto_increment_id();
                    foreach ($next_id as $row) {
                        $ai_id = $row['Auto_increment'];
                    }

                    $final_name = $slug . '-store-' . $ai_id . '.' . $ext;
                    move_uploaded_file($path_tmp, './public/uploads/store_photos/' . $final_name);
                } else {
                    $final_name = "";
                }

                $land_name = explode('@', $this->input->post('land_name'));
                $form_data = array(
                    'store_name' => $this->input->post('store_name'),
                    'land_id' => $land_name[0],
                    'land_name' => $land_name[1],
                    'slug' => $slug,

                    'short_content' => $this->input->post('short_content'),
                    'content' => $this->input->post('content'),
                    'currency_code' => $this->input->post('currency_code'),
                    'currency_icon' => $this->input->post('currency_icon'),
                    'tax' => $this->input->post('tax'),
                    'lang_code' => $this->input->post('lang_code'),
                    'lang_flag' => $this->input->post('lang_flag'),
                    'store_address' => $this->input->post('store_address'),
                    'store_email' => $this->input->post('store_email'),
                    'store_phone' => $this->input->post('store_phone'),
                    'status' => $this->input->post('store_status'),
                    'row' => $this->input->post('store_row'),
                    'photo' => $final_name
                );
                $this->Model_store->add($form_data);

                $success = 'Store is added successfully!';
                $this->session->set_flashdata('success', $success);
                redirect(base_url() . 'backend/shop/store');
            } else {
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . 'backend/shop/store/add');
            }
        } else {

            $data['store_value'] = $this->Model_store->show_value();

            $this->load->view('backend/admin/view_header', $data);
            $this->load->view('backend/shop/view_store_add', $data);
            $this->load->view('backend/admin/view_footer');
        }
    }

    public function edit($id)
    {
        if (!in_array($this->session->userdata('role'), ['Superadmin','Admin'])) {
            redirect(base_url() . 'backend/shop/store');
            exit;
        }

        // If there is no store in this id, then redirect
        $tot = $this->Model_store->store_check($id);
        if (!$tot) {
            redirect(base_url() . 'backend/shop/store');
            exit;
        }

        $data['setting'] = $this->Model_common->get_setting_data();
        $error = '';
        $success = '';


        if (isset($_POST['form1'])) {

            $valid = 1;

            // $this->form_validation->set_rules('store_name', 'Store Name', 'trim|required');
            // $this->form_validation->set_rules('land_name', 'Land Name', 'trim|required');
            $this->form_validation->set_rules('currency_code', 'Currency Code', 'trim|required');
            $this->form_validation->set_rules('currency_icon', 'Currency Icon', 'trim|required');
            $this->form_validation->set_rules('tax', 'Tax', 'trim|numeric|required');
            $this->form_validation->set_rules('lang_code', 'Language Code', 'trim|required');
            $this->form_validation->set_rules('lang_flag', 'Language Flag', 'trim|required');
            $this->form_validation->set_rules('store_email', 'Store Email', 'trim|valid_email');

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
                $data['store'] = $this->Model_store->get_store($id);

                $slug = $this->slug->url($this->input->post('store_name'));

                $land_name = explode('@', $this->input->post('land_name'));

                

                

                $form_data = array(
                    'short_content' => $this->input->post('short_content'),
                    'content' => $this->input->post('content'),
                    'currency_code' => $this->input->post('currency_code'),
                    'currency_icon' => $this->input->post('currency_icon'),
                    'tax' => $this->input->post('tax'),
                    'lang_code' => $this->input->post('lang_code'),
                    'lang_flag' => $this->input->post('lang_flag'),
                    'store_address' => $this->input->post('store_address'),
                    'store_email' => $this->input->post('store_email'),
                    'store_phone' => $this->input->post('store_phone'),
                    'status' => $this->input->post('store_status'),
                    'row' => $this->input->post('store_row')
                );

                $form_data['store_name'] = in_array($this->session->userdata('role'), ['Superadmin','Admin']) ? $this->input->post('store_name') : $data['store']['store_name'];
                $form_data['land_id'] = in_array($this->session->userdata('role'), ['Superadmin'],'Admin') ? $land_name[0] : $data['store']['land_id'];
                $form_data['land_name'] = in_array($this->session->userdata('role'), ['Superadmin','Admin']) ? $land_name[1] : $data['store']['land_name'];
                $form_data['slug'] = in_array($this->session->userdata('role'), ['Superadmin','Admin']) ? $slug : $data['store']['slug'];

                if ($path == '') {
                    $this->Model_store->update($id, $form_data);
                } else {
                    unlink('./public/uploads/store_photos/' . $data['store']['photo']);

                    $final_name = $slug . '-store-' . $id . '.' . $ext;
                    move_uploaded_file($path_tmp, './public/uploads/store_photos/' . $final_name);

                    $form_data['photo'] = $final_name;
                    $this->Model_store->update($id, $form_data);
                }

                $success = 'Store is updated successfully';
                $this->session->set_flashdata('success', $success);
                redirect(base_url() . 'backend/shop/store');
            } else {
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . 'backend/shop/store/edit/' . $id);
            }
        } else {
            $data['store'] = $this->Model_store->get_store($id);
            $data['store_value'] = $this->Model_store->show_value();
            $this->load->view('backend/admin/view_header', $data);
            $this->load->view('backend/shop/view_store_edit', $data);
            $this->load->view('backend/admin/view_footer');
        }
    }

    public function delete($id)
    {
        if(!in_array($this->session->userdata('role'), ['Superadmin'])){
            redirect(base_url() . 'backend/shop/store');
        }

        // If there is no store in this id, then redirect
        $tot = $this->Model_store->store_check($id);
        if (!$tot) {
            redirect(base_url() . 'backend/shop/store');
            exit;
        }

        $data['store'] = $this->Model_store->get_store($id);
        if ($data['store']) {
            unlink('./public/uploads/store_photos/' . $data['store']['photo']);
        }

        $this->Model_store->delete($id);
        $success = 'Store is deleted successfully';
        $this->session->set_flashdata('success', $success);
        redirect(base_url() . 'backend/shop/store');
    }

    public function value()
    {
        $data['setting'] = $this->Model_common->get_setting_data();

        $data['store_value'] = $this->Model_store->show_value();

        $this->load->view('backend/admin/view_header', $data);
        $this->load->view('backend/shop/view_store_value', $data);
        $this->load->view('backend/admin/view_footer');
    }

    public function add_value()
    {
        $data['setting'] = $this->Model_common->get_setting_data();

        $error = '';
        $success = '';

        if (isset($_POST['form1'])) {

            $valid = 1;

            $this->form_validation->set_rules('land_name', 'Land Name', 'trim|required|is_unique[tbl_shop_store_value.land_name]');
            $this->form_validation->set_rules('currency_code', 'Currency Code', 'trim|required');
            $this->form_validation->set_rules('currency_icon', 'Currency Icon', 'trim|required');
            // $this->form_validation->set_rules('currency_code', 'Currency Code', 'trim|required|is_unique[tbl_shop_store_value.currency_code]');
            // $this->form_validation->set_rules('currency_icon', 'Currency Icon', 'trim|required|is_unique[tbl_shop_store_value.currency_icon]');
            $this->form_validation->set_rules('lang_code', 'Language Code', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $valid = 0;
                $error .= validation_errors();
            }

            $path = $_FILES['lang_flag']['name'];
            $path_tmp = $_FILES['lang_flag']['tmp_name'];

            if ($path != '') {
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $file_name = basename($path, '.' . $ext);
                $ext_check = $this->Model_common->extension_check_photo($ext);
                if ($ext_check == FALSE) {
                    $valid = 0;
                    $error .= 'You must have to upload jpg, jpeg, gif or png file for featured photo<br>';
                }
            } else {
                $valid = 0;
                $error .= 'You must have to select a photo for featured photo<br>';
            }

            if ($valid == 1) {

                if (!empty($ext)) {
                    $next_id = $this->Model_store->get_store_value_auto_increment_id();
                    foreach ($next_id as $row) {
                        $ai_id = $row['Auto_increment'];
                    }

                    $final_name = trim($this->input->post('land_name')) . '_store_flag_' . $ai_id . '.' . $ext;
                    move_uploaded_file($path_tmp, './public/uploads/store_photos/flag/' . $final_name);
                } else {
                    $final_name = "";
                }

                $form_data = array(
                    'land_name' => mb_convert_case($this->input->post('land_name'), MB_CASE_TITLE, "UTF-8"),
                    'currency_code' => strtoupper($this->input->post('currency_code')),
                    'currency_icon' => $this->input->post('currency_icon'),
                    'lang_code' => $this->input->post('lang_code'),
                    'status' => $this->input->post('store_value_status'),
                    'row' => $this->input->post('store_value_row'),
                    'lang_flag' => $final_name
                );
                $this->Model_store->add_value($form_data);

                $success = 'Stores value is added successfully!';
                $this->session->set_flashdata('success', $success);
                redirect(base_url() . 'backend/shop/store/add_value');
            } else {
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . 'backend/shop/store/add_value');
            }
        } else {

            $this->load->view('backend/admin/view_header', $data);
            $this->load->view('backend/shop/view_store_add_value', $data);
            $this->load->view('backend/admin/view_footer');
        }
    }

    public function edit_value($id)
    {

        if (!in_array($this->session->userdata('role'), ['Superadmin'])) {
            redirect(base_url() . 'backend/shop/store/value');
            exit;
        }

        // If there is no store value in this id, then redirect
        $tot = $this->Model_store->store_value_check($id);
        if (!$tot) {
            redirect(base_url() . 'backend/shop/store/value');
            exit;
        }

        $data['setting'] = $this->Model_common->get_setting_data();
        $error = '';
        $success = '';

        $is_unique_land_name = "";
        $is_unique_currency_code = "";
        $is_unique_currency_icon = "";
        $is_unique_lang_code = "";

        if (isset($_POST['form1'])) {


            $valid = 1;

            if ($this->input->post('land_name') != $tot['land_name']) {
                $is_unique_land_name = '|is_unique[tbl_shop_store_value.land_name]';
            } elseif ($this->input->post('currency_code') != $tot['currency_code']) {
                $is_unique_currency_code = '|is_unique[tbl_shop_store_value.currency_code]';
            } elseif ($this->input->post('currency_icon') != $tot['currency_icon']) {
                $is_unique_currency_icon = '|is_unique[tbl_shop_store_value.currency_icon]';
            }

            $this->form_validation->set_rules('land_name', 'Land Name', 'trim|required' . $is_unique_land_name);
            $this->form_validation->set_rules('currency_code', 'Currency Code', 'trim|required' . $is_unique_currency_code);
            $this->form_validation->set_rules('currency_icon', 'Currency Icon', 'trim|required' . $is_unique_currency_icon);
            $this->form_validation->set_rules('lang_code', 'Language Code', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $valid = 0;
                $error .= validation_errors();
            }

            $path = $_FILES['lang_flag']['name'];
            $path_tmp = $_FILES['lang_flag']['tmp_name'];

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
                $data['store_value'] = $this->Model_store->get_store_value($id);

                $form_data = array(
                    'land_name' => mb_convert_case($this->input->post('land_name'), MB_CASE_TITLE, "UTF-8"),
                    'currency_code' => strtoupper($this->input->post('currency_code')),
                    'currency_icon' => $this->input->post('currency_icon'),
                    'lang_code' => $this->input->post('lang_code'),
                    'status' => $this->input->post('store_value_status'),
                    'row' => $this->input->post('store_value_row')
                );

                if ($path == '') {
                    $this->Model_store->update_value($id, $form_data);
                } else {
                    unlink('./public/uploads/store_photos/flag/' . $data['store_value']['lang_flag']);

                    $final_name = trim($this->input->post('land_name')) . '_store_flag_' . $id . '.' . $ext;
                    move_uploaded_file($path_tmp, './public/uploads/store_photos/flag/' . $final_name);

                    $form_data['lang_flag'] = $final_name;
                    $this->Model_store->update_value($id, $form_data);
                }

                $success = 'Store value is updated successfully';
                $this->session->set_flashdata('success', $success);
                redirect(base_url() . 'backend/shop/store/value');
            } else {
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . 'backend/shop/store/edit_value/' . $id);
            }
        } else {
            $data['store_value'] = $this->Model_store->get_store_value($id);
            $this->load->view('backend/admin/view_header', $data);
            $this->load->view('backend/shop/view_store_edit_value', $data);
            $this->load->view('backend/admin/view_footer');
        }
    }

    public function delete_value($id)
    {
        if(!in_array($this->session->userdata('role'), ['Superadmin'])){
            redirect(base_url() . 'backend/shop/store/value');
        }
        // If there is no store value in this id, then redirect
        $tot = $this->Model_store->store_value_check($id);
        if (!$tot) {
            redirect(base_url() . 'backend/shop/store/value');
            exit;
        }

        $data['store_value'] = $this->Model_store->get_store_value($id);
        if ($data['store_value']) {
            unlink('./public/uploads/store_photos/flag/' . $data['store_value']['lang_flag']);
        }

        $this->Model_store->delete_value($id);
        $success = 'Store value is deleted successfully!';
        $this->session->set_flashdata('success', $success);
        redirect(base_url() . 'backend/shop/store/value');
    }
}
