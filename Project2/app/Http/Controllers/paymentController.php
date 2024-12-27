<?php

namespace App\Http\Controllers;

use App\Models\child;
use App\Models\tuition;
use App\Models\tuition_info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Carbon\Carbon;


class paymentController extends Controller
{
    
    function index(){
        $user = Auth::user();
        $children = Child::where('user_id', $user->id)->with('user')->get();
        $tuitions = tuition::with('tuition_info')->get();
        return view('test/momo', compact('tuitions','children'));
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
        $tuition = tuition::with('tuition_info')->find($request->tuition_id);
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
       $redirectUrl = route('momo.callback', ['tuition_id' => $tuition->id]);

        $ipnUrl = "http://localhost:8000/atm/ipn_momo.php";
        $requestId = $orderId;
        $requestType = "payWithATM";
        $extraData = "";
        
        // Tạo chữ ký
        $rawHash = "accessKey={$accessKey}&amount={$amount}&extraData={$extraData}&ipnUrl={$ipnUrl}&orderId={$orderId}&orderInfo={$orderInfo}&partnerCode={$partnerCode}&redirectUrl={$redirectUrl}&requestId={$requestId}&requestType={$requestType}";
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = [
            'tuition'=>$tuition,
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
            'signature' => $signature,
        ];
        Log::info('Yêu cầu thanh toán MoMo:', $data);
        // Gửi yêu cầu thanh toán
        $result = $this->execPostRequest($endpoint, json_encode($data));
        Log::info('Phản hồi thanh toán MoMo:', ['response' => $result]);
        $jsonResult = json_decode($result, true);
        if (isset($jsonResult['payUrl'])) {
            return redirect($jsonResult['payUrl']);
        }        
        // Xử lý lỗi
        return back()->withErrors(['error' => $jsonResult['message'] ?? 'Lỗi không xác định']);

  
}
public function handleMoMoPaymentCallback(Request $request,$tuition_id)
{
     Log::info('MoMo Callback Data:', $request->all());
        $orderId = $request->orderId;

        $resultCode = $request->resultCode;
        $tuition = tuition::with('tuition_info')->find($tuition_id);
        // Thanh toán thành công
        if ($resultCode == '0') {
            $tuition->update(['status' => 1]);
            $this->sendPaymentSuccessEmail($tuition, $orderId);
            return redirect()->route('momo');
        }   
        else{
             return redirect()->route('momo');
        }

}
private function sendPaymentSuccessEmail($tuition, $orderId)
{
        $details = $tuition->tuition_info;
        $user = Auth::user();
        $userEmail = $user->email;
        $transactionTime = Carbon::now()->format('d-m-Y H:i:s');
        $semester = $tuition->semester;
        $amount = $tuition->tuition_info->sum('price');

        Mail::send('test.respone_email', [
            'orderId' => $orderId,
            'amount' => $amount,
            'semester' => $semester,
            'details' => $details,
            'transactionTime' => $transactionTime,
        ], function ($message) use ($userEmail) {
            $message->to($userEmail);
            $message->subject('Hóa đơn thanh toán học phí từ MoMo');
        });

}


// public function handleMoMoPaymentCallback(Request $request,$tuition, $orderId, $amount)
//     {
       
//             // thanh toán thành công
//             if ($request->resultCode == '0'){
//                      $tuition->update(['status' => 1]);
//             session(['momo_payment_order_id' => $orderId]);
//              $details = tuition_info::where('tuition_id', $request->tuition_id)->get();
//         $user = Auth::user();
//         $userEmail = $user->email;
//         $orderId ;
//         $transactionTime = Carbon::now()->format('d-m-Y H:i:s');
//         $semester = $tuition->semester;

//         Mail::send('test.respone_email', [
//             'orderId' => $orderId,
//             'amount' => $amount,
//             'semester' => $semester,
//             'details' => $details,
//             'transactionTime' => $transactionTime
//         ], function ($message) use ($userEmail) {
//             $message->to($userEmail);
//             $message->subject('Hóa đơn thanh toán học phí từ momo');
//         });
            
//             }
//             //thất bại
           
        

//         }
public function stripe_payment(Request $request)
{
    try {
        // Kiểm tra API key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Lấy thông tin học phí
        $tuition = Tuition::with('tuition_info')->find($request->tuition_id);

        if (!$tuition) {
            Log::error('Không tìm thấy học phí cho tuition_id: ' . $request->tuition_id);
            return response()->json(['error' => 'Không tìm thấy thông tin học phí'], 404);
        }

        // Kiểm tra tổng số tiền học phí
        $amount = $tuition->tuition_info->sum('price');
        if (!$amount || $amount <= 0) {
            Log::error('Số tiền học phí không hợp lệ: ' . $amount);
            return response()->json(['error' => 'Số tiền học phí không hợp lệ'], 400);
        }

        // Tạo checkout session
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'vnd',
                        'product_data' => [
                            'name' => 'Thanh toán học phí kỳ ' . $tuition->semester,
                        ],
                        'unit_amount' => $amount , 
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
             'success_url' => route('momo'),
            'cancel_url' => route('momo'),
        ]);
         $tuition->update(['status' => 1]);
            $details = tuition_info::where('tuition_id', $request->tuition_id)->get();
        $user = Auth::user();
        $userEmail = $user->email;
        $orderId = $session->id;
        $transactionTime = Carbon::now()->format('d-m-Y H:i:s');
        $semester = $tuition->semester;

        Mail::send('test.respone_email', [
            'orderId' => $orderId,
            'amount' => $amount,
            'semester' => $semester,
            'details' => $details,
            'transactionTime' => $transactionTime
        ], function ($message) use ($userEmail) {
            $message->to($userEmail);
            $message->subject('Hóa đơn thanh toán học phí từ Stripe');
        });

        return redirect($session->url);
    } catch (\Exception $e) {
        Log::error('Lỗi khi tạo Stripe Checkout Session: ' . $e->getMessage());
        return response()->json(['error' => 'Đã xảy ra lỗi trong quá trình tạo session thanh toán'], 500);
    }
}
public function processPayment(Request $request)
{
    $paymentMethod = $request->input('payment_method');

    if ($paymentMethod === 'momo') {
        return $this->momo_payment($request);
    } elseif ($paymentMethod === 'stripe') {
        return $this->stripe_payment($request);
    } else {
        return response()->json(['error' => 'Phương thức thanh toán không hợp lệ'], 400);
    }
}

public function getTuitionsByChild($childId)
{
    $tuitions = tuition::where('child_id', $childId)->with('tuition_info')->get();
    return response()->json($tuitions);
}
public function getTuitionDetails($tuitionId)
{
    $details = tuition_info::where('tuition_id', $tuitionId)->get();
    return response()->json($details);
}




}
