<?php

namespace App\Services;

use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Notifications\AppleServerNotification;
use App\Services\Interfaces\InAppPuchasesEvents;

/***
 * handling webhook data for apple in app purchase
 */
class AppleInAppAutoRenewalService implements InAppPuchasesEvents
{
    public $payload;
    public $original_transaction_id;
    private $user;
    private $expiry_date;
    private $purchase_date;
    private $product_id;

    public function __construct($payload)
    {
        $this->payload  = $payload;
        $latest_recipts = $this->payload["unified_receipt"]["latest_receipt_info"];
        $receipts       = [];
        foreach ($latest_recipts as $receipt) {
            $item                            = [];
            $item['expires_date']            = $receipt['expires_date'];
            $item['expires_date_ms']         = $receipt['expires_date_ms'];
            $item['purchase_date']           = $receipt['purchase_date'];
            $item['purchase_date_ms']        = $receipt['purchase_date_ms'];
            $item['original_transaction_id'] = $receipt['original_transaction_id'];
            $item['product_id']              = $receipt['product_id'];
            $receipts[]                      = $item;
        }
        $array_cols = array_column($receipts, 'expires_date_ms');
        array_multisort($array_cols, SORT_DESC, $receipts);
        $this->expiry_date             = $receipts[0]["expires_date"];
        $this->original_transaction_id = $receipts[0]["original_transaction_id"];
        $this->purchase_date           = $receipts[0]["purchase_date"];
        $this->product_id              = $receipts[0]["product_id"];
        $this->user                    = User::where("original_transaction_id", $this->original_transaction_id)->first();
    }
    public function cancelledAutoRenewalSupport()
    {
        $title   = 'Auto renewal service cancelled.';
        $message = "Your Auto renewal service has been cancelled.";
        if ($this->user) {
            $this->user->notify(new AppleServerNotification($title, $message));
        }
    }
    public function refundRequested()
    {
        $title   = 'Refund request sent.';
        $message = "Your refund request has been sent successfully.";
        if ($this->user) {
            $this->user->notify(new AppleServerNotification($title, $message));
        }
    }
    public function renewFailBillingIssue()
    {
        $title   = 'Renew failed.';
        $message = "Your renew request failed due to some issue.";
        if ($this->user) {
            $this->user->notify(new AppleServerNotification($title, $message));
        }
    }
    public function expiredPlanRecovered()
    {
        if ($this->user) {
            if ($this->user->activePlan) {
                $this->user->activePlan->update([
                    'end_date'                => $this->expiry_date,
                    'after_grace_period_date' => $this->expiry_date,
                ]);
                return;
            }
            $subscription_plan = SubscriptionPlan::where('product_uid', $this->product_id)->first();
            if (!$subscription_plan) {
                return;
            }
            $start_date              = date('Y-m-d H:i:s', strtotime($this->purchase_date));
            $end_date                = date('Y-m-d H:i:s', strtotime($this->expiry_date));
            $after_grace_period_date = date('Y-m-d H:i:s', strtotime($this->expiry_date));

            $this->user->updateNewPlan($subscription_plan, $start_date, $end_date, $after_grace_period_date, $this->original_transaction_id);

        }
        $title   = 'Plan re-activated.';
        $message = "Your have successfully re-activated your plan.";
        if ($this->user) {
            $this->user->notify(new AppleServerNotification($title, $message));
        }
    }
    public function initialBought()
    {
        $title   = 'Subscription successfull.';
        $message = "You have subscribed successfully.";
        if ($this->user) {
            $this->user->notify(new AppleServerNotification($title, $message));
        }
    }
    public function planRenewed()
    {
        if ($this->user) {
            $this->user->activePlan->update([
                'end_date'                => $this->expiry_date,
                'after_grace_period_date' => $this->expiry_date,
            ]);
            $title   = 'Subscription renewed.';
            $message = "Your subscription has been renewed successfully.";
            $this->user->notify(new AppleServerNotification($title, $message));

        }

    }

    public function planPurchased()
    {

    }
    public function planUpgraded()
    {
        $subscription_plan = SubscriptionPlan::where('product_uid', $this->product_id)->first();
        if (!$subscription_plan) {
            return;
        }
        $start_date              = date('Y-m-d H:i:s', strtotime($this->purchase_date));
        $end_date                = date('Y-m-d H:i:s', strtotime($this->expiry_date));
        $after_grace_period_date = date('Y-m-d H:i:s', strtotime($this->expiry_date));

        $this->user->updateNewPlan($subscription_plan, $start_date, $end_date, $after_grace_period_date, $this->original_transaction_id);

        $title   = 'Subscription plan upgraded';
        $message = "Your plan has been upgraded successfully.";
        if ($this->user) {
            $this->user->notify(new AppleServerNotification($title, $message));
        }
    }
    public function planDowngraded()
    {
        $title   = 'Subscription plan downgraded';
        $message = "Your plan has been downgraded successfully. It will be effective {$this->expiry_date} onwards.";
        if ($this->user) {
            $this->user->notify(new AppleServerNotification($title, $message));
        }
    }
    public function priceIncreased()
    {
        $title   = 'Subscription plan price increased';
        $message = "Plan price has been increased.The new price will be effective from the next subscription.";
        if ($this->user) {
            $this->user->notify(new AppleServerNotification($title, $message));
        }
    }
    public function refundSuccessFull()
    {
        $title   = 'Refund Successfull.';
        $message = "Your Refund has been done successfully.";
        if ($this->user) {
            $this->user->notify(new AppleServerNotification($title, $message));
        }
    }
    public function sharingRevoked()
    {
        $title   = 'Sharing revoked.';
        $message = "Sharing revoked successfully.";
        if ($this->user) {
            $this->user->notify(new AppleServerNotification($title, $message));
        }
    }
    public function planDisabled()
    {

    }
    public function planEnabled()
    {

    }
    public function autoRenewEnabled()
    {
        $title   = 'Auto renew enabled';
        $message = 'You have successfully enabled auto renewal service.';
        if ($this->user) {
            $this->user->notify(new AppleServerNotification($title, $message));
        }
    }
    public function autoRenewDisabled()
    {
        $title   = 'Auto renew disabled';
        $message = 'You have successfully disabled auto renewal service.';
        if ($this->user) {
            $this->user->notify(new AppleServerNotification($title, $message));
        }
    }
}
