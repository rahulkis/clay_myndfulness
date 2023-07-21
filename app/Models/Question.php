<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    public static $QUESTION_TYPES = [
        'Text Answer',
        'Single Answer Choice',
        'Multiple Answer Choice',
        'Rating Answer',
    ];
    protected $guarded = ["id"];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', "updated_at"];

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }
}
