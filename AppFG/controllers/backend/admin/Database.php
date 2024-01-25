<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Database extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('id')) {
            redirect(base_url().'backend/admin/login');
            exit;
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
        $data['setting'] = $this->Model_common->get_setting_data();

        $this->load->view('backend/admin/view_header',$data);
        $this->load->view('backend/admin/view_database',$data);
        $this->load->view('backend/admin/view_footer');
    }

    public function dbexport()
    {
//        $this->load->helper('url');
//        $this->load->helper('file');
//        $this->load->helper('download');
//        $this->load->library('zip');
//        $this->load->dbutil();
//        $db_format=array('format'=>'zip','filename'=>'my_db_backup.sql');
//        $backup=& $this->dbutil->backup($db_format);
//        $dbname='backup-on-'.date('Y-m-d').'.zip';
//        $save='assets/'.$dbname;
//        write_file($save,$backup);
//        force_download($dbname,$backup);

        echo "hazirlaniyor...";

        $db_name = 'db-backup-on-'. date("Y-m-d-H-i-s") .'.zip';

        header('Content-type: application/force-download');
        header('Content-Disposition: attachment; filename="'.$db_name.'"');
        passthru("mysqldump --user=xx --host=xx --password=xx dbname | zip");


        $this->load->dbutil();

        $prefs = array(
            'format'      => 'zip',
            'filename'    => 'my_db_backup.sql'
        );

        $backup =& $this->dbutil->backup($prefs);

        $save = 'public/assets/'.$db_name;

        $this->load->helper('file');
        write_file($save, $backup);

        $this->load->helper('download');
        force_download($db_name, $backup);
    }

    public function dbimport()
    {

        $file = $_FILES['db_import']['name'];

        if (file_exists($file))
        {
            $lines = file($file);
            $statement = '';
            foreach ($lines as $line)
            {
                $statement .= $line;
                if (substr(trim($line), -1) === ';')
                {
                    $this->db->simple_query($statement);
                    $statement = '';
                }
            }

            redirect(base_url().'backend/admin/dashboard');

        }
    }
}