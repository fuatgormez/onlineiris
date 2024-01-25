<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_common extends CI_Model
{
    public function all_setting()
    {
        $query = $this->db->query("SELECT * FROM tbl_settings WHERE id=1");
        return $query->first_row('array');
    }

    public function all_setting_shop()
    {
        $query = $this->db->query("SELECT * FROM tbl_settings_shop WHERE id=1");
        return $query->first_row('array');
    }

    public function get_send_email($lang_code = "de", $message_type="")
    {
        $sql = "SELECT * 
        FROM tbl_shop_email t1
        JOIN tbl_shop_email_lang t2
        ON t1.sku = t2.sku
        WHERE t2.lang_code = ? AND t1.type = ? ";

        $query = $this->db->query($sql, array($lang_code, $message_type));
        return $query->first_row('array');
    }

    public function all_page_home()
    {
        $query = $this->db->query("SELECT * FROM tbl_page_home WHERE id=1");
        return $query->first_row('array');
    }

    public function all_page_about()
    {
        $query = $this->db->query("SELECT * FROM tbl_page_about WHERE id=1");
        return $query->first_row('array');
    }

    public function all_page_job()
    {
        $query = $this->db->query("SELECT * FROM tbl_page_job WHERE id=1");
        return $query->first_row('array');
    }

    public function all_page_impressum()
    {
        $query = $this->db->query("SELECT * FROM tbl_page_impressum WHERE id=1");
        return $query->first_row('array');
    }

    public function all_page_datenschutz()
    {
        $query = $this->db->query("SELECT * FROM tbl_page_datenschutz WHERE id=1");
        return $query->first_row('array');
    }

    public function all_page_agb()
    {
        $query = $this->db->query("SELECT * FROM tbl_page_agb WHERE id=1");
        return $query->first_row('array');
    }

    public function all_page_widerruf()
    {
        $query = $this->db->query("SELECT * FROM tbl_page_wiederruf WHERE id=1");
        return $query->first_row('array');
    }

    public function all_page_faq()
    {
        $query = $this->db->query("SELECT * FROM tbl_page_faq WHERE id=1");
        return $query->first_row('array');
    }

    public function all_page_service()
    {
        $query = $this->db->query("SELECT * FROM tbl_page_service WHERE id=1");
        return $query->first_row('array');
    }

    public function all_page_testimonial()
    {
        $query = $this->db->query("SELECT * FROM tbl_page_testimonial WHERE id=1");
        return $query->first_row('array');
    }

    public function all_page_news()
    {
        $query = $this->db->query("SELECT * FROM tbl_page_news WHERE id=1");
        return $query->first_row('array');
    }

    public function all_page_event()
    {
        $query = $this->db->query("SELECT * FROM tbl_page_event WHERE id=1");
        return $query->first_row('array');
    }

    public function all_page_contact()
    {
        $query = $this->db->query("SELECT * FROM tbl_page_contact WHERE id=1");
        return $query->first_row('array');
    }

    public function all_page_search()
    {
        $query = $this->db->query("SELECT * FROM tbl_page_search WHERE id=1");
        return $query->first_row('array');
    }

    public function all_page_term()
    {
        $query = $this->db->query("SELECT * FROM tbl_page_term WHERE id=1");
        return $query->first_row('array');
    }

    public function all_page_privacy()
    {
        $query = $this->db->query("SELECT * FROM tbl_page_privacy WHERE id=1");
        return $query->first_row('array');
    }

    public function all_page_pricing()
    {
        $query = $this->db->query("SELECT * FROM tbl_page_pricing WHERE id=1");
        return $query->first_row('array');
    }

    public function all_page_photo_gallery()
    {
        $query = $this->db->query("SELECT * FROM tbl_page_photo_gallery WHERE id=1");
        return $query->first_row('array');
    }

    public function all_page_team()
    {
        $query = $this->db->query("SELECT * FROM tbl_page_team WHERE id=1");
        return $query->first_row('array');
    }

    public function all_page_portfolio()
    {
        $query = $this->db->query("SELECT * FROM tbl_page_portfolio WHERE id=1");
        return $query->first_row('array');
    }

    public function all_comment()
    {
        $query = $this->db->query("SELECT * FROM tbl_comment WHERE id=1");
        return $query->first_row('array');
    }

    public function all_social()
    {
        $query = $this->db->query("SELECT * FROM tbl_social");
        return $query->result_array();
    }

    public function all_news()
    {
        $query = $this->db->query("SELECT * FROM tbl_news ORDER BY news_id DESC");
        return $query->result_array();
    }

    public function all_news_category()
    {
        $query = $this->db->query("SELECT * 
                                FROM tbl_news t1
                                JOIN tbl_category t2
                                ON t1.category_id = t2.category_id
                                ORDER BY t1.news_id DESC");
        return $query->result_array();
    }

    public function all_event()
    {
        $query = $this->db->query("SELECT * FROM tbl_event ORDER BY event_id DESC");
        return $query->result_array();
    }

    public function all_categories()
    {
        $query = $this->db->query("SELECT * FROM tbl_category ORDER BY category_name ASC");
        return $query->result_array();
    }

    public function extension_check_photo($ext)
    {
        if ($ext != 'ico' && $ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif' && $ext != 'cr2' && $ext != 'ICO' && $ext != 'JPG' && $ext != 'PNG' && $ext != 'JPEG' && $ext != 'GIF' && $ext != 'CR2') {
            return false;
        } else {
            return true;
        }
    }

    public function extension_check_video($ext)
    {
        if ($ext != 'webm' && $ext != 'mkv' && $ext != 'flv' && $ext != 'ogv' && $ext != 'ogg' && $ext != 'mng' && $ext != 'avi' && $ext != 'mov' && $ext != 'wmv' && $ext != 'mp4' && $ext != 'mpeg') {
            return false;
        } else {
            return true;
        }
    }

    public function get_language_data()
    {
        $query = $this->db->query("SELECT * FROM tbl_language");
        return $query->result_array();
    }

    public function get_all_land()
    {
        $query = $this->db
            ->select('*')
            ->where('status', 'Show')
            ->group_by('land_name')
            ->order_by('land_name', 'asc')
            ->get('tbl_shop_store_value');
        return $query->result('array');

        // $sql = "SELECT * 
        //         FROM tbl_shop_store_value
        //         WHERE status = ? GROUP BY land_name DESC";
        // $query = $this->db->query($sql,'Show');
        // return $query->result_array();
    }

    function get_all_store()
    {
        $sql = "SELECT * FROM tbl_shop_store WHERE status = ? ORDER BY row ASC";
        $query = $this->db->query($sql, 'Show');
        return $query->result_array();
    }

    function get_all_store_value()
    {
        $sql = "SELECT * FROM tbl_shop_store_value WHERE status = ?";
        $query = $this->db->query($sql, 'Show');
        return $query->result_array();
    }

    // public function get_all_store_lang()
    // {
    //     $sql = "SELECT * FROM tbl_shop_store_value WHERE status = ? ORDER BY row ASC";
    //     $query = $this->db->query($sql,"Show");
    //     return $query->result_array();
    // }

    public function store_check($store_id)
    {
        $sql = 'SELECT * FROM tbl_shop_store WHERE id = ? AND status = ?';
        $query = $this->db->query($sql, array($store_id, 'Show'));
        return $query->first_row('array');
    }
    
    public function store_search_single($store_name)
    {
        $sql = 'SELECT * FROM tbl_shop_store WHERE store_name = ?';
        $query = $this->db->query($sql, array($store_name));
        return $query->first_row('array');
    }

    public function get_all_store_lang_check($data = "de")
    {
        $sql = 'SELECT * FROM tbl_shop_store_value WHERE lang_code = ? AND status = ?';
        $query = $this->db->query($sql,array($data,"Show"));
        return $query->first_row('array');
    }

    public function find_store($value)
    {
        $sql = "SELECT * FROM tbl_shop_store WHERE (land_name LIKE '%$value%' OR store_name LIKE '%$value%' OR store_address LIKE '%$value%') AND status = 'Show' ORDER BY row, land_name ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
        // return $query->first_row('array');
    }

    public function check_coupon_code($coupon_code)
    {
        $sql = "SELECT * FROM tbl_shop_coupon WHERE code = ?";
        $query = $this->db->query($sql, array($coupon_code));
        return $query->first_row('array');
    }

    public function check_url_for_backend()
    {
        redirect(base_url());
        echo "check_url";
    }
    
    function get_order($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order WHERE order_number = ?";
        $query = $this->db->query($sql, array($order_number));
        return $query->first_row('array');
        // return $this->db->affected_rows();
    }

    function get_order_item($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_item WHERE order_number = ?";
        $query = $this->db->query($sql, array($order_number));
        return $query->result_array();
    }

    function insert_ci_sessions($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->delete('ci_sessions');

        $this->db->insert('ci_sessions', $data);
        return $this->db->insert_id();
    }

    function get_ci_sessions($id)
    {
        $sql = "SELECT * FROM ci_sessions WHERE id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->first_row('array');
    }
}
