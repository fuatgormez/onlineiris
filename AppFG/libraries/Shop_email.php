<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Shop_email
{
    private $_CI;

    function __construct()
    {
        $this->_CI = &get_instance();
        // $this->_CI->load->model('Dynamic_Model','dm');

        $this->_CI->load->model('Model_common');
        $this->_CI->load->model('api/Model_shop');

        $this->_CI->load->library('pdf');
        $this->_CI->load->library('email');

        // Set the default email config and Initialize
        $config['protocol']  = 'smtp';
        $config['smtp_host'] = 'smtp.strato.de';
        $config['smtp_user'] = 'info@irisandpet.de';
        $config['smtp_pass'] = 'Damista123-';
        $config['smtp_port'] =  587;
        $config['smtp_timeout'] = 30;
        $config['mailtype']  = 'html';
        $config['newline'] = "\r\n";

        $this->_CI->email->initialize($config);
    }

    public function index()
    {
        redirect(base_url());
    }

    public function send_email($email, $order_number, $lang_code = "de", $message_type = "")
    {
        $data['mail'] = $this->_CI->Model_common->get_send_email($lang_code, $message_type);
        $data['setting'] = $this->_CI->Model_common->all_setting();
        $data['social'] = $this->_CI->Model_common->all_social();
        $data['order'] = $this->_CI->Model_common->get_order($order_number);
        $data['order_number'] = $order_number;

        // $data['invoice_name'] = $order_number . ".pdf";
        // $data['coupon_name'] = $order_number . ".pdf";
        // $this->_CI->pdf->order_confirmation($order_number);
        // $this->_CI->pdf->shooting_coupon($order_number);

        $message = $this->_CI->load->view('email/view_index', $data, TRUE);

        $this->_CI->email->from($data['setting']['send_email_from'], $data['setting']['sitename']);
        $this->_CI->email->to($email);
        $this->_CI->email->subject($data['mail']['subject'] .' '. $order_number);
        $this->_CI->email->message($message);
        $this->_CI->email->set_mailtype("html");
        $this->_CI->email->send();
    }
    
    public function single_email($email, $order_number,$lang_code = "de", $message_type = "")
    {
        $send_email_data['mail'] = $this->_CI->Model_common->get_send_email($lang_code, $message_type);
        $data['setting'] = $this->_CI->Model_common->all_setting();


        // $this->_CI->load->library('email');
        $this->_CI->email->from($data['setting']['send_email_from'], 'IRISPICTURE');
        $this->_CI->email->to($email);
        // $this->_CI->email->bcc(array('irispicturecom@hotmail.com')); //irispicturecom@hotmail.com Damista123-
        $this->_CI->email->subject($send_email_data['mail']['subject'] . $order_number);
        $this->_CI->email->message($send_email_data['mail']['message']);
        $this->_CI->email->set_mailtype("html");
        // $this->email->attach(base_url().'public/pdf/'.$this->invoice_name, 'attachment', $this->invoice_name, 'application/pdf');
        // $this->email->attach('/public/pdf/'.$this->invoice_name, 'attachment', $this->invoice_name, 'application/pdf');
        // $this->email->attach('public/pdf/'.$this->invoice_name, 'attachment', $this->invoice_name, 'application/pdf');
        $this->_CI->email->send();
    }

    public function re_send_email($lang_code,$message_type,$email,$order_number)
    {
        $send_email_data['mail'] = $this->_CI->Model_common->get_send_email($lang_code, $message_type);
        $data['setting'] = $this->_CI->Model_common->all_setting();

        $this->_CI->pdf->order_confirmation($order_number);
        $this->_CI->pdf->shooting_coupon($order_number);

        $send_email_data['invoice_name'] = $order_number . ".pdf";
        $send_email_data['coupon_name'] = $order_number . ".pdf";

        $message = $this->_CI->load->view('email/view_shop_success', $send_email_data, TRUE);

        $this->_CI->email->from($data['setting']['send_email_from'], 'IRISPICTURE');
        $this->_CI->email->to($email);
        $this->_CI->email->bcc(array('irispicturecom@hotmail.com')); //irispicturecom@hotmail.com Damista123-
        $this->_CI->email->subject($send_email_data['mail']['subject'] . $order_number);
        $this->_CI->email->message($message);
        $this->_CI->email->set_mailtype("html");
        // $this->email->attach(base_url().'public/pdf/'.$this->invoice_name, 'attachment', $this->invoice_name, 'application/pdf');
        // $this->email->attach('/public/pdf/'.$this->invoice_name, 'attachment', $this->invoice_name, 'application/pdf');
        // $this->email->attach('public/pdf/'.$this->invoice_name, 'attachment', $this->invoice_name, 'application/pdf');
        $this->_CI->email->send();
    }

    public function send_email_oder_process($lang_code = "de", $message_type = "", $email = "")
    {
        $this->_CI->load->model('Model_common');

        $send_email['mail'] = $this->_CI->Model_common->get_send_email($lang_code, $message_type);
        $data['setting'] = $this->_CI->Model_common->all_setting();


        $this->_CI->email->from($data['setting']['send_email_from'], $data['setting']['sitename']);
        $this->_CI->email->to($email);
        $this->_CI->email->subject($send_email['mail']['subject']);
        $this->_CI->email->message($send_email['mail']['message']);
        $this->_CI->email->set_mailtype("html");
        $this->_CI->email->send();
    }

    public function send_email_uniqid($lang_code, $message_type, $email, $order_number)
    {
        $send_email_data['mail'] = $this->_CI->Model_common->get_send_email($lang_code, $message_type);
        $data['setting'] = $this->_CI->Model_common->all_setting();

        $this->_CI->pdf->order_confirmation($order_number);
        $this->_CI->pdf->shooting_coupon($order_number);

        // $this->_CI->load->library('email');
        $this->_CI->email->from($data['setting']['send_email_from'], '');
        $this->_CI->email->to($email);
        $this->_CI->email->subject($send_email_data['mail']['subject']);
        $this->_CI->email->message($send_email_data['mail']['message']);
        $this->_CI->email->set_mailtype("html");
        
        $this->_CI->email->send();
    }
    
    /**
     * bu mail gönderme geçici olarak iptal edildi
     *
     * @return void
     */
    public function send_email_single_banktransfer_kiosk($order_number="", $item_uniqid="")
    {
        $check_item_data =  $this->_CI->Model_shop->is_completed_uniqid_item($order_number, $item_uniqid);        


        // print_r($check_item_data);
        // exit;


        $send_email_data['mail'] = $this->_CI->Model_common->get_send_email($check_item_data[0]['item_lang_code'], "singleBanktransfer");
        $data['setting'] = $this->_CI->Model_common->all_setting();

        // $message = $this->_CI->load->view('email/view_shop_success', $send_email_data, TRUE);

        $message = $send_email_data['mail']['message'];
    
        $message .= "<p>Total: ".$check_item_data[0]['item_update_total']."</pre>";
        $message .= "<p>Verwendungszweck: ".$order_number."</p>";


        // $this->_CI->load->library('email');
        $this->_CI->email->from($data['setting']['send_email_from']);
        $this->_CI->email->to($check_item_data[0]['email']);
        $this->_CI->email->subject($send_email_data['mail']['subject']);
        $this->_CI->email->message($message);
        $this->_CI->email->set_mailtype("html");
        
        $this->_CI->email->send();
    }
    
    public function send_email_is_completed($lang_code, $message_type, $email)
    {
        $send_email_data['mail'] = $this->_CI->Model_common->get_send_email($lang_code, $message_type);
        $data['setting'] = $this->_CI->Model_common->all_setting();

        $this->_CI->email->from($data['setting']['send_email_from']);
        $this->_CI->email->to($email);
        $this->_CI->email->subject($send_email_data['mail']['subject']);
        $this->_CI->email->message($send_email_data['mail']['message']);
        $this->_CI->email->set_mailtype("html");
        $this->_CI->email->send();
    }
    
    public function send_email_franchise($message)
    {
        $data['setting'] = $this->_CI->Model_common->all_setting();

        $this->_CI->email->from($data['setting']['send_email_from']);
        $this->_CI->email->to('franchise@irispicture.com');
        $this->_CI->email->subject('Franchise werden');
        $this->_CI->email->message($message);
        $this->_CI->email->set_mailtype("html");
        $this->_CI->email->send();
    }
    
    public function send_email_groupon($message)
    {
        $data['setting'] = $this->_CI->Model_common->all_setting();

        $this->_CI->email->from('groupon@irispicture.com');
        $this->_CI->email->to('groupon@irispicture.com');
        $this->_CI->email->subject('Groupon');
        $this->_CI->email->message($message);
        $this->_CI->email->set_mailtype("html");
        $this->_CI->email->send();
    }

    public function send_email_social_deal($message)
    {
        $data['setting'] = $this->_CI->Model_common->all_setting();

        $this->_CI->email->from('info@youririsfoto.nl');
        $this->_CI->email->to('info@youririsfoto.nl');
        $this->_CI->email->subject('Social Deal');
        $this->_CI->email->message($message);
        $this->_CI->email->set_mailtype("html");
        $this->_CI->email->send();
    }
}
