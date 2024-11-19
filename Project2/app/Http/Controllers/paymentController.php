<?php

namespace App\Http\Controllers;

use App\Models\tuition;
use Illuminate\Http\Request;
use App\Models\tuition_info;

class paymentController extends Controller
{
    function index(){
         $tuitions = tuition::with('tuition_info')->get();
        return view('test/momo', compact('tuitions'));
    }

    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    public function momo_payment(Request $request)
    {
        
        $tuition = tuition::with('tuition_info')->find($request->tuition_id);

        if (!$tuition) {
            return response()->json(['error' => 'Tuition not found'], 404);
        }

      $endpoint = "https://test-payment.momo.vn/gw_payment/transactionProcessor";
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

        $orderInfo = "Thanh toán học phí kỳ " . $tuition->semester;
        $amount = $tuition->tuition_info->sum('price'); 
        $orderId = time() . "";
        $returnUrl = url('/payment/return');
        $notifyUrl = url('/payment/notify');
        $requestId = time() . "";
        $requestType = "payWithMoMoATM";
        $extraData = "";

        $rawHash = "partnerCode=$partnerCode&accessKey=$accessKey&requestId=$requestId&amount=$amount&orderId=$orderId&orderInfo=$orderInfo&returnUrl=$returnUrl&notifyUrl=$notifyUrl&extraData=$extraData&requestType=$requestType";
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = array(
            'partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'returnUrl' => $returnUrl,
            'notifyUrl' => $notifyUrl,
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );

        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);
        
        return redirect($jsonResult['payUrl']);
    }
}

