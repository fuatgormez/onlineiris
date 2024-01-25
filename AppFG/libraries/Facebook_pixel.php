<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Facebook_pixel
{
	/**
     * Change these values with your own
     */
    // private $token = 'YOUR-SECRET-TOKEN';
    // private $pixel_id = 'YOUR-PIXEL-ID';
    // Last stable version on April 2021
    private $api_version = 'v12.0';

    function __construct()
    {


        //youririsfoto.com Facebook Pixel
		// $pixel_id = '1004779750102371';
		// $token = 'EAAJJ8YL5R6EBAL5gJywM8viLct89x8a4KtgRZAwSfNzmW2vZAeg9NPXKOxdc4gz8LtYK2dZAZCuZACFcxAImeMyTaSjZCWpCEZAD2gM2ello1m8RAc1k7bNDZAuQ4a6iONmbKrztDhscdZCDGogUqLWq3cyljJdKxZBPlAZCD9i4ERylHnFTYCOzgSAy9QXi9FR9PnXyxmLQqkh9nZBXZBI1tTtdtfmBatTUUPUZBiLqD01xTei7gKsQzJ7eOZADVkFAapRLtwZD';
		
        //client_ip_address = $_SERVER['REMOTE_ADDR']
        //client_user_agent = $_SERVER['HTTP_USER_AGENT']
		$this->_CI = &get_instance();
        $this->_CI->load->model('Model_common');
        $this->_CI->load->model('api/Model_ads_log');
    }

    //$pixel_id, $token, $order_number, $client_email, $client_phone, $client_ip_address, $client_user_agent, $currency, $total
    function Purchase($pixel_id, $token, $data)
    {
        
        //youririsfoto.com Facebook Pixel
		// $pixel_id = '1004779750102371';
		// $token = 'EAAJJ8YL5R6EBAL5gJywM8viLct89x8a4KtgRZAwSfNzmW2vZAeg9NPXKOxdc4gz8LtYK2dZAZCuZACFcxAImeMyTaSjZCWpCEZAD2gM2ello1m8RAc1k7bNDZAuQ4a6iONmbKrztDhscdZCDGogUqLWq3cyljJdKxZBPlAZCD9i4ERylHnFTYCOzgSAy9QXi9FR9PnXyxmLQqkh9nZBXZBI1tTtdtfmBatTUUPUZBiLqD01xTei7gKsQzJ7eOZADVkFAapRLtwZD';
		
        //client_ip_address = $_SERVER['REMOTE_ADDR']
        //client_user_agent = $_SERVER['HTTP_USER_AGENT']
		$url = 'https://graph.facebook.com/v12.0/'.$pixel_id.'/events?access_token='.$token;
		
		$payload = array(
			'data' => [
				array(
					"action_source" => "website",
					"event_id" => $data['order_number'],
					"event_name" => "TEST-Purchase",//" TestEvent",
					"event_time" => time(),
					"user_data" => array(
						"client_ip_address" => $data['client_ip_address'],
						"client_user_agent" => $data['client_user_agent'],
						"fn" => hash("sha256", $data['billing_firstname']),
						"ln" => hash("sha256", $data['billing_lastname']),
						"em" => hash("sha256", $data['billing_email']),
						"ph" => hash("sha256", $data['billing_phone']),
						"zp" => hash("sha256", $data['billing_postcode']),
						"ct" => hash("sha256", $data['billing_city']),
						"st" => hash("sha256", $data['store_lang_code']),
						"country" => hash("sha256", $data['billing_country']),
					),
					"custom_data" => array(
						"currency" => $data['store_currency_code'],
						"value" => $data['total']
					)
				),
			]
			// "test_event_code" => "TEST219"
		);
		

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		// execute!
		$result = curl_exec($ch);
		
		// close the connection, release resources used
		curl_close($ch);
		
		// do anything you want with your response
		
		// Was succesfully received by FB?
        $json_response = json_decode($result, true);
        if (isset($json_response['events_received']) && $json_response['events_received'] == 1){
            // error_log($json_respone['fbtrace_id']);
            // return $json_response['fbtrace_id'];
        } else {
            // Debug response by uncommenting this line
            //error_log(print_r($result, 1));
        }

		$this->InsertLog('facebook', $pixel_id, $token, 'Purchase', $payload);

        // print_r($result);
        // echo $json_response['fbtrace_id'];
    }
    
    function PageView($pixel_id, $token)
    {
		$url = 'https://graph.facebook.com/v12.0/'.$pixel_id.'/events?access_token='.$token;
		
		$payload = array(
			'data' => [
				array(
					"action_source" => "website",
					"event_name" => "TEST-PageView",//" TestEvent",
					"event_time" => time()
				),
			]
			// "test_event_code" => "TEST219"
		);
		

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		// execute!
		$result = curl_exec($ch);
		
		// close the connection, release resources used
		curl_close($ch);
		
		// do anything you want with your response
		
		// Was succesfully received by FB?
        $json_response = json_decode($result, true);
        if (isset($json_response['events_received']) && $json_response['events_received'] == 1){
            // error_log($json_respone['fbtrace_id']);
            // return $json_response['fbtrace_id'];
        } else {
            // Debug response by uncommenting this line
            //error_log(print_r($result, 1));
        }

		$this->InsertLog('facebook', $pixel_id, $token, 'PageView', $payload);

        // print_r($result);
        // echo $json_response['fbtrace_id'];
    }
       
    function ViewContent($pixel_id, $token)
    {
		$url = 'https://graph.facebook.com/v12.0/'.$pixel_id.'/events?access_token='.$token;
		
		$payload = array(
			'data' => [
				array(
					"action_source" => "website",
					"event_name" => "TEST-ViewContent",//" TestEvent",
					"event_time" => time()
				),
			]
			// "test_event_code" => "TEST219"
		);
		

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		// execute!
		$result = curl_exec($ch);
		
		// close the connection, release resources used
		curl_close($ch);
		
		// do anything you want with your response
		
		// Was succesfully received by FB?
        $json_response = json_decode($result, true);
        if (isset($json_response['events_received']) && $json_response['events_received'] == 1){
            // error_log($json_respone['fbtrace_id']);
            // return $json_response['fbtrace_id'];
        } else {
            // Debug response by uncommenting this line
            //error_log(print_r($result, 1));
        }

		$this->InsertLog('facebook', $pixel_id, $token, 'ViewContent', $payload);

        // print_r($result);
        // echo $json_response['fbtrace_id'];
    }
    
    function CustomizeProduct($pixel_id, $token)
    {
		$url = 'https://graph.facebook.com/v12.0/'.$pixel_id.'/events?access_token='.$token;
		
		$payload = array(
			'data' => [
				array(
					"action_source" => "website",
					"event_name" => "TEST-CustomizeProduct",//" TestEvent",
					"event_time" => time()
				),
			]
			// "test_event_code" => "TEST219"
		);
		

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		// execute!
		$result = curl_exec($ch);
		
		// close the connection, release resources used
		curl_close($ch);
		
		// do anything you want with your response
		
		// Was succesfully received by FB?
        $json_response = json_decode($result, true);
        if (isset($json_response['events_received']) && $json_response['events_received'] == 1){
            // error_log($json_respone['fbtrace_id']);
            // return $json_response['fbtrace_id'];
        } else {
            // Debug response by uncommenting this line
            //error_log(print_r($result, 1));
        }

		$this->InsertLog('facebook', $pixel_id, $token, 'CustomizeProduct', $payload);

        // print_r($result);
        // echo $json_response['fbtrace_id'];
    }
    
    function AddPaymentInfo($pixel_id, $token)
    {
		$url = 'https://graph.facebook.com/v12.0/'.$pixel_id.'/events?access_token='.$token;
		
		$payload = array(
			'data' => [
				array(
					"action_source" => "website",
					"event_name" => "TEST-AddPaymentInfo",//" TestEvent",
					"event_time" => time()
				),
			]
			// "test_event_code" => "TEST219"
		);
		

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		// execute!
		$result = curl_exec($ch);
		
		// close the connection, release resources used
		curl_close($ch);
		
		// do anything you want with your response
		
		// Was succesfully received by FB?
        $json_response = json_decode($result, true);
        if (isset($json_response['events_received']) && $json_response['events_received'] == 1){
            // error_log($json_respone['fbtrace_id']);
            // return $json_response['fbtrace_id'];
        } else {
            // Debug response by uncommenting this line
            //error_log(print_r($result, 1));
        }

		$this->InsertLog('facebook', $pixel_id, $token, 'AddPaymentInfo', $payload);

        // print_r($result);
        // echo $json_response['fbtrace_id'];
    }
    
    function InitiateCheckout($pixel_id, $token)
    {
		$url = 'https://graph.facebook.com/v12.0/'.$pixel_id.'/events?access_token='.$token;
		
		$payload = array(
			'data' => [
				array(
					"action_source" => "website",
					"event_name" => "TEST-CompleteRegistration",//" TestEvent",
					"event_time" => time()
				),
			]
			// "test_event_code" => "TEST219"
		);
		

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		// execute!
		$result = curl_exec($ch);
		
		// close the connection, release resources used
		curl_close($ch);
		
		// do anything you want with your response
		
		// Was succesfully received by FB?
        $json_response = json_decode($result, true);
        if (isset($json_response['events_received']) && $json_response['events_received'] == 1){
            // error_log($json_respone['fbtrace_id']);
            // return $json_response['fbtrace_id'];
        } else {
            // Debug response by uncommenting this line
            //error_log(print_r($result, 1));
        }

		$this->InsertLog('facebook', $pixel_id, $token, 'InitiateCheckout', $payload);

        // print_r($result);
        // echo $json_response['fbtrace_id'];
    }
    
	function CompleteRegistration($pixel_id, $token)
    {
		$url = 'https://graph.facebook.com/v12.0/'.$pixel_id.'/events?access_token='.$token;
		
		$payload = array(
			'data' => [
				array(
					"action_source" => "website",
					"event_name" => "TEST-CompleteRegistration",//" TestEvent",
					"event_time" => time()
				),
			]
			// "test_event_code" => "TEST219"
		);
		

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		// execute!
		$result = curl_exec($ch);
		
		// close the connection, release resources used
		curl_close($ch);
		
		// do anything you want with your response
		
		// Was succesfully received by FB?
        $json_response = json_decode($result, true);
        if (isset($json_response['events_received']) && $json_response['events_received'] == 1){
            // error_log($json_respone['fbtrace_id']);
            // return $json_response['fbtrace_id'];
        } else {
            // Debug response by uncommenting this line
            //error_log(print_r($result, 1));
        }

		$this->InsertLog('facebook', $pixel_id, $token, 'CompleteRegistration', $payload);

        // print_r($result);
        // echo $json_response['fbtrace_id'];
    }
    
    // $pixel_id, $token, $total, $currency_code
    function AddToCart($pixel_id, $token, $total, $currency_code )
    {
		$url = 'https://graph.facebook.com/v12.0/'.$pixel_id.'/events?access_token='.$token;
		
		$payload = array(
			'data' => [
				array(
					"action_source" => "website",
					"event_id" => 123 . time(),
					"event_name" => "TEST-AddToCart",//" TestEvent",
					"event_time" => time(),
					"custom_data" => array(
						"currency" => $currency_code,
						"value" => $total
					)
				),
			]
			// "test_event_code" => "TEST219"
		);
		

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		// execute!
		$result = curl_exec($ch);
		
		// close the connection, release resources used
		curl_close($ch);
		
		// do anything you want with your response
		
		// Was succesfully received by FB?
        $json_response = json_decode($result, true);
        if (isset($json_response['events_received']) && $json_response['events_received'] == 1){
            // error_log($json_respone['fbtrace_id']);
            // return $json_response['fbtrace_id'];
        } else {
            // Debug response by uncommenting this line
            //error_log(print_r($result, 1));
        }

		$this->InsertLog('facebook', $pixel_id, $token, 'AddToCart', $payload);

        // print_r($result);
        // echo $json_response['fbtrace_id'];
    }

	function Contact($pixel_id, $token)
    {
		$url = 'https://graph.facebook.com/v12.0/'.$pixel_id.'/events?access_token='.$token;
		
		$payload = array(
			'data' => [
				array(
					"action_source" => "website",
					"event_name" => "TEST-Contact",
					"event_time" => time()
				),
			]
			// "test_event_code" => "TEST219"
		);
		

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		// execute!
		$result = curl_exec($ch);
		
		// close the connection, release resources used
		curl_close($ch);
		
		// do anything you want with your response
		
		// Was succesfully received by FB?
        $json_response = json_decode($result, true);
        if (isset($json_response['events_received']) && $json_response['events_received'] == 1){
            // error_log($json_respone['fbtrace_id']);
            // return $json_response['fbtrace_id'];
        } else {
            // Debug response by uncommenting this line
            //error_log(print_r($result, 1));
        }

		$this->InsertLog('facebook', $pixel_id, $token, 'Contact', $payload);

        // print_r($result);
        // echo $json_response['fbtrace_id'];
    }
	
	function FindLocation($pixel_id, $token)
    {
		$url = 'https://graph.facebook.com/v12.0/'.$pixel_id.'/events?access_token='.$token;
		
		$payload = array(
			'data' => [
				array(
					"action_source" => "website",
					"event_name" => "TEST-FindLocation",
					"event_time" => time()
				),
			]
			// "test_event_code" => "TEST219"
		);
		

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		// execute!
		$result = curl_exec($ch);
		
		// close the connection, release resources used
		curl_close($ch);
		
		// do anything you want with your response
		
		// Was succesfully received by FB?
        $json_response = json_decode($result, true);
        if (isset($json_response['events_received']) && $json_response['events_received'] == 1){
            // error_log($json_respone['fbtrace_id']);
            // return $json_response['fbtrace_id'];
        } else {
            // Debug response by uncommenting this line
            //error_log(print_r($result, 1));
        }

		$this->InsertLog('facebook', $pixel_id, $token, 'FindLocation', $payload);

        // print_r($result);
        // echo $json_response['fbtrace_id'];
    }
	
	function Test($pixel_id, $token, $test_event_code, $event_name)
    {
		$url = 'https://graph.facebook.com/v12.0/'.$pixel_id.'/events?access_token='.$token;
		$url = "https://graph.facebook.com/{$this->api_version}/{$pixel_id}/events?access_token={$token}";
		
		$payload = array(
			'data' => [
				array(
					"action_source" => "FUAT TEST",
					"event_name" => $event_name,
					"event_time" => time()
				),
			],
			"test_event_code" =>  $test_event_code
		);
		

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		// execute!
		$result = curl_exec($ch);
		
		// close the connection, release resources used
		curl_close($ch);
		
		// do anything you want with your response
		
		// Was succesfully received by FB?
        $json_response = json_decode($result, true);
        if (isset($json_response['events_received']) && $json_response['events_received'] == 1){
            // error_log($json_respone['fbtrace_id']);
            // return $json_response['fbtrace_id'];
        } else {
            // Debug response by uncommenting this line
            //error_log(print_r($result, 1));
        }

		// echo json_encode(array('payload:' => $payload)) ;
		
		// echo '<br>';
        
		// print_r('Result: ' . $result);

		// echo '<br>';

        // echo 'Response trace_id: ' . $json_response['fbtrace_id'];

		$this->InsertLog('facebook', $pixel_id, $token, 'Test', $payload);
    }

	/**
	 * Undocumented function
	 *
	 * @param [Facebook etc] $platform
	 * @param [Pixel id] $tranking_id
	 * @param [type] $token
	 * @param [Purchase etc] $event_name
	 * @param [data] $payload
	 * @return void
	 */
	function InsertLog($platform, $tracking_id, $token, $event_name, $payload)
	{
		$data = array(
			'platform' => $platform,
			'tracking_id' => $tracking_id,
			'token' => $token,
			'event_name' => $event_name,
			'payload' => json_encode($payload),
			'date' => date('Y-m-d'),
			'time' => date('H:i:s')
		);

		$this->_CI->Model_ads_log->insert($data);
	}
}
