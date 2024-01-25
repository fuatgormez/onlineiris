<?php
defined('BASEPATH') or exit('No direct script access allowed');

    use PostFinanceCheckout\Sdk\ApiClient;
    use PostFinanceCheckout\Sdk\ApiException;
    use PostFinanceCheckout\Sdk\ApiResponse;
    use PostFinanceCheckout\Sdk\Http\HttpRequest;
    use PostFinanceCheckout\Sdk\ObjectSerializer;

    use PostFinanceCheckout\Sdk\VersioningException;
    use PostFinanceCheckout\Sdk\Http\ConnectionException;
    use PostFinanceCheckout\Sdk\Model\TransactionCompletion;


class Postfinance extends CI_Controller
{
    public $JSON_DATA;
	public $JSON_DATA_POST;
	public $JSON_DATA_GET;
    
    //https://irispicture.ch/shop/postfinance/webhook
    
    public $spaceId;
    public $userId;
    public $secret;
    public $apiClient;

    function __construct()
    {
        parent::__construct();
        // $this->load->library('postfinance');
        
        $this->load->model('Model_common');
        $this->load->model('shop/Model_order');
        $this->load->model('shop/Model_postfinance');

        $this->load->library('shop_email');
        $this->load->library('facebook_pixel');
        

        // Configuration
        $this->spaceId = 18373;
        $this->userId = 43756;
        $this->secret = 'vU3cr7wSlPVO+uRlg1t0C9cXHSsNsiaEun5i8WY7wtk=';

        $this->apiClient = new \PostFinanceCheckout\Sdk\ApiClient($this->userId, $this->secret);
		
    }

    /**
	 * Operation completeOnline
	 *
	 * completeOnline
	 *
	 * @param int $space_id  (required)
	 * @param int $id The id of the transaction which should be completed. (required)
	 * @throws \PostFinanceCheckout\Sdk\ApiException
	 * @throws \PostFinanceCheckout\Sdk\VersioningException
	 * @throws \PostFinanceCheckout\Sdk\Http\ConnectionException
	 * @return \PostFinanceCheckout\Sdk\Model\TransactionCompletion
	 */
	public function completeOnline($entityId=33362079) {
		echo $this->completeOnlineWithHttpInfo($this->spaceId, $entityId)->getData() ; exit;
	}

    /**
	 * Operation completeOnlineWithHttpInfo
	 *
	 * completeOnline
	 *
	 * @param int $space_id  (required)
	 * @param int $id The id of the transaction which should be completed. (required)
	 * @throws \PostFinanceCheckout\Sdk\ApiException
	 * @throws \PostFinanceCheckout\Sdk\VersioningException
	 * @throws \PostFinanceCheckout\Sdk\Http\ConnectionException
	 * @return ApiResponse
	 */
	public function completeOnlineWithHttpInfo($space_id, $id) {
		// verify the required parameter 'space_id' is set
		if (is_null($space_id)) {
			throw new \InvalidArgumentException('Missing the required parameter $space_id when calling completeOnline');
		}
		// verify the required parameter 'id' is set
		if (is_null($id)) {
			throw new \InvalidArgumentException('Missing the required parameter $id when calling completeOnline');
		}
		// header params
		$headerParams = [];
		$headerAccept = $this->apiClient->selectHeaderAccept(['application/json;charset=utf-8']);
		if (!is_null($headerAccept)) {
			$headerParams[HttpRequest::HEADER_KEY_ACCEPT] = $headerAccept;
		}
		$headerParams[HttpRequest::HEADER_KEY_CONTENT_TYPE] = $this->apiClient->selectHeaderContentType([]);

		// query params
		$queryParams = [];
		if (!is_null($space_id)) {
			$queryParams['spaceId'] = $this->apiClient->getSerializer()->toQueryValue($space_id);
		}
		if (!is_null($id)) {
			$queryParams['id'] = $this->apiClient->getSerializer()->toQueryValue($id);
		}

		// path params
		$resourcePath = '/transaction-completion/completeOnline';
		// default format to json
		$resourcePath = str_replace('{format}', 'json', $resourcePath);

		// form params
		$formParams = [];
		
		// for model (json/xml)
		$httpBody = '';
		if (isset($tempBody)) {
			$httpBody = $tempBody; // $tempBody is the method argument, if present
		} elseif (!empty($formParams)) {
			$httpBody = $formParams; // for HTTP post (form)
		}
		// make the API Call
		try {
			$this->apiClient->setConnectionTimeout(ApiClient::CONNECTION_TIMEOUT);
			$response = $this->apiClient->callApi(
				$resourcePath,
				'POST',
				$queryParams,
				$httpBody,
				$headerParams,
				'\PostFinanceCheckout\Sdk\Model\TransactionCompletion',
				'/transaction-completion/completeOnline'
			);
			return new ApiResponse($response->getStatusCode(), $response->getHeaders(), $this->apiClient->getSerializer()->deserialize($response->getData(), '\PostFinanceCheckout\Sdk\Model\TransactionCompletion', $response->getHeaders()));
		} catch (ApiException $e) {
			switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\PostFinanceCheckout\Sdk\Model\TransactionCompletion',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
                case 442:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\PostFinanceCheckout\Sdk\Model\ClientError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
                case 542:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\PostFinanceCheckout\Sdk\Model\ServerError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
			}
			throw $e;
		}
	}

    function payment($total)
    {
        // Setup API client
        $client = new \PostFinanceCheckout\Sdk\ApiClient($this->userId, $this->secret);

        // Create transaction
        $lineItem = new \PostFinanceCheckout\Sdk\Model\LineItemCreate();
        
        $lineItem->setName('IRISPICTURE');
        $lineItem->setUniqueId('5412');
        $lineItem->setSku('irispicture');
        $lineItem->setQuantity(1);
        $lineItem->setAmountIncludingTax($total);
        $lineItem->setType(\PostFinanceCheckout\Sdk\Model\LineItemType::PRODUCT);

        $transactionPayload = new \PostFinanceCheckout\Sdk\Model\TransactionCreate();
        $transactionPayload->setCurrency('CHF');
        $transactionPayload->setLineItems(array($lineItem));
        $transactionPayload->setAutoConfirmationEnabled(true);

        $transactionPayload->setFailedUrl(base_url('shop/postfinance/fail'));
        $transactionPayload->setSuccessUrl(base_url('shop/postfinance/success'));

        $transaction = $client->getTransactionService()->create($this->spaceId, $transactionPayload);

        // Create Payment Page URL:
        $redirectionUrl = $client->getTransactionPaymentPageService()->paymentPageUrl($this->spaceId, $transaction->getId());

        header('Location: ' . $redirectionUrl);

    }

    public function webhook()
    {
        // $this->output->set_content_type("application/json");
        // $this->output->set_header("Access-Control-Allow-Origin: *");
        // $this->output->set_header("Access-Control-Allow-Methods: GET, OPTIONS");
        // $this->output->set_header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");

        // $this->JSON_DATA = (array)json_decode(file_get_contents("php://input"));

        // $eventId = $this->JSON_DATA['eventId'];
        // $entityId = $this->JSON_DATA['entityId'];
        // $listenerEntityId = $this->JSON_DATA['listenerEntityId'];
        // $listenerEntityTechnicalName = $this->JSON_DATA['listenerEntityTechnicalName'];
        // $spaceId = $this->JSON_DATA['spaceId'];
        // $webhookListenerId = $this->JSON_DATA['webhookListenerId'];


        //bu kisim silinebilir de durabilirde gelen datayi kayit ediyorum
        $data = array( 
			// 'data' => $spaceId .' ' . $entityId
            'data' => json_encode(file_get_contents("php://input"))
        );
        $this->Model_postfinance->add($data);



    }

    public function index()
    {
        echo "index view";
        redirect(base_url('shop'));
    }

    public function success()
    {
        redirect(base_url('shop'));
    }
    
    public function fail()
    {

        echo "fail view";
        redirect(base_url('shop'));
    }

    

}