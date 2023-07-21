<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnboardingResponse extends Model
{
    use HasFactory;
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'options'    => 'json',
        'option_ids' => 'json',
    ];
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ["id"];

    public function createUserHabit(): void
    {
        $habit_ids          = [];
        $all_related_habits = QuestionOption::whereIn('id', $this->option_ids)
            ->get();
        foreach ($all_related_habits as $option) {
            $habit_ids = array_merge($habit_ids, explode(",", $option->related_habbits));
        }
        $habit_ids  = array_unique($habit_ids);
        $all_habits = Habbit::find($habit_ids);
        foreach ($all_habits as $habit) {
            UserHabitRoutine::firstOrCreate([
                "user_id"  => $this->user_id,
                "habit_id" => $habit->id,
            ], [
                "habit"             => $habit->name,
                "habit_description" => $habit->description,
                "routine_time"      => "07:00:00",
                "routine_type"      => config("modules.routine_types")[0]
            ]);
        }
    }
}
