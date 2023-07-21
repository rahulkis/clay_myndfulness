<?php

namespace App\Models;

use App\Notifications\UserHabitCreatedNotifcation;
use App\Services\UserHabitTransactionService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class UserHabitRoutine extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory, SoftDeletes;
    const COIN_LIMIT_FOR_MEDAL      = 21;
    public static $COMPLETED_STATUS = 'completed';
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ["id"];
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::created(function($model){
            $model->refresh();
            $service = new UserHabitTransactionService($model, $model->remind_at_date_time);
            $service->createHabitTransactions();
        });
        static::deleted(function ($model) {
            $model->transactions()->unProcessed()->delete();
        });
    }
    public function habit_master()
    {
        return $this->belongsTo(Habbit::class, "habit_id")->withDefault([
            "name"  => $this->habit,
            "image" => "no-image.png",
        ]);
    }
    public function transactions()
    {
        return $this->hasMany(UserRoutineTransaction::class);
    }
    /**
     * Scope a query to only include user
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUser($query, $user_id = null)
    {
        return $query->when($user_id, function ($query) use ($user_id) {
            return $query->where('user_id', $user_id);
        });
    }
    public function createTransaction($remind_at)
    {
        return $this->transactions()
            ->create([
                "user_id"           => $this->user_id,
                "habit"             => $this->habit,
                "habit_description" => $this->habit_description,
                "remind_at"         => $remind_at,
            ]);
    }
    /**
     * Scope a query to only active habit
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active_status', 1);
    }
    public function notified_transactions()
    {
        return $this->hasMany(UserRoutineTransaction::class)
            ->notified();
    }
    public function future_upcoming_transactions()
    {
        return $this->hasMany(UserRoutineTransaction::class)
            ->pending()
            ->where('remind_at', '>=', now());
    }
    public function createTask()
    {
        try {
            $task = UserHabitTask::create([
                'user_habit_routine_id' => $this->id,
                'user_id'               => $this->user_id,
                'habit_name'            => $this->habit,
                'description'           => $this->habit_description,
            ]);
            $task->load("user");
            $task->user->notify(new UserHabitCreatedNotifcation($task));
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    public function rewards()
    {
        return $this->morphMany(Reward::class, "rewardable");
    }
    public function getRemindAtDateTimeAttribute()
    {
        return Carbon::createFromFormat('H:i:s', $this->routine_time);
    }
    public function latest_trasaction()
    {
        return $this->hasOne(UserRoutineTransaction::class)->latest("remind_at");
    }
    public function belongs_user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
