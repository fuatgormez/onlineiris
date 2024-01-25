<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('id')) {
            redirect(base_url() . 'backend/admin');
        }

        $this->load->library('logger/logger');
        $this->load->library('shop_email');

        $this->load->model('backend/ajax/shop/Model_order');
    }

    public function index()
    {
        redirect(base_url());
    }

    public function add_order_note()
    {
        if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin', 'Seller', 'Production', 'Designer'])) {
            exit(json_encode(array("status" => "access_denied")));
        }

        $user = $this->session->userdata('username');
        $order_number = $this->input->post('order_number');
        $note = $this->input->post('note');

        $data = array(
            "user" => $user,
            "note" => $note,
            "order_number" => $order_number
        );

        $add_note = $this->Model_order->add_order_note($data);

        if ($add_note > 0) {
            exit(json_encode(array("status" => 200, "user" => $user, "date" => date('d-m-Y H:i:s'))));
        }
    }

    public function delete_order_freigabe()
    {
        if (!in_array($this->session->userdata('role'), ['Superadmin'])) {
            exit(json_encode(array("status" => "access_denied")));
        }
        $freigabe_id = intval($this->input->post('freigabe_id'));
        $order_number = intval($this->input->post('order_number'));

        $this->Model_order->delete_order_freigabe($freigabe_id, $order_number);
    }

    public function delete_order_note()
    {
        if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) {
            exit(json_encode(array("status" => "access_denied")));
        }
        $note_id = intval($this->input->post('note_id'));
        $order_number = intval($this->input->post('order_number'));

        $this->Model_order->delete_order_note($note_id, $order_number);
    }

    function is_printed_item()
    {
        // exit(json_encode($this->Model_order->get_order($this->input->post('order_number'))));

        $item_id = $this->input->post('item_id');
        $order_number = $this->input->post('order_number');


        if ($this->input->post('type') === "normal") {
            $table = "tbl_shop_order_item";
            $item_field = "item_product_id";
        } else {
            $table = "tbl_shop_order_item_updated";
            $item_field = "item_id";
        }

        if ($this->input->post('is_printed') === "true") {
            $form_data['is_printed'] = 1;
        } else {
            if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) {
                exit(json_encode(array("status" => "access_denied")));
            }
            $form_data['is_printed'] = 0;
        }

        $this->Model_order->is_printed_item($item_id, $item_field, $order_number, $form_data, $table);
        exit(json_encode(array("status" => 200)));
    }

    function process_paid()
    {
        // exit(json_encode($this->Model_order->get_order($this->input->post('order_number'))));

        if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) {
            exit(json_encode(array("status" => "access_denied")));
        }

        $order_number = $this->input->post('order_number');
        $check_order_paid = $this->Model_order->get_order($order_number);

        $this->load->library('pdf');


        $isPaid = $this->input->post('paid');


        if ($isPaid != NULL) {
            if ($isPaid === "paid") {
                $paid = "isPaid";
                $paid_field = "paid";

                if ($check_order_paid['paid'] === $paid) {
                    exit(json_encode(array('status' => 100)));
                }
            }
            if ($isPaid === "unpaid") {
                $paid = "isPending";
                $paid_field = "paid";

                if ($check_order_paid['paid'] === $paid) {
                    exit(json_encode(array('status' => 100)));
                }
            }
            if ($isPaid === "paid_update") {
                $paid = "isPaid";
                $paid_field = "paid_update";

                if ($check_order_paid['paid_update'] === $paid) {
                    exit(json_encode(array('status' => 101)));
                }
            }
            if ($isPaid === "unpaid_update") {
                $paid = "isPending";
                $paid_field = "paid_update";

                if ($check_order_paid['paid_update'] === $paid) {
                    exit(json_encode(array('status' => 101)));
                }
            }

            $form_data = array(
                $paid_field  => $paid
            );

            if ($this->input->post('amount') > 0) {

                $order_paid_process_data = array(
                    "amount" => $this->input->post('amount'),
                    "type_paid" => $paid_field,
                    "user" => $this->session->userdata('username'),
                    "order_number" => $order_number
                );

                $check_process = $this->Model_order->order_paid_process_check($order_number, $paid_field);
                if (empty($check_process)) {
                    $message = 'paid insert!';
                    $this->session->set_flashdata('success', $message);

                    $this->logger->user($this->session->userdata('username'))->type('Order' . $paid_field)->id(1)->token(sha1(mt_rand()))->comment($message . ' order_number -> ' . $order_number)->log();
                    $this->Model_order->order_paid_process_insert($order_paid_process_data);
                }

                $message = 'Marked the order as paid!';
                $this->session->set_flashdata('success', $message);

                $this->logger->user($this->session->userdata('username'))->type('Order' . $paid_field)->id(1)->token(sha1(mt_rand()))->comment($message . ' order_number -> ' . $order_number)->log();
            } //if > 1 amount end

            $this->Model_order->update($order_number, $form_data);

            $this->pdf->order_confirmation($order_number);
            // $this->pdf->shooting_coupon($order_number);
            exit(json_encode(array("status" => 200)));
        } //if ispaid != null end
    }

    function storno()
    {

        if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) {
            exit(json_encode(array("status" => "access_denied")));
        }

        $order_number = $this->input->post('order_number');
        $action = $this->input->post('action');
        $check_order_paid = $this->Model_order->get_order($order_number);

        $form_data = array(
            "storno" => $action
        );

        $this->Model_order->update($order_number, $form_data);
        exit(json_encode(array("status" => 200)));


        //bu kisma sonra bak
        $this->load->library('pdf');


        $isPaid = $this->input->post('paid');


        if ($isPaid != NULL) {
            if ($isPaid === "paid") {
                $paid = "isPaid";
                $paid_field = "paid";

                if ($check_order_paid['paid'] === $paid) {
                    exit(json_encode(array('status' => 100)));
                }
            }
            if ($isPaid === "unpaid") {
                $paid = "isPending";
                $paid_field = "paid";

                if ($check_order_paid['paid'] === $paid) {
                    exit(json_encode(array('status' => 100)));
                }
            }
            if ($isPaid === "paid_update") {
                $paid = "isPaid";
                $paid_field = "paid_update";

                if ($check_order_paid['paid_update'] === $paid) {
                    exit(json_encode(array('status' => 101)));
                }
            }
            if ($isPaid === "unpaid_update") {
                $paid = "isPending";
                $paid_field = "paid_update";

                if ($check_order_paid['paid_update'] === $paid) {
                    exit(json_encode(array('status' => 101)));
                }
            }

            $form_data = array(
                $paid_field  => $paid
            );

            if ($this->input->post('amount') > 0) {

                $order_paid_process_data = array(
                    "amount" => $this->input->post('amount'),
                    "type_paid" => $paid_field,
                    "user" => $this->session->userdata('username'),
                    "order_number" => $order_number
                );

                $check_process = $this->Model_order->order_paid_process_check($order_number, $paid_field);
                if (empty($check_process)) {
                    $message = 'paid insert!';
                    $this->session->set_flashdata('success', $message);

                    $this->logger->user($this->session->userdata('username'))->type('Order' . $paid_field)->id(1)->token(sha1(mt_rand()))->comment($message . ' order_number -> ' . $order_number)->log();
                    $this->Model_order->order_paid_process_insert($order_paid_process_data);
                }

                $message = 'Marked the order as paid!';
                $this->session->set_flashdata('success', $message);

                $this->logger->user($this->session->userdata('username'))->type('Order' . $paid_field)->id(1)->token(sha1(mt_rand()))->comment($message . ' order_number -> ' . $order_number)->log();
            } //if > 1 amount end

            $this->Model_order->update($order_number, $form_data);

            $this->pdf->order_confirmation($order_number);
            // $this->pdf->shooting_coupon($order_number);
            exit(json_encode(array("status" => 200)));
        } //if ispaid != null end
    }

    public function status_process()
    {
        if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin', 'Meister', 'Production', 'Designer'])) {
            exit(json_encode(array("status" => "access_denied")));
        }

        $process_number = $this->input->post('status_process');
        $order_number = $this->input->post('order_number');

        if ($process_number == 5) {
            $data = array(
                "status_process" => $process_number,
                "freigabe" => 0
            );
        } else {
            $data = array(
                "status_process" => $process_number
            );
        }


        $get_order = $this->Model_order->get_order($order_number);

        if ($process_number == 5) {
            $this->shop_email->send_email_oder_process($get_order['store_lang_code'], "FinishedPhotoshop", $get_order['billing_email']);
        }
        if ($process_number == 6) {
            $this->shop_email->send_email_oder_process($get_order['store_lang_code'], "CustomerConfirmed", $get_order['billing_email']);
        }
        if ($process_number == 9) {
            $this->shop_email->send_email_oder_process($get_order['store_lang_code'], "shipped", $get_order['billing_email']);
        }
        if ($process_number == 13) {
            $this->shop_email->send_email_oder_process($get_order['store_lang_code'], "NotConfirmOrder", $get_order['billing_email']);
        }

        if ($this->Model_order->update($order_number, $data) > 0) {

            $message = 'Order Status Process updated!';
            $this->logger->user($this->session->userdata('username'))->type('Order Status' . $process_number)->id(1)->token(sha1(mt_rand()))->comment($message . ' order_number -> ' . $order_number)->log();

            $this->logger->user($this->session->userdata('username'))->type('Status Process')->id(1)->token(sha1(mt_rand()))->comment('Status Process Update order_number -> ' . $order_number)->log();
            exit(json_encode(array("status" => 200)));
        }
    }

    public function quick_search()
    {
        if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin', 'Meister', 'Production', 'Seller', 'Designer'])) {
            exit(json_encode(array("status" => "access_denied")));
        }

        $term = $this->input->post('term');
        $term2 = $_POST['term'];

        $quick_search = $this->Model_order->quick_search($term);

        $response = array();

        if (!empty($quick_search)) {
            foreach ($quick_search as $row) {
                $response[] = array(
                    "order_id" => $row["order_id"],
                    "order_number" => $row["order_number"],
                    "billing_firstname" => $row["billing_firstname"],
                    "billing_lastname" => $row["billing_lastname"],
                    "billing_street" => $row["billing_street"],
                    "billing_street_no" => $row["billing_street_no"],
                    "billing_postcode" => $row["billing_postcode"],
                    "billing_city" => $row["billing_city"],
                    "total" => $row["total"],
                    "paid" => $row["paid"],
                    "status_process" => $row["status_process"]
                );
            }
        }

        $message = 'Search:';
        $this->logger->user($this->session->userdata('username'))->type('Order Search')->id(1)->token(sha1(mt_rand()))->comment($message . ' term -> ' . $term)->log();

        exit(json_encode($response));
    }

    public function photoshop_manual_upload()
    {
        
        $error = "";
        // token ekle
        // coklu siparislerde daha once cekilen resim secildiyse resmi tekrar yukleme 0=yukle 1=yukleme

        print_r($_FILES);exit;

        if (isset($_FILES['photo']["name"]) && isset($_FILES['photo']["tmp_name"])) {

            $valid = 1;

            $path = $_FILES['photo']['name'];
            $path_tmp = $_FILES['photo']['tmp_name'];

            if ($path != '') {
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $file_name = basename($path, '.' . $ext);
                $ext_check = in_array($ext, ['cr2','jpg','jpeg','png']);
                if ($ext_check == FALSE) {
                    $valid = 0;
                    $error .= 'You must have to upload cr2,jpg, jpeg, gif or png file for featured photo<br>';
                }
            } else {
                $valid = 0;
                $error .= 'You must have to select a photo for featured photo<br>';
            }

            if ($valid == 1) {
                // $ai_id = rand(1000, 10000) . time();
                $ai_id = rand(1000, 10000);

                $path = $_POST['image']; // gönderilen resim rename ediliyor

                $check_order_kiosk = $this->Model_order_kiosk->check_order(intval($_POST['order_number']));
                $folder_date = date("d-m-Y", strtotime($check_order_kiosk['date_purchased']));
                // $folder_date = date("d-m-Y");

                $current_folder = "public/uploads/shop/order_kiosk_upload/" . str_replace(' ', '', trim(strtolower($_POST['land_name']))) . "/" . str_replace(' ', '', trim(strtolower($_POST['store_name']))) . "/" . $folder_date . "/" . intval($_POST['order_number']) . "/";

                if (!file_exists($current_folder)) {
                    mkdir($current_folder, 0755, true);
                }

                if (move_uploaded_file($path_tmp, $current_folder . $path)) {
                    $form_data = array(
                        'order_number' => intval($_POST['order_number']),
                        'item_id' => intval($_POST['item_id']),
                        'item_uniqid' => intval($_POST['item_uniqid']),
                        'item_id_extra' => intval($_POST['item_id_extra']),
                        'item_id_duplicated' => 0,
                        'with_name' => $_POST['with_name'],
                        'with_name_price' => $_POST['with_name_price'],
                        'image' => $path,
                        'image_owner' => $_POST['image_owner'],
                        'is_extra' => $_POST['is_extra'],
                        'is_selected' => $_POST['is_selected'],
                        'is_completed_uniqid' => $_POST['is_completed_uniqid'],
                        'qty' => $_POST['qty'],
                        'total' => $_POST['total'],
                        'path' => $current_folder
                    );

                    if (file_exists($current_folder . $path)) {
                        $insert = $this->Model_order_kiosk->add_order_item_photo($form_data);

                        if ($insert > 0) {
                            $status_process = array('status_process' => 2);
                            $this->Model_order_kiosk->update_order(intval($_POST['order_number']), $status_process);
                            exit(json_encode(array("status" => true, "message" => "success", "data" => "ok")));
                        } else {
                            exit(json_encode(array("status" => false, "message" => "error", "data" => "Could not save to database!")));
                        }
                    } else {
                        exit(json_encode(array("status" => false, "message" => "error", "data" => "no")));
                    }
                } else {
                    exit(json_encode(array("status" => false, "message" => "Image could not be uploaded!", "data" => "no")));
                }
            } else {
                exit(json_encode(array("status" => false, "message" => "error", "data" => "no")));
            }
        }
    }

    public function photoshop_upload()
    {
        if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin', 'Designer'])) {
            exit(json_encode(array("status" => "access_denied")));
        }
        // $dateArray = date("d-m-Y", strtotime($_POST['date'])); // klasor olusturmak icin tarih


        $get_order = $this->Model_order->get_order($this->input->post('order_number'));

        // $land_name = $this->input->post('land_name');
        // $store_name = $this->input->post('store_name');
        // $store_id = $this->input->post('store_id');
        // $date = date("d-m-Y", strtotime($this->input->post('date')));

        $order_number = $get_order['order_number'];
        $land_name = $get_order['land_name'];
        $store_name = $get_order['store_name'];
        $date = date("d-m-Y", strtotime($get_order['date_purchased']));

        // Count total files
        $countfiles = count($_FILES['photos']['name']);

        // Upload directory
        $upload_location = "public/uploads/shop/order_kiosk_upload/" . str_replace(' ', '', trim(strtolower($land_name))) . "/" . str_replace(' ', '', trim(strtolower($store_name))) . "/" . $date . "/" . intval($order_number) . "/";

        // $upload_location_fo_local = "public/uploads/shop/order_kiosk_upload/deutschland/berlin/1/16-04-2021/205281612036092/";
        // $upload_location = "public/uploads/shop/order_kiosk_upload/" . trim(strtolower($land_name)) . "/" . trim(strtolower($store_name)) . "/" . intval($store_id) . "/" . $date . "/" . intval($order_number) . "/";
        // $upload_location = "public/uploads/product_photos/banner/";

        if (!file_exists($upload_location)) {
            // mkdir($upload_location, 0755, true);
            exit(json_encode(array("status" => 100)));
        }

        $form_data = array(
            "order_number" => $order_number,
            "path" => $upload_location,
            "user" => $this->session->userdata('username')
        );


        // To store uploaded files path
        $files_arr = array();
        // Loop all files
        for ($index = 0; $index < $countfiles; $index++) {

            $uniqid = uniqid();

            if (isset($_FILES['photos']['name'][$index]) && $_FILES['photos']['name'][$index] != '') {
                // File name
                $filename = $_FILES['photos']['name'][$index];

                // Get extension
                // $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

                $info = pathinfo($filename);
                // get the filename without the extension
                $image_name =  basename($filename, '.' . $info['extension']);
                // get the extension without the image name
                $tmp = explode('.', $filename);
                $ext = end($tmp);
                // $ext = end(explode('.', $filename));

                $filename = $image_name . "_" . $uniqid . "." . $ext;

                // Valid image extension
                $valid_ext = array("png", "PNG", "jpeg", "JPEG", "jpg", "JPG", "tiff", "TIFF", "tif", "TIF");

                // Check extension
                if (in_array($ext, $valid_ext)) {

                    // File path
                    $path = $upload_location . $filename;

                    // Upload file
                    if (move_uploaded_file($_FILES['photos']['tmp_name'][$index], $path)) {
                        $files_arr[] = array(
                            "image_name" => $filename,
                            "image" => $path,
                            "user" => $this->session->userdata('username'),
                            "date" => date("d-m-Y")
                        );

                        $form_data['image'] = $filename;
                        $this->Model_order->photoshop_upload($form_data);
                    }
                }
            }
        }

        // $files_arr['user'] = $this->session->userdata('username');
        // $files_arr['date'] = date("d-m-Y");

        $message = 'Uploaded a picture!';
        $this->logger->user($this->session->userdata('username'))->type('Order Image Upload')->id(1)->token(sha1(mt_rand()))->comment($message . ' order_number -> ' . $order_number)->log();

        exit(json_encode(array("images" => $files_arr)));
    }

    public function photoshop_download($image_id)
    {

        if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) {
            exit(json_encode(array("status" => "access_denied")));
        }

        try {
            // $image_id = json_decode(file_get_contents('php://input'), true);
            // $image_id = intval($this->input->post('image_id'));
            $this->load->helper('download');


            $result = $this->Model_order->photoshop_download($image_id);
            $file = $result->path . $result->image;
            $new_name = $result->order_number . "_" . $result->image;

            $message = 'Donwloaded the picture!';
            $this->logger->user($this->session->userdata('username'))->type('Order image downdload')->id(1)->token(sha1(mt_rand()))->comment($message . ' image -> ' . $file)->log();

            // $get_update_item = json_decode(file_get_contents('php://input'), true);
            $data = file_get_contents($file);
            force_download($new_name, $data);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function for_photoshop_photo_delete()
    {
        // $image_id = json_decode(file_get_contents('php://input'), true);

        if (!in_array($this->session->userdata('role'), ['Superadmin'])) {
            exit(json_encode(array("status" => "access_denied")));
        }

        $image_id = intval($this->input->post('image_id'));

        $result = $this->Model_order->get_for_photoshop_photo($image_id);

        if ($result) {

            $this->Model_order->delete_for_photoshop_photo($image_id);

            $file = "./" . $result->path . $result->image;
            unlink($file);

            $info = pathinfo($file);
            // get the filename without the extension
            $image_name =  basename($file, '.' . $info['extension']);
            unlink("./" . $result->path . $image_name . ".cr2");

            $message = 'Deleted the picture! (for photoshop)';
            $this->logger->user($this->session->userdata('username'))->type('Order image delete')->id(1)->token(sha1(mt_rand()))->comment($message . ' image -> ' . $file)->log();

            // if(file_exists($result->path))
            //     rmdir($result->path);

            exit(json_encode(array('status' => 'success')));
        }
    }

    public function for_printing_photo_delete()
    {
        // $image_id = json_decode(file_get_contents('php://input'), true);

        if (!array_intersect([$this->session->userdata('role'), $this->session->userdata('id')], ['Superadmin',20])) { //20 id li kullanici gulsum
            exit(json_encode(array("status" => "access_denied")));
        }

        $image_id = intval($this->input->post('image_id'));

        $result = $this->Model_order->get_for_printing_photo($image_id);
        $file = "./" . $result->path . $result->image;

        $this->Model_order->delete_for_printing_photo($image_id);
        unlink($file);

        $message = 'Deleted the picture! (for printing)';
        $this->logger->user($this->session->userdata('username'))->type('Order image delete')->id(1)->token(sha1(mt_rand()))->comment($message . ' image -> ' . $file)->log();

        exit(json_encode(array('status' => 'success')));
    }

    public function re_send_email()
    {
        if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin', 'Seller']))
        {
            exit(json_encode(array("status" => "access_denied")));
        }

        try {
            $lang_code = $this->input->post('lang_code');
            $message_type = $this->input->post('message_type');
            $email = $this->input->post('email');
            $order_number = $this->input->post('order_number');

            $message = 'Email sent!';
            $this->logger->user($this->session->userdata('username'))->type('Order Remail')->id(1)->token(sha1(mt_rand()))->comment($message . ' order_number -> ' . $order_number)->log();

            $this->shop_email->re_send_email($lang_code, $message_type, $email, $order_number);

            exit(json_encode(array('status' => 200)));
        } catch (Exception $e) {
            exit(json_encode(array('status' => false)));
        }
    }
}
