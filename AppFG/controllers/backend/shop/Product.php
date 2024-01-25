<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('id')) {
            redirect(base_url() . 'backend/admin/login');
        }

        $this->load->model('backend/shop/Model_common');
        $this->load->model('backend/shop/Model_product');

        $data['setting'] = $this->Model_common->get_setting_data();

        if (!in_array($this->session->userdata('role'), ['Superadmin'])) {
            if ($data['setting']['website_status_backend'] === "Passive") {
                $data['message'] = $data['setting']['website_status_backend_message'];
                redirect(base_url('backend/info'));
            }
        }

        $this->load->library('slug');

        ini_set('post_max_size', '256M');
        ini_set('upload_max_filesize', '256M');
    }

    public function index()
    {
        $data['setting'] = $this->Model_common->get_setting_data();

        $data['products'] = $this->Model_product->show($this->session->userdata('lang_code'));
        // $data['products'] = count($this->Model_product->show($lang)) > 0 ? $this->Model_product->show($lang) : $this->Model_product->show('de');
        //        $data['product_categories'] = $this->Model_product->get_all_product_category();

        $this->load->view('backend/admin/view_header', $data);
        $this->load->view('backend/shop/view_product', $data);
        $this->load->view('backend/admin/view_footer');
    }

    public function add()
    {
        $data['setting'] = $this->Model_common->get_setting_data();

        $error = '';
        $success = '';

        if (isset($_POST['form1'])) {

            if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin', 'Ads'])) {
                redirect(base_url() . 'backend/shop/product');
            }

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

            // if($_FILES['photo']['name'])


            if ($valid == 1) {
                $next_id = $this->Model_product->get_auto_increment_id();
                foreach ($next_id as $row) {
                    $ai_id = $row['Auto_increment'];
                }

                $final_name = 'product_' . $ai_id . '.' . $ext;
                $final_name_banner = 'product_banner_' . $ai_id . '.' . $ext;
                $final_name_video = 'product_video_' . $ai_id . '.' . $ext;


                $final_name_banner = "";
                $final_name_video = "";

                if (!empty($path_tmp)) {
                    $final_name = 'product_' . $ai_id . '.' . $ext;
                    move_uploaded_file($path_tmp, './public/uploads/product_photos/thumbnail/' . $final_name);
                }
                if (!empty($path_banner)) {
                    $final_name_banner = 'product_banner_' . $ai_id . '_' . $path_banner;
                    move_uploaded_file($path_tmp_banner, './public/uploads/product_photos/banner/' . $final_name_banner);
                }
                if (!empty($path_banner)) {
                    $final_name_video = 'product_video_' . $ai_id . '_' . $path_video;
                    move_uploaded_file($path_tmp_video, './public/uploads/product_photos/video/' . $final_name_video);
                }

                //$array = $this->input->post('lang');

                $category_id = '';
                // get single category_id for tbl_product table
                foreach ($this->input->post('lang') as $single_category_id) {
                    $category_id = $single_category_id['category_id'];
                    break;
                }

                $form_data = array(
                    'category_id' => $category_id,
                    'thumbnail' => $final_name,
                    'banner' => $final_name_banner,
                    'video' => $final_name_video,
                    'with_name' => $this->input->post('with_name'),
                    'with_name_price' => $this->input->post('with_name_price'),
                    'with_name_allow' => $this->input->post('with_name_allow'),
                    'eye_quantity' => $this->input->post('eye_quantity'),
                    'product_type' => $this->input->post('product_type'),
                    'product_sku' => $this->input->post('product_sku'),
                    'status' => $this->input->post('product_status'),
                    'row' => $this->input->post('product_row')
                );

                $this->Model_product->add($form_data);

                $postedData = $this->input->post();

                foreach ($postedData['lang'] as $key => $value) {

                    $slug = $this->slug->url($value['product_name']);

                    if (!empty($key && $value['product_name'])) {
                        $form_data_lang = array(
                            'product_id' => $ai_id,
                            'land_id' => $key,
                            'lang_code' => $value['lang_code'],
                            'product_name' => $value['product_name'],
                            'product_subname' => $value['product_subname'],
                            'slug' => $slug,
                            'short_content' => $value['short_content'],
                            'content' => $value['content'],
                            'product_price' => $value['product_price'],
                            'product_price_old' => $value['product_price_old'],
                            'meta_title' => $value['meta_title'],
                            'meta_keyword' => $value['meta_keyword'],
                            'meta_description' => $value['meta_description']
                        );
                        $this->Model_product->add_lang($form_data_lang);
                    }
                }


                if (isset($_FILES['photos']["name"]) && isset($_FILES['photos']["tmp_name"])) {
                    $photos = array();
                    $photos = $_FILES['photos']["name"];
                    $photos = array_values(array_filter($photos));

                    $photos_temp = array();
                    $photos_temp = $_FILES['photos']["tmp_name"];
                    $photos_temp = array_values(array_filter($photos_temp));

                    $next_id1 = $this->Model_product->get_auto_increment_id1();
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
                            move_uploaded_file($photos_temp[$i], "./public/uploads/product_photos/" . $final_names[$m]);
                            $m++;
                            $z++;
                        }
                    }
                }

                for ($i = 0; $i < count($final_names); $i++) {
                    $form_data = array(
                        'product_id' => $ai_id,
                        'photo' => $final_names[$i]
                    );
                    $this->Model_product->add_photos($form_data);
                }

                $success = 'Product is added successfully!';
                $this->session->set_flashdata('success', $success);
                redirect(base_url() . 'backend/shop/product');
            } else {
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . 'backend/shop/product/add');
            }
        } else {
            $data['all_product_category'] = $this->Model_product->get_all_product_category($this->session->userdata('land_id'));
            $data['product_type'] = $this->Model_product->getAllProductType();
            $data['all_store'] = $this->Model_common->get_all_store();
            $data['all_store_value'] = $this->Model_common->get_all_store_value();

            $this->load->view('backend/admin/view_header', $data);
            $this->load->view('backend/shop/view_product_add', $data);
            $this->load->view('backend/admin/view_footer');
        }
    }

    public function edit($id)
    {
        // If there is no product in this id, then redirect
        $tot = $this->Model_product->product_check($id);

        if (!$tot) {
            redirect(base_url() . 'backend/shop/product');
            exit;
        }

        $data['setting'] = $this->Model_common->get_setting_data();
        $error = '';
        $success = '';


        if (isset($_POST['form1'])) {
            $valid = 1;

            if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin', 'Ads'])) {
                redirect(base_url() . 'backend/shop/product');
            }

            if ($_FILES['photo']['name'] != '') {

                $path = $_FILES['photo']['name'];
                $path_banner = $_FILES['banner']['name'];
                $path_video = $_FILES['video']['name'];

                $path_tmp = $_FILES['photo']['tmp_name'];
                $path_tmp_banner = $_FILES['banner']['tmp_name'];
                $path_tmp_video = $_FILES['video']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $file_name = basename($path, '.' . $ext);

                $final_name = 'product_' . $id . '.' . strtolower($ext);
                $final_name_banner = 'product_' . $id . '_' . $path_banner;
                $final_name_video = 'product_' . $id . '_' . $path_video;


                $ext_check = $this->Model_common->extension_check_photo($ext);
                if ($ext_check == FALSE) {
                    $valid = 0;
                    $error .= 'You must have to upload jpg, jpeg, gif or png file for featured photo<br>';
                }
            }


            if ($valid == 1) {
                $data['product'] = $this->Model_product->getSingleProduct($id);
                // $data['product'] = $this->Model_product->getData($id);

                $category_id = '';
                // get single category_id for tbl_product table
                foreach ($this->input->post('lang') as $single_category_id) {
                    $category_id = $single_category_id['category_id'];
                    break;
                }

                foreach ((array) $this->input->post('product_updatable_add') as $product_updatable_add_row) {
                    $allow_data = array(
                        "product_id" => $id,
                        "updatable" => 1,
                        "allow_product" => $product_updatable_add_row
                    );

                    $control_allow_product = $this->Model_product->product_allow_check($id, $product_updatable_add_row);

                    if ($control_allow_product > 0) {
                        $this->Model_product->product_allow_update($id, $product_updatable_add_row, $allow_data);
                    } else {
                        $this->Model_product->product_allow_insert($allow_data);
                    }

                    // $this->Model_product->product_allow_insert($allow_data);
                }

                foreach ((array) $this->input->post('product_extra_add') as $product_extra_add_row) {
                    $allow_data = array(
                        "product_id" => $id,
                        "extra" => 1,
                        "allow_product" => $product_extra_add_row
                    );

                    $control_allow_product = $this->Model_product->product_allow_check($id, $product_extra_add_row);

                    if ($control_allow_product > 0) {
                        $this->Model_product->product_allow_update($id, $product_extra_add_row, $allow_data);
                    } else {
                        $this->Model_product->product_allow_insert($allow_data);
                    }

                    // $this->Model_product->product_allow_insert($allow_data);
                }

                foreach ((array) $this->input->post('allow_product') as $allow_productKey => $allow_product) {

                    if ($allow_product) {

                        if ($this->input->post('product_updatable[' . $allow_product . ']') === "on") {
                            $product_updatable = 1;
                        } else {
                            $product_updatable = 0;
                        }

                        if ($this->input->post('product_extra[' . $allow_product . ']') === "on") {
                            $product_extra = 1;
                        } else {
                            $product_extra = 0;
                        }

                        if ($this->input->post('product_allow_store[' . $allow_product . ']')) {
                            $product_allow_store = json_encode($this->input->post('product_allow_store[' . $allow_product . ']'));
                            // $product_allow_store = implode(',', $this->input->post('product_allow_store['.$allow_product.']'));
                        } else {
                            $product_allow_store = "";
                        }

                        $allow_data = array(
                            "product_id" => $id,
                            "allow_product" => $allow_product,
                            "allow_store" => $product_allow_store,
                            "updatable" => $product_updatable,
                            "extra" => $product_extra
                        );

                        $control_allow_product = $this->Model_product->product_allow_check($id, $allow_product);

                        if ($control_allow_product > 0) {
                            $this->Model_product->product_allow_update($id, $allow_product, $allow_data);
                        } else {
                            $this->Model_product->product_allow_insert($allow_data);
                        }
                    }
                }

                $form_data = array(
                    'category_id' => $category_id,
                    'with_name' => $this->input->post('with_name'),
                    'with_name_price' => $this->input->post('with_name_price'),
                    'with_name_allow' => $this->input->post('with_name_allow'),
                    'eye_quantity' => $this->input->post('eye_quantity'),
                    'product_type' => $this->input->post('product_type'),
                    'product_attribute' => $this->input->post('product_attribute'),
                    // 'product_updatable' => $product_updatable,
                    // 'product_extras' => $product_extra,
                    // 'product_allow_store' => $product_allow_store,
                    'product_sku' => $this->input->post('product_sku'),
                    'status' => $this->input->post('product_status'),
                    'row' => $this->input->post('product_row'),
                    'block_the_sale' => $this->input->post('block_the_sale')
                );


                    if (!empty($_FILES['photo']['name'])) {
                        if(file_exists('./public/uploads/product_photos/thumbnail/' . $data['product']['thumbnail']))
                            unlink('./public/uploads/product_photos/thumbnail/' . $data['product']['thumbnail']);
                        $form_data['thumbnail'] = $final_name;
                        move_uploaded_file($path_tmp, './public/uploads/product_photos/thumbnail/' . $final_name);
                    }
                    if (!empty($path_banner)) {
                        unlink('./public/uploads/product_photos/banner/' . $data['product']['banner']);
                        $form_data['banner'] = $final_name_banner;
                        move_uploaded_file($path_tmp_banner, './public/uploads/product_photos/banner/' . $final_name_banner);
                    }
                    if (!empty($path_video)) {
                        unlink('./public/uploads/product_photos/video/' . $data['product']['video']);
                        $form_data['video'] = $final_name_video;
                        move_uploaded_file($path_tmp_video, './public/uploads/product_photos/video/' . $final_name_video);
                    }

                    $this->Model_product->update($id, $form_data);

                $postedData = $this->input->post();

                foreach ((array) $postedData['lang'] as $key => $value) {
                    $slug = $this->slug->url($value['product_name']);

                    if (!empty($key && $value['product_name'])) {
                        $form_data_lang = array(
                            'product_id' => $id,
                            'land_id' => $key,
                            'lang_code' => $value['lang_code'],
                            'product_name' => $value['product_name'],
                            'product_subname' => $value['product_subname'],
                            'slug' => $slug,
                            'short_content' => $value['short_content'],
                            'content' => $value['content'],
                            'product_price' => $value['product_price'],
                            'product_price_old' => $value['product_price_old'],
                            'meta_title' => $value['meta_title'],
                            'meta_keyword' => $value['meta_keyword'],
                            'meta_description' => $value['meta_description']
                        );
                        $this->Model_product->update_lang($id, $form_data_lang, $key);
                    }
                }

                if (isset($_FILES['photos']["name"]) && isset($_FILES['photos']["tmp_name"])) {
                    $photos = array();
                    $photos = $_FILES['photos']["name"];
                    $photos = array_values(array_filter($photos));

                    $photos_temp = array();
                    $photos_temp = $_FILES['photos']["tmp_name"];
                    $photos_temp = array_values(array_filter($photos_temp));

                    $next_id1 = $this->Model_product->get_auto_increment_id1();
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
                            $final_names[$m] = $z . '.' . strtolower($ext);
                            move_uploaded_file($photos_temp[$i], "./public/uploads/product_photos/" . $final_names[$m]);
                            $m++;
                            $z++;
                        }
                    }
                }

                for ($i = 0; $i < count($final_names); $i++) {
                    $form_data = array(
                        'product_id' => $id,
                        'category_id' => $this->input->post('category_id'),
                        'photo' => $final_names[$i]
                    );
                    $this->Model_product->add_photos($form_data);
                }

                $success = 'Product is updated successfully';
                $this->session->set_flashdata('success', $success);
                redirect(base_url() . 'backend/shop/product');
            } else {
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . 'backend/shop/product/edit/' . $id);
            }
        } else {

            $data['product'] = $this->Model_product->getSingleProduct($id);
            $data['product_lang'] = $this->Model_product->getSingleProductLang($id);
            $data['product_type'] = $this->Model_product->getAllProductType();

            $data['all_product_category'] = $this->Model_product->get_all_product_category($this->session->userdata('land_id'));
            //$data['all_photo_category'] = $this->Model_product->get_all_photo_category();
            $data['all_photos_by_id'] = $this->Model_product->get_all_photos_by_category_id($id);


            $data['all_store'] = $this->Model_common->get_all_store();
            $data['all_store_value'] = $this->Model_common->get_all_store_value();

            $data['all_products'] = $this->Model_product->get_all_product($this->session->userdata('land_id'));
            $data['product_allows'] = $this->Model_product->product_allow($id);
            $data['product_allow_all'] = $this->Model_product->product_allow_all();


            $all_products = $this->Model_product->get_all_product($this->session->userdata('land_id'));
            $product_allows = $this->Model_product->product_allow($id);



            $this->load->view('backend/admin/view_header', $data);
            $this->load->view('backend/shop/view_product_edit', $data);
            $this->load->view('backend/admin/view_footer');
        }
    }

    public function delete($id)
    {

        if (!in_array($this->session->userdata('role'), ['Superadmin'])) {
            redirect(base_url() . 'backend/shop/product');
        }

        $tot = $this->Model_product->product_check($id);
        if (!$tot) {
            redirect(base_url() . 'backend/shop/product');
            exit;
        }

        $data['product'] = $this->Model_product->getSingleProduct($id);
        if ($data['product']) {
            unlink('./public/uploads/product_photos/thumbnail/' . $data['product']['photo']);
        }

        $product_photos = $this->Model_product->get_all_photos_by_category_id($id);
        foreach ($product_photos as $row) {
            unlink('./public/uploads/product_photos/' . $row['photo']);
        }

        $this->Model_product->delete($id);
        $this->Model_product->delete_photos($id);

        $success = 'Product is deleted successfully';
        $this->session->set_flashdata('success', $success);
        redirect(base_url() . 'backend/shop/product');
    }

    public function single_photo_delete($photo_id = 0, $product_id = 0)
    {

        $product_photo = $this->Model_product->product_photo_by_id($photo_id);
        unlink('./public/uploads/product_photos/' . $product_photo['photo']);

        $this->Model_product->delete_product_photo($photo_id);

        redirect(base_url() . 'backend/shop/product/edit/' . $product_id);
    }

    public function product_type()
    {
        $data['product_type'] = $this->Model_product->getAllProductType();

        $this->load->view('backend/admin/view_header', $data);
        $this->load->view('backend/shop/view_product_type', $data);
        $this->load->view('backend/admin/view_footer');
    }

    public function product_add_type()
    {

        $error = '';
        $success = '';


        if (isset($_POST['form1'])) {

            if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) {
                redirect(base_url() . 'backend/shop/product');
            }

            $valid = 1;

            $this->form_validation->set_rules('product_type', 'Product type', 'required');
            $this->form_validation->set_rules('row', 'Row', 'integer');

            if ($this->form_validation->run() == FALSE) {
                $valid = 0;
                $error = validation_errors();
            }

            if ($valid == 1) {

                $form_data = array(
                    'type_value'     => $this->input->post('product_type'),
                    'row'   => $this->input->post('row')
                );
                $this->Model_product->add_product_type($form_data);

                $success = 'Product Type is added successfully';
                $this->session->set_flashdata('success', $success);
                redirect(base_url() . 'backend/shop/product/product_type');
            } else {
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . 'backend/shop/product/product_type');
            }
        } else {

            $this->load->view('backend/admin/view_header');
            $this->load->view('backend/shop/view_product_add_type');
            $this->load->view('backend/admin/view_footer');
        }
    }

    public function product_edit_type($type_id)
    {

        // If there is no Product Type in this id, then redirect
        $tot = $this->Model_product->product_type_check($type_id);
        if (!$tot) {
            redirect(base_url() . 'backend/shop/product/product_type');
            exit;
        }

        $error = '';
        $success = '';


        if (isset($_POST['form1'])) {

            if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) {
                redirect(base_url() . 'backend/shop/product');
            }

            $valid = 1;

            $this->form_validation->set_rules('product_type', 'Product type', 'required');
            $this->form_validation->set_rules('row', 'Row', 'integer');

            if ($this->form_validation->run() == FALSE) {
                $valid = 0;
                $error = validation_errors();
            }

            if ($valid == 1) {

                $form_data = array(
                    'type_value'     => $this->input->post('product_type'),
                    'row'   => $this->input->post('row')
                );
                $this->Model_product->update_product_type($type_id, $form_data);

                $success = 'Product Type is updated successfully';
                $this->session->set_flashdata('success', $success);
                redirect(base_url() . 'backend/shop/product/product_type');
            } else {
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . 'backend/shop/product/product_type');
            }
        } else {

            $data['product_type'] = $this->Model_product->getSingleProductType($type_id);

            $this->load->view('backend/admin/view_header', $data);
            $this->load->view('backend/shop/view_product_edit_type', $data);
            $this->load->view('backend/admin/view_footer');
        }
    }

    public function product_delete_type($type_id)
    {

        if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) {
            redirect(base_url() . 'backend/shop/product');
        }

        // If there is no Product Type in this id, then redirect
        $tot = $this->Model_product->product_type_check($type_id);
        if (!$tot) {
            redirect(base_url() . 'backend/shop/product/product_type');
            exit;
        }

        $this->Model_product->delete_product_type($type_id);
        $success = 'Product Type is deleted successfully';
        $this->session->set_flashdata('success', $success);
        redirect(base_url() . 'backend/shop/product/product_type');
    }

    public function delete_allow_product()
    {

        if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) {
            redirect(base_url() . 'backend/shop/product');
        }

        $product_id = $this->input->post('product_id');
        $product_allow = $this->input->post('product_allow');

        $this->Model_product->delete_allow_product(intval($product_id), intval($product_allow));
        exit(json_encode(array('response' => 'success')));
    }

    public function fuat()
    {

        exit("burdasin canim");
        $configVideo['upload_path'] = 'assets/gallery/images'; # check path is correct
        $configVideo['max_size'] = '102400';
        $configVideo['allowed_types'] = 'mp4'; # add video extenstion on here
        $configVideo['overwrite'] = FALSE;
        $configVideo['remove_spaces'] = TRUE;
        $video_name = random_string('numeric', 5);
        $configVideo['file_name'] = $video_name;

        $this->load->library('upload', $configVideo);
        $this->upload->initialize($configVideo);

        if (!$this->upload->do_upload('uploadan')) # form input field attribute
        {
            # Upload Failed
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('controllerName/method');
        } else {
            # Upload Successfull
            $url = 'assets/gallery/images' . $video_name;
            $set1 =  $this->Model_name->uploadData($url);
            $this->session->set_flashdata('success', 'Video Has been Uploaded');
            redirect('controllerName/method');
        }
    }
}
