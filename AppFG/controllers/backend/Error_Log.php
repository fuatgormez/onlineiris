<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Error_log extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('id')) {
            redirect(base_url() . 'backend/admin');
        }

        $this->load->model('backend/admin/Model_common');
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

        $data['title'] = 'Error Log';

        $data['clear'] = site_url('tool/error_log/clear');

        $data['log'] = '';

        // Current Filename;
        $file = 'AppFG/logs/' . 'log-' . date('Y-m-d') . '.php';
        // $file = FCPATH . 'AppFG/logs/' . 'log-'.date('Y-m-d').'.php';

        if (file_exists($file)) {
            $size = filesize($file);

            if ($size >= 5242880) {
                $suffix = array(
                    'B',
                    'KB',
                    'MB',
                    'GB',
                    'TB',
                    'PB',
                    'EB',
                    'ZB',
                    'YB'
                );

                $i = 0;

                while (($size / 1024) > 1) {
                    $size = $size / 1024;
                    $i++;
                }

                $error_warning = 'Warning: Your error log file %s is %s!';

                $data['error_warning'] = sprintf($error_warning, basename($file), round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i]);
            } else {

                // Updated from comment

                $log = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
                $lines = explode("\n", $log);
                $content = implode("\n", array_slice($lines, 1));
                $data['log'] = $content;
            }

            $this->load->view('backend/admin/view_header', $data);
            $this->load->view('backend/view_error_log', $data);
            $this->load->view('backend/admin/view_footer');
        } else {
            redirect(base_url('backend/admin'));
        }
    }
}
