<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;
    public static $ACTIVE_STATUS = "active";
    public static $INACTIVE_STATUS = "inactive";
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ["id"];

    public static $SERVICE_TYPE = [
        0 => "FREE",
        1 => "PAID",
        2 => "TRIAL",
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'decimal:2',
    ];
    /**
     * Scope a query to only include filter
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $search)
    {
        $query->where("name", "LIKE", "%{$search}%");
        $query->orWhere("description", "LIKE", "%{$search}%");
        return $query;
    }

    public function getTypeString(): String
    {
        return self::$SERVICE_TYPE[$this->is_paid];
    }
    public function getDurationString(): String
    {
        return $this->duration ?: "Free";
    }
    public function isLimitedString($column_name)
    {
        return $this->{$column_name} ? "Limited" : "Unlimited";
    }
    /**
     * Scope a query to only include active
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', static::$ACTIVE_STATUS);
    }

    /**
     * Scope a query to only include Inactive
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive($query)
    {
        return $query->where('status', static::$INACTIVE_STATUS);
    }

    /**
     * Scope a query to only include free plan
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFree($query)
    {
        return $query->where('id',1);
    }
}
