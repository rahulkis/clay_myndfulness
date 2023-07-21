<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupQuestion extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($group_question) {
            $group_question->group_question_options()->delete();
        });
    }
    public function group_question_options()
    {
        return $this->hasMany(GroupQuestionOption::class);
    }
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    public function prev_option()
    {
        return $this->belongsTo(GroupQuestionOption::class, 'group_question_option_id', 'id');
    }
    public function prev_question()
    {
        return $this->belongsTo(GroupQuestion::class, 'prev_group_question_id', 'id');
    }
    public function options()
    {
        return $this->group_question_options();
    }
}
