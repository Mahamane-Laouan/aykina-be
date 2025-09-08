<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalHttp\HttpException;

class PayPalController extends BaseController
{
  private $clientId = 'AVzMVWctLyouPgmfv9Nh6E5KakydG4JHiFGm-fgg6HRqFYUW-gHVKS1ebRfPgDOr2uYABGGcnU_3RaSL';
  private $clientSecret = 'EGWCyNAp9oTXjlmckT8DO9lepyKFrWQy2KvPPmrUsard4K98fuArUYbFQl7CaHdhk4Ehdg_hPkToods4';

    private function getApiContext()
    {
        return new \PayPalCheckoutSdk\Core\PayPalHttpClient(
            new \PayPalCheckoutSdk\Core\SandboxEnvironment($this->clientId, $this->clientSecret)
        );
    }

    public function PayPalCheckout(Request $request)
    {
        try {
            $amount = $request->input('amount');
            $apiContext = $this->getApiContext();

            $requestObj = new OrdersCreateRequest();
            $requestObj->prefer('return=representation');
            $requestObj->body = [
                'intent' => 'CAPTURE',
                'purchase_units' => [[
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => $amount
                    ]
                ]]
            ];

            $response = $apiContext->execute($requestObj);

            return response()->json(['order_id' => $response->result->id]);
        } catch (HttpException $ex) {
            return response()->json(['error' => 'error', 'message' => $ex->getMessage()], 500);
        }
    }

    public function capturePayment(Request $request)
    {
        try {
            $apiContext = $this->getApiContext();
            $orderId = $request->input('order_id');

            $captureRequest = new OrdersCaptureRequest($orderId);
            $response = $apiContext->execute($captureRequest);

            return response()->json(['status' => $response->result->status]);
        } catch (HttpException $ex) {
            return response()->json(['error' => 'error', 'message' => $ex->getMessage()], 500);
        }
    }
}