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
        $redirectUrl = route('momo');
        $ipnUrl = "http://localhost:8000/atm/ipn_momo.php";
        $requestId = $orderId;
        $requestType = "payWithATM";
        $extraData = "";
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
            $tuition->update(['status' => 0]);
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

// Thêm hàm xử lý IPN để cập nhật trạng thái sau khi thanh toán thành công
public function ipn_momo(Request $request)
{
    try {
        $data = $request->all();
        Log::info('Phản hồi IPN từ MoMo:', $data);

        // Kiểm tra chữ ký
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $rawHash = "partnerCode=" . $data['partnerCode'] .
                  "&orderId=" . $data['orderId'] .
                  "&requestId=" . $data['requestId'] .
                  "&amount=" . $data['amount'] .
                  "&orderInfo=" . $data['orderInfo'] .
                  "&orderType=" . $data['orderType'] .
                  "&transId=" . $data['transId'] .
                  "&message=" . $data['message'] .
                  "&localMessage=" . $data['localMessage'] .
                  "&responseTime=" . $data['responseTime'] .
                  "&errorCode=" . $data['errorCode'] .
                  "&payType=" . $data['payType'] .
                  "&extraData=" . $data['extraData'];
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        if ($signature !== $data['signature']) {
            Log::error('Chữ ký không hợp lệ');
            return response()->json(['error' => 'Chữ ký không hợp lệ'], 400);
        }

        if ($data['errorCode'] == 0) {
            // Thanh toán thành công
            $tuition = Tuition::where('order_id', $data['orderId'])->first();
            if ($tuition) {
                $tuition->update(['status' => 1]);
                Log::info('Cập nhật trạng thái thanh toán thành công cho học phí:', ['order_id' => $data['orderId']]);
            }
        }

        return response()->json(['message' => 'Xử lý IPN thành công'], 200);
    } catch (\Exception $e) {
        Log::error('Ngoại lệ IPN MoMo:', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Đã xảy ra lỗi trong quá trình xử lý IPN'], 500);
    }
}

}
