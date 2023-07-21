<?php

namespace App\Models;

use App\Traits\UserRelationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHabitTask extends Model
{
    use HasFactory;
    use UserRelationTrait;
    public static $PENDING_STATUS  = 'pending';
    public static $COMPLETE_STATUS = 'completed';
    public static $INCOMPLETE_STATUS = 'incomplete';
    public static $EXPIRED_STATUS  = 'expired';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Scope a query to only include pendings
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePendings($query)
    {
        return $query->where('status', self::$PENDING_STATUS);
    }
    public function taskIsCompletedEvent()
    {
        $this->userHabitRoutine->rewards()->create([
            'user_id'      => $this->user_id,
            'rewarded_at'  => date('Y-m-d'),
            'total_reward' => 1,
            'type'         => Reward::$REWARD_COIN_TYPE,
        ]);
    }

    public function rewards()
    {
        return $this->morphMany(Reward::class, "rewardable");
    }
    public function userHabitRoutine()
    {
        return $this->belongsTo(UserHabitRoutine::class);
    }
}
