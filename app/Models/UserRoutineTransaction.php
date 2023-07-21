<?php

namespace App\Models;

use App\Notifications\RoutineReminder;
use App\Traits\UserRelationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoutineTransaction extends Model
{
    use HasFactory;
    use UserRelationTrait;

    public static $PENDING_STATUS  = "pending";
    public static $COMPLETE_STATUS = "completed";
    public static $NOTIFIED_STAUTS = "notification_sent";
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
        'status_updated_at' => 'datetime',
        'remind_at'         => 'datetime',
    ];
    /**
     * Scope a query to only include todays
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTodays($query)
    {
        return $query->where('remind_at', ">=", today());
    }
    /**
     * Scope a query to only include un processed transaction
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnProcessed($query)
    {
        return $query->where('is_processed', false);
    }
    /**
     * Scope a query to only include processed transaction
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeProcessed($query)
    {
        return $query->where('is_processed', true);
    }
    /**
     * Scope a query to only include Pending
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where("status", UserRoutineTransaction::$PENDING_STATUS);
    }
    /**
     * Scope a query to only include notified
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotified($query)
    {
        return $query->where('status', UserRoutineTransaction::$NOTIFIED_STAUTS);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function user_habit()
    {
        return $this->belongsTo(UserHabitRoutine::class, "user_habit_routine_id");
    }
    public function active_user_habit()
    {
        return $this->belongsTo(UserHabitRoutine::class, "user_habit_routine_id")->active();
    }
    public function sendReminder()
    {
        $this->update([
            "notified_at" => now(),
            "status"      => "notification_sent",
        ]);
        $this->user->notify(new RoutineReminder($this));
    }
    public function routineCompletedEvent()
    {
        # code...
    }
    /**
     * Scope a query to only include notified past transactions
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePastNotifiedTransactions($query)
    {
        return $query->whereDate('created_at', date('Y-m-d'))->where('status', 'notification_sent');
    }
}
