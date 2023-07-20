<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Traits\ApiDesignTrait;
use Illuminate\Support\Facades\Auth;
use Paytabscom\Laravel_paytabs\Facades\paypage;
use Illuminate\Http\Response;
class PaymentController extends Controller
{
    use ApiDesignTrait;
    

    /**
     * Steps
     * 1. git user order data
     * 2. create order [id, amount, description,phone, street, city, state, country, zip]
     * 3. retrieve stored order Data
     * 4. call methode to created payment page
     * 5. send data to paytabs && check response code and message
     * 6. store/update tranRef and order_id ,status in payment table
     * 7. return appropriately response 
     */

     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $status)
    {
        $result = $request;
        try {
            $user = Auth::user();
            $user_id = $user->id;
            $paymentData = [
                'payment_status' => $status,
                'payment_response' => json_encode($result->input()), // Assuming it's an array or object to be converted to JSON
                'tran_ref' => $result->input('tranRef'),
                'user_id' => $user_id,
                'order_id' => $result->input('cartId'),
            ];
            $payment = Payment::create($paymentData);
        } catch (Exception $e) {
            return $this->ApiResponse(422, 'operation failed');
        }
        return $this->ApiResponse(200, 'Operation Done',null,$payment);
    }
    
    /**
     * Create Payment page Called after the Order have been stored successfully 
     * @param mixed $order
     * @return mixed
     */
    public function initiatePayment ($order)
    {
        $cart_id = $order->id;
        $cart_amount  = $order->total_price;
        $cart_description = "no description";
        $return = "https://webhook.site/6cbd25cb-434f-496b-810f-03c555a4f908";//route('payment.return');
        $callback = "https://webhook.site/6cbd25cb-434f-496b-810f-03c555a4f908";//route('payment.call_back');
        $language = 'ar';
        $transaction_type = 'sale';

        $pay = paypage::sendPaymentCode("all")
            ->sendTransaction($transaction_type)
            ->sendCart($cart_id, $cart_amount, $cart_description)
            ->sendHideShipping($on = false)
            ->sendURLs($return, $callback)
            ->sendLanguage($language)
            ->sendFramed($on = false)
            ->create_pay_page(); // to initiate payment page
        return $pay;
    }

    /**
     * Handle Return URL Response 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function handlePaymentResponse(Request $request):Response
    {
        $result = $request;
        $respCode = $result->input('respCode');
        $respStatus = $result->input('respStatus');

        if ($respStatus === 'A' && $respCode == 'G42647') {
            $this->store($request,'success');
            return $this->ApiResponse(422, 'Operation Code: ',$result->input('tranRef'));
            // send notifications to admin and company, etc.
        } elseif ($respStatus === 'D') {
            $this->store($request,'failed');
            return $this->ApiResponse(422, 'operation declined',$result->input('respMessage'));
        } else {
            return $this->ApiResponse(422, 'operation declined',$this->handleResponse($result));
        }
    }

    /**
     * Handle response code  
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function handleResponse(Request $request) 
    {
        switch ($request->input('respCode')) {
                case '200':
                    /*200 & E: Invalid card number*/
                    return 'Payment failed: ' . $request->input('respMessage');
                case '201':
                    /*201 & E: Invalid card expiry date*/
                case '202':
                    /*202 & E: Invalid card security code (CVV) */
                    return 'Payment failed: ' .  $request->input('respMessage');
                case '302':
                    /*302 & D: Card expired/Incorrect expiry date */
                case '305':
                    /*305 & D: Card security code (CVV) mismatch */
                case '316':
                    /*316 & D: Insufficient funds */
                    return 'Payment declined: ' .  $request->input('respMessage');
                case '500':
                case '501':
                case '502':
                case '503':
                    // Payment declined, 
                    return 'Payment declined: ' .  $request->input('respMessage');
                case '600':
                    // Payment is pending, show message to user
                    return 'Payment is pending: ' .  $request->input('respMessage');
                default:
                    return 'Payment failed: contact with support team'.  $request->input('respMessage');;
            }
    }
    public function refund (Request $request)
    {
        $refund = Paypage::refund('tran_ref','order_id','amount','refund_reason');
        return $refund;
    }

    public function void (Request $request)
    {
        $void = Paypage::void('tran_ref','order_id','amount','void description');
        return $void;
    }

    public function details (Request $request)
    {
        $transaction = Paypage::queryTransaction('tran_ref');
        return $transaction;
    }

    /*
   * Example of response received from PayTabs in case HTTPS protocol used in return URL
    $acquirerMessage=;
    $acquirerRRN=;
    $cartId=10;
    $customerEmail=mahmmoudmohamed202040gmail.com;
    $respCode=G42647; 200 300
    $respMessage=Authorised;
    $respStatus=A;
    $signature=722b842daaa9f6bef11756573ec4ef5c30a532ddffbc17b91290c28e81bb6779;
    $token= ;
    $tranRef=TST2318701654598;
    */
}
