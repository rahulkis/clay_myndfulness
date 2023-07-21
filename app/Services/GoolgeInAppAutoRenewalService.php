<?php

namespace App\Services;

use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Notifications\AppleServerNotification;
use App\Services\Interfaces\InAppPuchasesEvents;
use Carbon\Carbon;

/***
 * handling webhook data for apple in app purchase
 */
class GoolgeInAppAutoRenewalService implements InAppPuchasesEvents
{
    public $payload;
    public $original_transaction_id;
    private $user;
    private $expiry_date;
    private $start_date;
    private $purchase_date;
    private $product_id;

    public function __construct($payload, $product_id, $purchase_token)
    {
        $this->payload  = $payload;
        $this->product_id  = $product_id;
        // convert expiration time milliseconds since Epoch to seconds since Epoch
        $start_seconds = $this->payload['startTimeMillis'] / 1000;
        $expiry_seconds = $this->payload['expiryTimeMillis'] / 1000;
        // format seconds as a datetime string and create a new UTC Carbon time object from the string
        $start_date = date("d-m-Y H:i:s", $start_seconds);
        $end_date = date("d-m-Y H:i:s", $expiry_seconds);
        $datetime = new Carbon($end_date);

        $this->start_date              = $start_date;
        $this->expiry_date             = $end_date;
        $this->original_transaction_id = $purchase_token;
        $this->purchase_date           = now();
        $this->user                    = User::where("social_id", $this->payload["profileId"])->first();
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
    public function accountOnHold(){
        // notify use about account hold
        $title   = 'Account on hold';
        $message = 'Your account is on hold by service provider.';
        if ($this->user) {
            $this->user->notify(new AppleServerNotification($title, $message));
        }
    }
    public function gracePeriodStarted(){
        // notify use about account hold
        $title   = 'Account will be expired soon.';
        $message = 'Your account will be expired soon. Please renew to continue to service.';
        if ($this->user) {
            $this->user->notify(new AppleServerNotification($title, $message));
        }
    }
    public function planRestarted()
    {
        // notify use about account restarted
        if ($this->user) {
            $this->user->activePlan->update([
                'end_date'                => $this->expiry_date,
                'after_grace_period_date' => $this->expiry_date,
            ]);
            $title   = 'Hi Welcolcome again.';
            $message = 'You subscription is restated. Thank you.';
            $this->user->notify(new AppleServerNotification($title, $message));
        }
        
    }
}
