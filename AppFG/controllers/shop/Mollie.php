<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mollie extends CI_Controller
{
    public $mollie;
    public $select_mollie_key;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Model_common');
        $this->load->model('shop/Model_order');

        $this->load->library('shop_email');
        $this->load->library('facebook_pixel');

        $this->mollie = new \Mollie\Api\MollieApiClient();
        $this->select_mollie_key =  $this->Model_common->all_setting_shop();

        if ($this->select_mollie_key["mollie_current_key"] === "test") {
            $this->mollie->setApiKey($this->select_mollie_key["mollie_test_key"]);
        } else {
            $this->mollie->setApiKey($this->select_mollie_key["mollie_live_key"]);
        }

    }

    public function webhook()
    {
        try {
    
            $payment = $this->mollie->payments->get($_POST["id"]);

            if($payment->status === 'paid')
            {
                $paid = 'isPaid';
            } else {
                $paid = 'isOpen';
            }

            $get_order = $this->Model_order->get_order($payment->metadata->check_order_response); //get order with order_number

            if ($payment->isPaid() && ! $payment->hasRefunds() && ! $payment->hasChargebacks()) {
                /*
                 * The payment is paid and isn't refunded or charged back.
                 * At this point you'd probably want to start the process of delivering the product to the customer.
                 */

                 //pixel calismiyor url i düzelt
                if ($this->select_mollie_key["mollie_current_key"] !== "test") {}
                    if (base_url() === "https://www.youririsfoto.be/" || base_url() === "https://www.youririsfoto.nl/") {
                        $this->facebook_pixel->Purchase(
                            $get_order['total'],
                            $this->Model_common->all_setting()['facebook_access_token'],
                            $this->Model_common->all_setting()['facebook_init'],
                            $get_order//musteri bilgilerini facebooka gondermek icin
                        );
                    }

                $paid = 'isPaid';

                $this->shop_email->send_email(
                    $get_order['store_lang_code'],
                    'mollie',
                    $get_order['billing_email'],
                    $get_order['order_number']
                );

            } elseif ($payment->isOpen()) {
                /*
                 * The payment is open.
                 */
                $paid = 'isOpen';
            } elseif ($payment->isPending()) {
                /*
                 * The payment is pending.
                 */
                $paid = 'isPending';
            } elseif ($payment->isFailed()) {
                /*
                 * The payment has failed.
                 */
                $this->shop_email->single_email(
                    $get_order['store_lang_code'],
                    'MollieError',
                    $get_order['billing_email'],
                    $get_order['order_number']
                );
                $paid = 'isFailed';
            } elseif ($payment->isExpired()) {
                /*
                 * The payment is expired.
                 */
                $paid = 'isExpired';
            } elseif ($payment->isCanceled()) {
                /*
                 * The payment has been canceled.
                 */
                $paid = 'isCanceled';
            } elseif ($payment->hasRefunds()) {
                /*
                 * The payment has been (partially) refunded.
                 * The status of the payment is still "paid"
                 */
                $paid = 'hasRefunds';
            } elseif ($payment->hasChargebacks()) {
                /*
                 * The payment has been (partially) charged back.
                 * The status of the payment is still "paid"
                 */
                $paid = 'hasChargebacks';
            }

            $order_data = array(
                'paid' => $paid
            );
            $update_order = $this->Model_order->update_order($payment->metadata->check_order_response, $order_data);

            $data = array( 
                'payment_id' => $_POST['id'],
                'status' => $payment->status,
                'order_number' => $payment->metadata->check_order_response,
                'data' => json_encode($payment) 
            );

            return $this->Model_order->mollie($data);

        } catch (\Mollie\Api\Exceptions\ApiException $e) {
            echo "API call failed: " . htmlspecialchars($e->getMessage());
        }

    }
}
