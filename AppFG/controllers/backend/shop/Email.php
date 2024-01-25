<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Email extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('id')) {
            redirect(base_url() . 'backend/admin/login');
        }

        $this->load->model('backend/shop/Model_common');
        $this->load->model('backend/shop/Model_email');

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

        $data['email'] = $this->Model_email->show($this->session->userdata('lang_code'));

        $this->load->view('backend/admin/view_header', $data);
        $this->load->view('backend/shop/view_email', $data);
        $this->load->view('backend/admin/view_footer');
    }

    public function add()
    {
        $error = '';
        $success = '';

        if (isset($_POST['form1'])) {

            $sku = rand(100, 10000) . time();

            $form_data = array(
                'status' => $this->input->post('status'),
                'type' => $this->input->post('type'),
                'step' => $this->input->post('step'),
                'sku' => $sku
            );

            $this->Model_email->add($form_data);

            // $postedData = $this->input->post(); summernote xss removed
            $postedData = $_POST;

            foreach ($postedData['lang'] as $key => $value) {

                if (!empty($key && $value['subject'])) {
                    $form_data_lang = array(
                        'store_id' => $key,
                        'lang_code' => $value['lang_code'],
                        'subject' => $value['subject'],
                        'message' => $value['message'],
                        'mollie' => $value['mollie'],
                        'billing' => $value['billing'],
                        'sku' => $sku
                    );
                    $this->Model_email->add_lang($form_data_lang);
                }
            }

            $success = 'Email is added successfully!';
            $this->session->set_flashdata('success', $success);
            redirect(base_url() . 'backend/shop/email');
        } else {
            $data['setting'] = $this->Model_common->get_setting_data();
            $data['all_store_value'] = $this->Model_common->get_all_store_value();

            $this->load->view('backend/admin/view_header', $data);
            $this->load->view('backend/shop/view_email_add', $data);
            $this->load->view('backend/admin/view_footer');
        }
    }


    public function edit($sku)
    {
        // If there is no email in this id, then redirect
        $tot = $this->Model_email->email_check($sku);
        if (!$tot) {
            redirect(base_url() . 'backend/shop/email');
            exit;
        }

        $data['setting'] = $this->Model_common->get_setting_data();
        $error = '';
        $success = '';

        if (isset($_POST['form1'])) {
            $valid = 1;

            if ($valid == 1) {
                $data['product_category'] = $this->Model_email->getData($sku);

                $form_data = array(
                    'type' => $this->input->post('type'),
                    'step' => $this->input->post('step'),
                    'status' => $this->input->post('status'),
                    'sku' => $sku
                );

                $this->Model_email->update($sku, $form_data);

                // $postedData = $this->input->post(); summernote xss removed yapiyor tekrar bak
                $postedData = $_POST;

                foreach ($postedData['lang'] as $key => $value) {

                    if (!empty($value['subject']) && !empty($value['message'])) {
                        if (!empty($key)) {
                            $form_data_lang = array(
                                'store_id' => $key,
                                'lang_code' => $value['lang_code'],
                                'subject' => $value['subject'],
                                'message' => $value['message'],
                                'mollie' => $value['mollie'],
                                'billing' => $value['billing'],
                                'sku' => $sku
                            );
                            $this->Model_email->update_lang($sku, $form_data_lang, $key);
                        }
                    }
                }

                $success = 'Email is updated successfully';
                $this->session->set_flashdata('success', $success);
                redirect(base_url() . 'backend/shop/email');
            } else {
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . 'backend/shop/email/edit/' . $sku);
            }
        } else {
            $data['email'] = $this->Model_email->getData($sku);
            $data['email_lang'] = $this->Model_email->getDataAll($sku);

            $data['all_store'] = $this->Model_common->get_all_store();
            $data['all_store_value'] = $this->Model_common->get_all_store_value();

            $this->load->view('backend/admin/view_header', $data);
            $this->load->view('backend/shop/view_email_edit', $data);
            $this->load->view('backend/admin/view_footer');
        }
    }

    public function editold($sku)
    {
        // If there is no product category in this id, then redirect
        $tot = $this->Model_email->email_check($sku);
        if (!$tot) {
            redirect(base_url() . 'backend/shop/email');
            exit;
        }

        $error = '';
        $success = '';

        if (isset($_POST['form1'])) {

            $form_data = array(
                'status' => $this->input->post('status'),
                'type' => $this->input->post('type'),
                'step' => $this->input->post('step'),
                'sku' => $sku
            );

            $this->Model_email->update($sku, $form_data);

            $postedData = $this->input->post();

            foreach ($postedData['lang'] as $key => $value) {

                if (!empty($key && $value['subject'])) {
                    $form_data_lang = array(
                        'store_id' => $key,
                        'lang_code' => $value['lang_code'],
                        'subject' => $value['subject'],
                        'message' => $value['message'],
                        'mollie' => $value['mollie'],
                        'billing' => $value['billing'],
                        'sku' => $sku
                    );
                    $this->Model_email->update_lang($sku, $form_data_lang, $key);
                }
            }

            $success = 'Email is updated successfully!';
            $this->session->set_flashdata('success', $success);
            redirect(base_url() . 'backend/shop/email');
        } else {
            $data['setting'] = $this->Model_common->get_setting_data();

            $data['email'] = $this->Model_email->getData($sku);
            $data['email_lang'] = $this->Model_email->getDataAll($sku);

            $data['all_store'] = $this->Model_email->get_all_store();

            $this->load->view('backend/admin/view_header', $data);
            $this->load->view('backend/shop/view_email_edit', $data);
            $this->load->view('backend/admin/view_footer');
        }
    }

    public function delete($sku)
    {
        // If there is no product category in this id, then redirect
        $tot = $this->Model_email->email_check($sku);
        if (!$tot) {
            redirect(base_url() . 'backend/shop/email');
            exit;
        }

        $data['email'] = $this->Model_email->getData($sku);
        if ($data['email']) {
            unlink('./public/email/' . $data['email']['attachment']);
        }

        $this->Model_email->delete($sku);

        $success = 'Email is deleted successfully';
        $this->session->set_flashdata('success', $success);
        redirect(base_url() . 'backend/shop/email');
    }
}
