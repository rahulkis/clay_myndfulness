<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;
    public static $GOOGLE_TYPE = "google";
    public static $APPLE_TYPE = "apple";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ["id"];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'response_created_at' => 'datetime',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleted(function(User $user){
            $user->onboarding_responses()->delete();
            $user->self_assesment_responses()->delete();
            $user->daily_journal_responses()->delete();
            $user->user_habit_routines()->delete();
            $user->user_routine_transactions()->delete();
            $user->rewards()->delete();
            $user->tasks()->delete();
        });
    }

    public function isOnBoardingCompleted()
    {
        return $this->is_onboard_completed;
    }
    /**
     * Scope a query to only include search
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        $query->where("name", "LIKE", "%{$search}%");
        $query->orWhere("email", "LIKE", "%{$search}%");
        return $query;
    }
    /**
     * Scope a query to only include planExpired
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePlanExpired($query)
    {
        return $this->whereHas('activePlan' , function($q){
            $q->expired();
        });
    }
    /**
     * Scope a query to only include DoesntHavePlan
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDoesnthaveAnyPlan($query)
    {
        return $query->whereDoesntHave('subscriptions', function($query){
            return $query->active();
        });
    }
    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }
    public function onboarding_responses()
    {
        return $this->hasMany(OnboardingResponse::class);
    }
    public function self_assesment_responses()
    {
        return $this->hasMany(SelfAssessmentResponse::class);
    }
    public function daily_journal_responses()
    {
        return $this->hasMany(DailyJournalReponse::class);
    }
    public function user_habit_routines()
    {
        return $this->hasMany(UserHabitRoutine::class);
    }
    public function user_routine_transactions()
    {
        return $this->hasMany(UserRoutineTransaction::class);
    }
    public function user_routine_tasks()
    {
        return $this->hasMany(UserHabitTask::class);
    }
    public function rewards()
    {
        return $this->hasMany(Reward::class);
    }

    public function tasks()
    {
        return $this->hasMany(UserHabitTask::class);
    }
    public function isAppleUser()
    {
        return $this->social_auth_type === static::$APPLE_TYPE;
    }
    public function isGoogleUser()
    {
        return $this->social_auth_type === static::$GOOGLE_TYPE;
    }
    public function activePlan()
    {
        return $this->belongsTo(UserSubscription::class, "user_subscription_id", "id");
    }
    public function deActivateAllHabit()
    {
        return UserHabitRoutine::where("user_id", $this->id)
            ->update(["active_status" => false]);
    }
    public function updateNewPlan(SubscriptionPlan $subscription_plan, $start_date, $end_date, $after_grace_period_date,$original_transaction_id = null)
    {
        UserSubscription::where("user_id", $this->id)->update([
            "is_active" => 0
        ]);
        $user_subscription = UserSubscription::create([
            'user_id'                    => $this->id,
            'subscription_plan_id'       => $subscription_plan->id,
            'name'                       => $subscription_plan->name,
            'description'                => $subscription_plan->description,
            'is_paid'                    => true,
            'price'                      => $subscription_plan->price,
            'duration'                   => $subscription_plan->duration,
            'is_habit_limited'           => $subscription_plan->is_habit_limited,
            'habit_limit'                => $subscription_plan->habit_limit,
            'is_self_assessment_limited' => $subscription_plan->is_self_assessment_limited,
            'self_assessment_limit'      => $subscription_plan->self_assessment_limit,
            'is_daily_journal_limited'   => $subscription_plan->is_daily_journal_limited,
            'daily_journal_limit'        => $subscription_plan->daily_journal_limit,
            'start_date'                 => $start_date,
            'end_date'                   => $end_date,
            'after_grace_period_date'    => $after_grace_period_date,
            'is_active'                  => true,
        ]);
        $update_array = [
            'user_subscription_id' => $user_subscription->id
        ];
        if($original_transaction_id){
            $update_array['original_transaction_id'] = $original_transaction_id;
        }
        $this->update($update_array);
        return $user_subscription;
    }
}
