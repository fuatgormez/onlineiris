<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Pdf
{
    private $_CI;

    function __construct()
    {
        $this->_CI = &get_instance();
        // $this->_CI->load->model('Dynamic_Model','dm');

        $this->_CI->load->model('Model_common');
        $this->_CI->load->model('api/Model_shop');

        // $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url()) : $this->session->userdata('store_language') ;
    }

    public function index()
    {
        redirect(base_url());
    }

    public function order_confirmation($order_number)
    {
        $data['order'] = $this->_CI->Model_shop->get_order($order_number);
        $data['order_item'] = $this->_CI->Model_shop->get_order_item($order_number);
        $data['order_item_updated'] = $this->_CI->Model_shop->get_order_item_updated($order_number);
        $data['order_item_extra'] = $this->_CI->Model_shop->get_order_item_extra($order_number);
        $data['order_item_with_name'] = $this->_CI->Model_shop->get_order_item_with_name($order_number);
        $data['store'] = $this->_CI->Model_shop->get_store($data['order']['store_id']);

        $o_subtotal = $u_subtotal = 0;

        if ($data['order']['paid'] === "isPaid") {
            $data['o_zwischensumme'] = number_format($data['order']['total'] + $data['order']['shipping_total'], 2);
            $data['o_bereit_bezahlt'] = number_format($data['order']['total'], 2);
            $data['o_rabattbetrag'] = number_format($data['order']['discount_amount'], 2);
            $data['o_shipping'] = number_format($data['order']['shipping_total'], 2);
            $data['o_zu_zahlen'] = number_format(0, 2);
            $o_subtotal = $data['o_zwischensumme'];
        } else {
            $data['o_zwischensumme'] = number_format($data['order']['total'], 2);
            $data['o_bereit_bezahlt'] = number_format(0, 2);
            $data['o_rabattbetrag'] = number_format(0, 2);
            $data['o_shipping'] = number_format($data['order']['shipping_total'], 2);
            $data['o_zu_zahlen'] = number_format($data['order']['total'] - $data['o_rabattbetrag'], 2);
        }
        
        if ($data['order']['paid_update'] === "isPaid") {
            $data['u_zwischensumme'] = number_format($data['order']['total_update'] + $data['order']['shipping_total'], 2);
            $data['u_bereit_bezahlt'] = number_format($data['order']['total_update'], 2);
            $data['u_rabattbetrag'] = number_format($data['order']['discount_amount'], 2);
            $data['u_shipping'] = number_format($data['order']['shipping_total'], 2);
            $data['u_zu_zahlen'] = number_format(0, 2);
            $u_subtotal = $data['o_zwischensumme'];
        } else {
            $data['u_zwischensumme'] = number_format($data['order']['total_update'], 2);
            $data['u_bereit_bezahlt'] = number_format(0, 2);
            $data['u_rabattbetrag'] = number_format(0, 2);
            $data['u_shipping'] = number_format($data['order']['shipping_total'], 2);
            $data['u_zu_zahlen'] = number_format($data['order']['total_update'] - $data['u_rabattbetrag'], 2);
        }
        
        $data['zahlen'] = number_format($data['o_zu_zahlen'] + $data['u_zu_zahlen'], 2);

        $sub_total = $o_subtotal + $u_subtotal;
        $_tax = '1.' . $data['store']['tax'];
        $data['tax'] = $sub_total - ($sub_total / $_tax);

        $table = $this->_CI->load->view('pdf/view_pdf', $data, TRUE);
  
        try {
            $mpdf = new \Mpdf\Mpdf(
                [
                    'mode' => 'utf-8',
                    'format' => 'A4',
                    'default_font_size' => 9,
                    'default_font' => 'helvetica'
                ]
            );

            $mpdf->SetProtection(array('print'));
            $mpdf->SetTitle("Meiniris Co. - Invoice");
            $mpdf->SetAuthor("Meiniris Co.");

            // $mpdf->SetDisplayMode('fullpage');

            $pagecount = $mpdf->setSourceFile('public/pdf/invoice.pdf');

            $import_page = $mpdf->ImportPage($pagecount);
            $mpdf->UseTemplate($import_page);

            $mpdf->WriteFixedPosHTML($data['order']['billing_firstname']." ".$data['order']['billing_lastname'], 24, 60, 100,  'auto');
            $mpdf->WriteFixedPosHTML($data['order']['billing_street'] . " " . $data['order']['billing_street_no'] . ", " . $data['order']['billing_postcode'], 24, 64, 100,  'auto');
            $mpdf->WriteFixedPosHTML($data['order']['billing_city'] . " / " . $data['order']['billing_country'], 24, 68, 100,  'auto');

            $mpdf->WriteFixedPosHTML('Datum: ' . date('d-m-Y'), 140, 76, 50,  'auto');
            $mpdf->WriteFixedPosHTML('Order Nummer: ' . $order_number, 140, 80, 70,  'auto');

            $mpdf->WriteFixedPosHTML('AUFTRAGSBESTÄTIGUNG ', 15, 90, 200,  'auto');
            $mpdf->WriteFixedPosHTML('______________________________________________________________________________________________________________________________', 15, 93, 200,  'auto');
            $mpdf->WriteFixedPosHTML('ONLINE ORDER', 15, 100, 200,  'auto');


            $mpdf->WriteFixedPosHTML($table, 15, 105, 200, 'auto');
            // $mpdf->simpleTables = true;
            // $mpdf->WriteHTML($table);

            // $mpdf->WriteHTML($table);

            $confirmation_name = $order_number . ".pdf";

            // $mpdf->Output('public/pdf/' . $invoice_name, 'F');
            $mpdf->Output('public/pdf/invoice/' . $confirmation_name, 'F');
            $mpdf->debug = true;
        } catch (\Mpdf\MpdfException $e) {
            echo $e->getMessage();
        }
    }

    public function shooting_coupon($order_number)
    {
        $data['order'] = $this->_CI->Model_shop->get_order($order_number);

        try {

            $mpdf = new \Mpdf\Mpdf(
                [
                    'mode' => 'utf-8',
                    'format' => [210, 290],
                    'default_font_size' => 9,
                    'default_font' => 'helvetica',

                    'margin_left' => 0,
                    'margin_right' => 0,
                    'margin_header' => 0,
                    'margin_footer' => 0,

                    // 'orientation' => 'P'  
                ]
            );

            $mpdf->SetProtection(array('print'));
            $mpdf->SetTitle("Irispicture Co. - Invoice");
            $mpdf->SetAuthor("Irispicture Co.");
            $mpdf->showWatermarkText = true;
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->watermarkTextAlpha = 0.1;
            $mpdf->SetDisplayMode('fullpage');

            $pagecount = $mpdf->setSourceFile('public/pdf/shooting_gutschein.pdf');

            $mpdf->AddPage();
            $mpdf->Text(66, 56, 'Shooting-Gutschein Code: ' . $data['order']['security_number']);
            $mpdf->Text(66, 63, 'Order Number: ' . $order_number);
            $mpdf->Text(66, 70, 'Ablaufdatum: ' . date('d-m-Y', strtotime('+1 year')));
            $import_page = $mpdf->ImportPage($pagecount);
            $mpdf->UseTemplate($import_page);


            $coupon_name = $order_number . ".pdf";

            $mpdf->Output('public/pdf/coupon/' . $coupon_name, 'F');
            $mpdf->debug = true;
        } catch (\Mpdf\MpdfException $e) {
            echo $e->getMessage();
        }
    }
}
