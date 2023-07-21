<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;
    public static $LEADERBOARD_LIMIT = 10;
    public static $REWARD_COIN_TYPE  = "coin";
    public static $REWARD_MEDAL_TYPE = "medal";
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

        static::created(function ($model) {
            [$cols, $reinitializeCol, $shouldReinitialize, $limit_count] = (new self)->getColumnName($model);
            $user                                                        = $model->user;
            if ($shouldReinitialize) {
                $new_updated_current_reward_count = ($user->{$reinitializeCol}+$model->total_reward) - $limit_count;
                $user->update([$reinitializeCol => $new_updated_current_reward_count]);
            }
            foreach ($cols as $col => $value) {
                $user->increment($col, $value);
            }
        });
    }
    public function rewardable()
    {
        return $this->morphTo()->withTrashed();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function isTypeCoin()
    {
        return $this->type == "coin";
    }
    public function isTypeMedal()
    {
        return $this->type == "medal";
    }
    public function getColumnName($model)
    {
        $column_names       = [];
        $reinitializeCol    = null;
        $shouldReinitialize = false;
        $coin_limit         = 1;
        if ($model->rewardable_type === DailyJournalReponse::class) {
            $coin_limit = DailyJournalReponse::COIN_LIMIT_FOR_MEDAL;
            if ($model->isTypeCoin()) {
                $column_names = [
                    'daily_journal_coins'         => $model->total_reward,
                    'total_coins'                 => $model->total_reward,
                    'daily_journal_coins_current' => $model->total_reward,
                ];
            } else {
                $column_names = [
                    'daily_journal_medals' => 1,
                    'total_medals'         => 1,
                    'daily_journal_coins'  => $model->total_reward,
                    'total_coins'          => $model->total_reward,
                ];
                $reinitializeCol    = "daily_journal_coins_current";
                $shouldReinitialize = true;
            }
        } else if ($model->rewardable_type === SelfAssessmentResponse::class) {
            $coin_limit = SelfAssessmentResponse::COIN_LIMIT_FOR_MEDAL;
            if ($model->isTypeCoin()) {
                $column_names = [
                    'self_assessment_coins'         => $model->total_reward,
                    'self_assessment_coins_current' => $model->total_reward,
                    'total_coins'                   => $model->total_reward,
                ];
            } else {
                $column_names = [
                    'self_assessment_coins'  => $model->total_reward,
                    'total_coins'            => $model->total_reward,
                    'self_assessment_medals' => 1,
                    'total_medals'           => 1,
                ];
                $reinitializeCol    = "self_assessment_coins_current";
                $shouldReinitialize = true;
            }
        } else if ($model->rewardable_type === UserHabitRoutine::class) {
            $coin_limit = UserHabitRoutine::COIN_LIMIT_FOR_MEDAL;
            if ($model->isTypeCoin()) {
                $column_names = [
                    'habit_coins'         => $model->total_reward,
                    'habit_coins_current' => $model->total_reward,
                    'total_coins'         => $model->total_reward,
                ];
            } else {
                $column_names = [
                    'habit_coins'  => $model->total_reward,
                    'total_coins'  => $model->total_reward,
                    'habit_medals' => 1,
                    'total_medals' => 1,
                ];
                $reinitializeCol    = "habit_coins_current";
                $shouldReinitialize = true;
            }
        } else {
            throw new \Exception("Rewardable type {$model->rewardable_type} not found.");
        }
        return [$column_names, $reinitializeCol, $shouldReinitialize, $coin_limit];
    }
    /**
     * Scope a query to only include userFilter
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUserFilter($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }
}
