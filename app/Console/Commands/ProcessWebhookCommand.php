<?php

namespace App\Console\Commands;

use App\Console\Commands\Interfaces\DbOptimizedCommand;
use App\Models\Webhook;
use App\Services\AppleInAppAutoRenewalService;
use App\Services\GooglePaymentHandlerService;
use App\Services\GoolgeInAppAutoRenewalService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class ProcessWebhookCommand extends Command implements DbOptimizedCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:webhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("running");
        foreach ($this->query()->cursor() as $key => $webhook) {
            $process = false;
            if ($webhook->isProviderApple()) {
                $process = $this->AppleWebhookProceesor($webhook);
            } elseif ($webhook->isProviderGoogle()) {
                $process = $this->GoogleWebhookProceesor($webhook);
            }
            if($process){
                $webhook->update(['processed_at' => now()]);
            }
        }
        $this->info("finished");
        return 0;
    }

    public function query(): Builder
    {
        return Webhook::notProccessed();
    }
    private function AppleWebhookProceesor(Webhook $webhook): Bool
    {
        try {
            $apple_in_app_service = new AppleInAppAutoRenewalService($webhook->payload);
            switch ($webhook->payload["notification_type"]) {
                case Webhook::CANCEL:
                    $apple_in_app_service->cancelledAutoRenewalSupport();
                    break;
                case Webhook::CONSUMPTION_REQUEST:
                    $apple_in_app_service->refundRequested();
                    break;
                case Webhook::DID_CHANGE_RENEWAL_PREF:
                    $apple_in_app_service->planDowngraded();
                    break;
                case Webhook::DID_CHANGE_RENEWAL_STATUS:
                    if ($webhook->payload["auto_renew_status"] == 'false') {
                        $apple_in_app_service->autoRenewDisabled();
                    } else {
                        $apple_in_app_service->autoRenewEnabled();
                    }
                    break;
                case Webhook::DID_FAIL_TO_RENEW:
                    $apple_in_app_service->renewFailBillingIssue();
                    break;
                case Webhook::DID_RECOVER:
                    $apple_in_app_service->expiredPlanRecovered();
                    break;
                case Webhook::DID_RENEW:
                    $apple_in_app_service->planRenewed();
                    break;
                case Webhook::INITIAL_BUY:
                    $apple_in_app_service->initialBought();
                    break;
                case Webhook::INTERACTIVE_RENEWAL:
                    $apple_in_app_service->planUpgraded();
                    break;
                case Webhook::PRICE_INCREASE_CONSENT:
                    $apple_in_app_service->priceIncreased();
                    break;
                case Webhook::REFUND:
                    $apple_in_app_service->refundSuccessFull();
                    break;
                case Webhook::REVOKE:
                    $apple_in_app_service->sharingRevoked();
                    break;
                default:
                    # code...
                    break;
            }
        } catch (\Throwable $th) {
            report($th);
            return false;
        }
        return true;
    }
    private function GoogleWebhookProceesor(Webhook $webhook): Bool
    {
        try {
            // checking webhook testing or subscription based or one time purchased
            $decoded_data = json_decode($webhook->payload["data"], true);
            if($decoded_data["testNotification"]){
                return true;
            }elseif($decoded_data["oneTimeProductNotification"]){
                // no one time purchase product so no need to implement
                // todo
            }elseif($decoded_data["subscriptionNotification"]){
                $subscription_data = $decoded_data["subscriptionNotification"];
                $googlePaymentHandler = new GooglePaymentHandlerService($subscription_data["subscriptionId"], $subscription_data["purchaseToken"]);
                $response = $googlePaymentHandler->verify();
                if($response){
                    $google_in_app_service = new GoolgeInAppAutoRenewalService($response);
                    switch ($subscription_data["notificationType"]) {
                        case Webhook::GOOGLE_SUBSCRIPTION_RECOVERED:
                            $google_in_app_service->expiredPlanRecovered();
                            break;
                        case Webhook::GOOGLE_SUBSCRIPTION_RENEWED:
                            $google_in_app_service->planRenewed();
                            break;
                        case Webhook::GOOGLE_SUBSCRIPTION_CANCELED:
                            $google_in_app_service->planDisabled();
                            break;
                        case Webhook::GOOGLE_SUBSCRIPTION_PURCHASED:
                            $google_in_app_service->initialBought();
                            break;
                        case Webhook::GOOGLE_SUBSCRIPTION_ON_HOLD:
                            $google_in_app_service->accountOnHold();
                            break;
                        case Webhook::GOOGLE_SUBSCRIPTION_IN_GRACE_PERIOD:
                            $google_in_app_service->gracePeriodStarted();
                            break;
                        case Webhook::GOOGLE_SUBSCRIPTION_RESTARTED:
                            $google_in_app_service->planRestarted();
                            $google_in_app_service->planRenewed();
                            break;
                        case Webhook::GOOGLE_SUBSCRIPTION_PRICE_CHANGE_CONFIRMED:
                            $google_in_app_service->priceIncreased();
                            break;
                        case Webhook::GOOGLE_SUBSCRIPTION_DEFERRED:
                            // $google_in_app_service->planPurchased();
                            break;
                        case Webhook::GOOGLE_SUBSCRIPTION_PAUSED:
                            // $google_in_app_service->planPurchased();
                            break;
                        case Webhook::GOOGLE_SUBSCRIPTSUBSCRIPTION_DEFERREDION_DEFERRED:
                            // $google_in_app_service->planPurchased();
                            break;
                        case Webhook::GOOGLE_SUBSCRIPTION_REVOKED:
                            // $google_in_app_service->planPurchased();
                            break;
                        case Webhook::GOOGLE_SUBSCRIPTION_EXPIRED:
                            // expired notification already sent from backend
                            // $google_in_app_service->planPurchased();
                            break;
                        default:
                            # code...
                            break;
                    }
                }
            }

        } catch (\Throwable $th) {
            report($th);
            return false;
        }
        return true;
    }
}
