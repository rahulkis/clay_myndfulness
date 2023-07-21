<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyJournalReponse extends Model
{
    use HasFactory, SoftDeletes;
    const COIN_LIMIT_FOR_MEDAL = 63;
    const MIN_COIN_PER_RESPONSE = 2;
    const COIN_AFTER_450_CHARACTER = 1;
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

        static::deleted(function($model){
            $model->transactions()->delete();
        });
    }
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'json_response' => 'json',
        'response_date' => 'date',
    ];
    /**
     * Scope a query to only include user
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUserFilter($query, $user_id = null)
    {
        return $query->when($user_id, function ($query) use ($user_id) {
            return $query->where('user_id', $user_id);
        });
    }
    public function transactions()
    {
        return $this->hasMany(DailyJournalResponseTransactions::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function rewards()
    {
        return $this->morphMany(Reward::class, "rewardable");
    }
    /**
     * Scope a query to only include search
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search = null)
    {
        return $query->when($search, function ($query) use ($search) {
            return $query->whereHas("user", function ($user_query) use ($search) {
                return $user_query->where("name", "LIKE", "%{$search}%")
                    ->orWhere("email", "LIKE", "%{$search}%");
            });
        });
    }

}
