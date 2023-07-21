<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InAppPaymentTransaction;
use App\Models\SubscriptionPlan;
use App\Services\ApplePaymentHandlerService;
use App\Services\GooglePaymentHandlerService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use ReceiptValidator\GooglePlay\Validator as PlayValidator;


class PaymentHandler extends Controller
{
    public function paymentDone(Request $requset)
    {
        $requset->validate([
            "receipt_data" => "required",
        ]);
        /***
         * @var \App\Models\User $user
         */
        $user = request()->user();
        try {
            if ($user->isAppleUser()) {
                $applePaymentHandler = new ApplePaymentHandlerService();
                $purchase            = $applePaymentHandler->verify($requset->receipt_data);
                if ($purchase) {
                    $subscription_plan = SubscriptionPlan::where('product_uid', $purchase['product_id'])->first();

                    if (!$subscription_plan) {

                        return response()
                            ->json([
                                "message" => "Subscription plan not found.",
                            ], Response::HTTP_INTERNAL_SERVER_ERROR);
                    }
                    InAppPaymentTransaction::create([
                        'user_id' => $user->id,
                        'type' =>  InAppPaymentTransaction::APPLE_TYPE,
                        'receipt' => $requset->receipt_data,
                        'is_valid' => true,
                        'product_uid' => $purchase['product_id'],
                        'amount' => $subscription_plan->price
                    ]);
                    $start_date              = date('Y-m-d H:i:s', strtotime($purchase['original_purchase_date']));
                    $end_date                = date('Y-m-d H:i:s', strtotime($purchase['expires_date']));
                    $after_grace_period_date = date('Y-m-d H:i:s', strtotime($purchase['expires_date']));

                    $user->updateNewPlan($subscription_plan, $start_date, $end_date, $after_grace_period_date,$purchase['original_transaction_id']);
                    return response()
                        ->json([
                            "message" => "Subscription successfull.",
                        ], Response::HTTP_OK);
                } else {
                    //invalid receipt
                    return response()
                        ->json([
                            "message" => "Invalid receipt.",
                        ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            } elseif($user->isGoogleUser()) {
                try {
                    $product_id = $requset->get("receipt.productId");
                    $purchase_token = $requset->get("receipt.purchaseToken");
                    $subscription_plan = SubscriptionPlan::where('product_uid_google', $product_id)->first();
                    $googlePaymentHandlerService = new GooglePaymentHandlerService($product_id, $purchase_token);
                    $response = $googlePaymentHandlerService->verify();
                    // convert expiration time milliseconds since Epoch to seconds since Epoch
                    $start_seconds = $response['startTimeMillis'] / 1000;
                    $expiry_seconds = $response['expiryTimeMillis'] / 1000;
                    // format seconds as a datetime string and create a new UTC Carbon time object from the string
                    $start_date = date("d-m-Y H:i:s", $start_seconds);
                    $end_date = $after_grace_period_date = date("d-m-Y H:i:s", $expiry_seconds);
                    $datetime = new Carbon($end_date);

                    // check if the expiration date is in the past
                    if (Carbon::now()->gt($datetime)) {
                        throw new Exception('Error validating transaction.', 500);
                    }
                    if (!$subscription_plan) {
                        return response()
                            ->json([
                                "message" => "Subscription plan not found.",
                            ], Response::HTTP_INTERNAL_SERVER_ERROR);
                    }
                    InAppPaymentTransaction::create([
                        'user_id' => $user->id,
                        'type' => InAppPaymentTransaction::GOOGLE_TYPE,
                        'receipt' => $response,
                        'is_valid' => true,
                        'product_uid' => $product_id,
                        'amount' => $subscription_plan->price
                    ]);
                    $user->updateNewPlan($subscription_plan, $start_date, $end_date, $after_grace_period_date, $purchase_token);

                } catch (Exception $e){
                    logger($e);
                    return response()
                        ->json([
                            "message" => "Invalid receipt.",
                        ], Response::HTTP_INTERNAL_SERVER_ERROR);
                    // example message: Error calling GET ....: (404) Product not found for this application.
                }
            }else{
                throw new \Exception("Invalid social auth type.", 1);
            }
        } catch (\Throwable $th) {
            logger($th);
            return response()
                ->json([
                    "message" => "Whoops! something went wrong.",
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
    public function paymentHistory()
    {
        $per_page = request("per_page", 20);
        $user     = auth("sanctum")->user();
        $transactions = InAppPaymentTransaction::where('user_id',$user->id)->latest()
        ->paginate($per_page);
        return response()
            ->json($transactions);
    }
}
