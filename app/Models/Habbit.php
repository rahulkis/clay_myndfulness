<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Habbit extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ["id"];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['image_url'];
    /**
     * Get the image_url
     *
     * @param  string  $value
     * @return string
     */
    public function getImageUrlAttribute()
    {
        return url("storage/" . $this->image);
    }
    public function category()
    {
        return $this->belongsTo(HabitCategory::class, "habit_category_id");
    }
}
