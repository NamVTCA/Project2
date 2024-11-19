<?php

namespace App\Http\Controllers;

use App\Models\tuition;
use Illuminate\Http\Request;
use App\Models\tuition_info;
use Illuminate\Support\Facades\Log;

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
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

        $result = curl_exec($ch);

        if(curl_errno($ch)) {
            Log::error('Lỗi Curl: ' . curl_error($ch));
        }
        
        curl_close($ch);
        return $result;
    }

      public function momo_payment(Request $request)
    {
        try {
            $tuition = Tuition::with('tuition_info')->find($request->tuition_id);

            if (!$tuition) {
                return response()->json(['error' => 'Không tìm thấy thông tin học phí'], 404);
            }

            $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
            $partnerCode = 'MOMOBKUN20180529';
            $accessKey = 'klm05TvNBzhg7h7j';
            $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
            $amount = (string) intval($tuition->tuition_info->sum('price'));
            $orderId = time() . "";
            $orderInfo = "Thanh toán học phí kỳ " . $tuition->semester;
            $redirectUrl = "http://localhost:8000/atm/result_atm.php";
            $ipnUrl = "http://localhost:8000/atm/ipn_momo.php";
            $requestId = $orderId;
            $requestType = "payWithATM";
            $extraData = "";

            // Create raw hash with correct parameter names
            $rawHash = "accessKey=" . $accessKey . 
                      "&amount=" . $amount . 
                      "&extraData=" . $extraData . 
                      "&ipnUrl=" . $ipnUrl . 
                      "&orderId=" . $orderId . 
                      "&orderInfo=" . $orderInfo . 
                      "&partnerCode=" . $partnerCode . 
                      "&redirectUrl=" . $redirectUrl . 
                      "&requestId=" . $requestId . 
                      "&requestType=" . $requestType;

            // Create signature
            $signature = hash_hmac("sha256", $rawHash, $secretKey);

            $data = array(
                'partnerCode' => $partnerCode,
                'partnerName' => "Test",
                'storeId' => "MomoTestStore",
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature
            );

            Log::info('Yêu cầu thanh toán MoMo:', $data);
            
            $result = $this->execPostRequest($endpoint, json_encode($data));
            Log::info('Phản hồi thanh toán MoMo:', ['response' => $result]);

            $jsonResult = json_decode($result, true);

            if (isset($jsonResult['payUrl'])) {
                session(['momo_payment_order_id' => $orderId]);
                return redirect($jsonResult['payUrl']);
            }

            Log::error('Lỗi thanh toán MoMo:', $jsonResult);
            return response()->json([
                'error' => $jsonResult['message'] ?? 'Lỗi không xác định',
                'details' => $jsonResult
            ], 400);

        } catch (\Exception $e) {
            Log::error('Ngoại lệ thanh toán MoMo:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Đã xảy ra lỗi trong quá trình xử lý thanh toán'], 500);
        }
    }

}
