<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InAppPaymentTransaction extends Model
{
    use HasFactory;
    const GOOGLE_TYPE = 'google';
    const APPLE_TYPE = 'apple';
    protected $guarded = ['id'];

    /**
     * Get the amount field
     *
     * @param  string  $value
     * @return string
     */
    public function getAmountAttribute($value)
    {

    }
}
