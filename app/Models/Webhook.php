<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Webhook extends Model
{
    use HasFactory;
    use SoftDeletes;
    // please refer to this link https://developer.apple.com/documentation/appstoreservernotifications/notificationtype
    public const CANCEL = "CANCEL";
    public const CONSUMPTION_REQUEST = "CONSUMPTION_REQUEST";
    public const DID_CHANGE_RENEWAL_PREF = "DID_CHANGE_RENEWAL_PREF";
    public const DID_CHANGE_RENEWAL_STATUS = "DID_CHANGE_RENEWAL_STATUS";
    public const DID_FAIL_TO_RENEW = "DID_FAIL_TO_RENEW";
    public const DID_RECOVER = "DID_RECOVER";
    public const DID_RENEW = "DID_RENEW";
    public const INITIAL_BUY = "INITIAL_BUY";
    public const INTERACTIVE_RENEWAL = "INTERACTIVE_RENEWAL";
    public const PRICE_INCREASE_CONSENT = "PRICE_INCREASE_CONSENT";
    public const REFUND = "REFUND";
    public const REVOKE = "REVOKE";
    // google play notification type
    // refrence link https://developer.android.com/google/play/billing/rtdn-reference#sub
    public const GOOGLE_SUBSCRIPTION_RECOVERED  = 1;
    public const GOOGLE_SUBSCRIPTION_RENEWED = 2;
    public const GOOGLE_SUBSCRIPTION_CANCELED = 3;
    public const GOOGLE_SUBSCRIPTION_PURCHASED = 4;
    public const GOOGLE_SUBSCRIPTION_ON_HOLD = 5;
    public const GOOGLE_SUBSCRIPTION_IN_GRACE_PERIOD = 6;
    public const GOOGLE_SUBSCRIPTION_RESTARTED = 7;
    public const GOOGLE_SUBSCRIPTION_PRICE_CHANGE_CONFIRMED  = 8;
    public const GOOGLE_SUBSCRIPTION_DEFERRED = 9;
    public const GOOGLE_SUBSCRIPTION_PAUSED = 10;
    public const GOOGLE_SUBSCRIPTSUBSCRIPTION_DEFERREDION_DEFERRED = 11;
    public const GOOGLE_SUBSCRIPTION_REVOKED = 12;
    public const GOOGLE_SUBSCRIPTION_EXPIRED = 13;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ["id"];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'payload' => 'json',
    ];

    /**
     * Scope a query to only include proccessed
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeProccessed($query)
    {
        return $query->whereNotNull('processed_at');
    }

    /**
     * Scope a query to only include not processed
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotProccessed($query)
    {
        return $query->whereNull('processed_at');
    }

    public function isProviderApple()
    {
        return $this->provider == "apple";
    }
    public function isProviderGoogle()
    {
        return $this->provider == "google";
    }
}
