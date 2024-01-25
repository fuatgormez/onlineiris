<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_category extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('backend/shop/Model_common');
        $this->load->model('backend/shop/Model_product_category');

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

        $data['product_category'] = $this->Model_product_category->show($this->session->userdata('lang_code'));

        $this->load->view('backend/admin/view_header', $data);
        $this->load->view('backend/shop/view_product_category', $data);
        $this->load->view('backend/admin/view_footer');
    }

    public function add()
    {
        $data['setting'] = $this->Model_common->get_setting_data();

        $error = '';
        $success = '';

        if (isset($_POST['form1'])) {

            $valid = 1;

            $path = $_FILES['photo']['name'];
            $path_banner = $_FILES['banner']['name'];
            $path_video = $_FILES['video']['name'];

            $path_tmp = $_FILES['photo']['tmp_name'];
            $path_tmp_banner = $_FILES['banner']['tmp_name'];
            $path_tmp_video = $_FILES['video']['tmp_name'];

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
                $next_id = $this->Model_product_category->get_auto_increment_id();
                foreach ($next_id as $row) {
                    $ai_id = $row['Auto_increment'];
                }

                $final_name_banner = "";
                $final_name_video = "";

                if (!empty($path_tmp)) {
                    $final_name = 'product_category_' . $ai_id . '.' . $ext;
                    move_uploaded_file($path_tmp, './public/uploads/product_category_photos/thumbnail/' . $final_name);
                }
                if (!empty($path_banner)) {
                    $final_name_banner = 'product_category_banner_' . $ai_id . '_' . $path_banner;
                    move_uploaded_file($path_tmp_banner, './public/uploads/product_category_photos/banner/' . $final_name_banner);
                }
                if (!empty($path_banner)) {
                    $final_name_video = 'product_category_video_' . $ai_id . '_' . $path_video;
                    move_uploaded_file($path_tmp_video, './public/uploads/product_category_photos/video/' . $final_name_video);
                }

                $form_data = array(
                    'thumbnail_photo' => $final_name,
                    'category_banner' => $final_name_banner,
                    'category_video' => $final_name_video,
                    'row' => $this->input->post('product_category_row'),
                    'status' => $this->input->post('product_category_status'),
                    'category_sku' => $this->input->post('category_sku')
                );

                $this->Model_product_category->add($form_data);

                $postedData = $this->input->post();

                foreach ($postedData['lang'] as $key => $value) {
                    $slug = $this->slug->url($value['category_name']);

                    if (!empty($key && $value['category_name'])) {
                        $form_data_lang = array(
                            'product_category_id' => $ai_id,
                            'land_id' => $key,
                            'lang_code' => $value['lang_code'],
                            'category_name' => $value['category_name'],
                            'category_subname' => $value['category_subname'],
                            'slug' => $slug,
                            'short_description' => $value['short_description'],
                            'description' => $value['description'],
                            'meta_title' => $value['meta_title'],
                            'meta_keyword' => $value['meta_keyword'],
                            'meta_description' => $value['meta_description']
                        );
                        $this->Model_product_category->add_lang($form_data_lang);
                    }
                }


                if (isset($_FILES['photos']["name"]) && isset($_FILES['photos']["tmp_name"])) {
                    $photos = array();
                    $photos = $_FILES['photos']["name"];
                    $photos = array_values(array_filter($photos));

                    $photos_temp = array();
                    $photos_temp = $_FILES['photos']["tmp_name"];
                    $photos_temp = array_values(array_filter($photos_temp));

                    $next_id1 = $this->Model_product_category->get_auto_increment_id1();
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
                            move_uploaded_file($photos_temp[$i], "./public/uploads/product_category_photos/" . $final_names[$m]);
                            $m++;
                            $z++;
                        }
                    }
                }

                for ($i = 0; $i < count($final_names); $i++) {
                    $form_data = array(
                        'product_category_id' => $ai_id,
                        'photo' => $final_names[$i]
                    );
                    $this->Model_product_category->add_photos($form_data);
                }


                $success = 'Product category is added successfully!';
                $this->session->set_flashdata('success', $success);
                redirect(base_url() . 'backend/shop/product_category');
            } else {
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . 'backend/shop/product_category/add');
            }
        } else {
            $data['all_store'] = $this->Model_common->get_all_store();
            $data['all_store_value'] = $this->Model_common->get_all_store_value();

            $this->load->view('backend/admin/view_header', $data);
            $this->load->view('backend/shop/view_product_category_add', $data);
            $this->load->view('backend/admin/view_footer');
        }
    }

    public function edit($id)
    {

        // If there is no product category in this id, then redirect
        $tot = $this->Model_product_category->product_category_check($id);
        if (!$tot) {
            redirect(base_url() . 'backend/shop/product_category');
            exit;
        }

        $data['setting'] = $this->Model_common->get_setting_data();
        $error = '';
        $success = '';


        if (isset($_POST['form1'])) {
            $valid = 1;

            $path = $_FILES['photo']['name'];
            $path_banner = $_FILES['banner']['name'];
            $path_video = $_FILES['video']['name'];

            $path_tmp = $_FILES['photo']['tmp_name'];
            $path_tmp_banner = $_FILES['banner']['tmp_name'];
            $path_tmp_video = $_FILES['video']['tmp_name'];

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
                $data['product_category'] = $this->Model_product_category->getData($id);

                $form_data = array(
                    'row' => $this->input->post('product_category_row'),
                    'status' => $this->input->post('product_category_status'),
                    'category_sku' => $this->input->post('category_sku'),
                    'block_the_sale' => $this->input->post('block_the_sale')
                );

                $final_name = 'product_category_' . $id . '.' . $ext;
                $final_name_banner = 'product_category_' . $id . '_' . $path_banner;
                $final_name_video = 'product_category_' . $id . '_' . $path_video;

                if (!empty($path)) {
                    $form_data['thumbnail_photo'] = $final_name;
                    move_uploaded_file($path_tmp, './public/uploads/product_category_photos/thumbnail/' . $final_name);
                }
                if (!empty($path_banner)) {
                    $form_data['category_banner'] = $final_name_banner;
                    move_uploaded_file($path_tmp_banner, './public/uploads/product_category_photos/banner/' . $final_name_banner);
                }
                if (!empty($path_video)) {
                    $form_data['category_video'] = $final_name_video;
                    move_uploaded_file($path_tmp_video, './public/uploads/product_category_photos/video/' . $final_name_video);
                }

                $this->Model_product_category->update($id, $form_data);

                $postedData = $this->input->post();

                foreach ($postedData['lang'] as $key => $value) {
                    $slug = $this->slug->url($value['category_name']);

                    if (!empty($key) && !empty($value['category_name'])) {
                        $form_data_lang = array(
                            'product_category_id' => $id,
                            'land_id' => $key,
                            'lang_code' => $value['lang_code'],
                            'category_name' => $value['category_name'],
                            'category_subname' => $value['category_subname'],
                            'slug' => $slug,
                            'short_description' => $value['short_description'],
                            'description' => $value['description'],
                            'meta_title' => $value['meta_title'],
                            'meta_keyword' => $value['meta_keyword'],
                            'meta_description' => $value['meta_description']
                        );
                        $this->Model_product_category->update_lang($id, $form_data_lang, $key);
                    }
                }

                if (isset($_FILES['photos']["name"]) && isset($_FILES['photos']["tmp_name"])) {
                    $photos = array();
                    $photos = $_FILES['photos']["name"];
                    $photos = array_values(array_filter($photos));

                    $photos_temp = array();
                    $photos_temp = $_FILES['photos']["tmp_name"];
                    $photos_temp = array_values(array_filter($photos_temp));

                    $next_id1 = $this->Model_product_category->get_auto_increment_id1();
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
                            move_uploaded_file($photos_temp[$i], "./public/uploads/product_category_photos/" . $final_names[$m]);
                            $m++;
                            $z++;
                        }
                    }
                }

                for ($i = 0; $i < count($final_names); $i++) {
                    $form_data = array(
                        'product_category_id' => $id,
                        'photo' => $final_names[$i]
                    );
                    $this->Model_product_category->add_photos($form_data);
                }

                $success = 'Product category is updated successfully';
                $this->session->set_flashdata('success', $success);
                redirect(base_url() . 'backend/shop/product_category');
            } else {
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . 'backend/shop/product_category/edit/' . $id);
            }
        } else {
            $data['product_category'] = $this->Model_product_category->getData($id);
            $data['product_category_lang'] = $this->Model_product_category->getDataAll($id);

            $data['all_photos_by_id'] = $this->Model_product_category->get_all_photos_by_category_id($id);

            $data['all_store'] = $this->Model_common->get_all_store();
            $data['all_store_value'] = $this->Model_common->get_all_store_value();

            $this->load->view('backend/admin/view_header', $data);
            $this->load->view('backend/shop/view_product_category_edit', $data);
            $this->load->view('backend/admin/view_footer');
        }
    }

    public function delete($id)
    {
        // If there is no product category in this id, then redirect
        $tot = $this->Model_product_category->product_category_check($id);
        if (!$tot) {
            redirect(base_url() . 'backend/shop/product_category');
            exit;
        }

        $data['product_category'] = $this->Model_product_category->getData($id);
        if ($data['product_category']) {
            unlink('./public/uploads/product_category_photos/thumbnail/' . $data['product_category']['thumbnail_photo']);
        }

        $data['product_category_photos'] = $this->Model_product_category->get_all_photos_by_category_id($id);

        foreach ($data['product_category_photos'] as $multiple_delete_photo) {
            unlink('./public/uploads/product_category_photos/' . $multiple_delete_photo['photo']);
        }

        $this->Model_product_category->delete($id);
        $this->Model_product_category->delete_photos($id);

        $success = 'Product category is deleted successfully';
        $this->session->set_flashdata('success', $success);
        redirect(base_url() . 'backend/shop/product_category');
    }

    public function single_photo_delete($photo_id = 0, $product_category_id = 0)
    {

        $product_category_photo = $this->Model_product_category->product_category_photo_by_id($photo_id);
        unlink('./public/uploads/product_category_photos/' . $product_category_photo['photo']);

        $this->Model_product_category->delete_product_category_photo($photo_id);

        redirect(base_url() . 'backend/shop/product_category/edit/' . $product_category_id);
    }
}
