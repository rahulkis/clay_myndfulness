<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSubscription extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    /**
     *
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'after_grace_period_date' => 'datetime',
        'end_date' => 'datetime',
    ];
    /**
     * Scope a query to only include active
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    /**
     * Scope a query to only include paid
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePaid($query)
    {
        return $query->where('is_paid', true);
    }
    /**
     * Scope a query to only include expired
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExpired($query)
    {
        return $query->where('after_grace_period_date', "<", now());
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }
    public function isPlanExpired()
    {
        return now() > $this->after_grace_period_date;
    }
    public function isHabitLimitCrossed()
    {
        $user                     = $this->user;
        $current_user_habit_count = $user->user_habit_routines()->active()->count();
        if ($this->is_habit_limited) {
            return $current_user_habit_count >= $this->habit_limit;
        }
        return false;
    }

    public function isDailyJournalLimitCrossed()
    {
        $user                             = $this->user;
        $current_user_daily_journal_count = $user->daily_journal_responses()->count();
        if ($this->is_daily_journal_limited) {
            return $current_user_daily_journal_count >= $this->daily_journal_limit;
        }
        return false;
    }

    public function isSelfAssesmentLimitCrossed()
    {
        $user                               = $this->user;
        $current_user_self_assessment_count = $user->self_assesment_responses()->count();
        if ($this->is_self_assessment_limited) {
            return $current_user_self_assessment_count >= $this->self_assessment_limit;
        }
        return false;
    }
}
