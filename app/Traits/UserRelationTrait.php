<?php

namespace App\Traits;

use App\Models\User;

trait UserRelationTrait
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Scope a query to filter user
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUserFilter($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }
}
