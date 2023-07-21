<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupQuestionOption extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', "updated_at"];
    public function option()
    {
        return $this->belongsTo(QuestionOption::class);
    }
    public function next_question()
    {
        return $this->belongsTo(GroupQuestion::class, 'next_question_id', 'id');
    }
}
