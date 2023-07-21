<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionCategory extends Model
{
    use HasFactory;
    protected $guarded                = ["id"];
    public static $ONBOARDING_ID      = 1;
    public static $DAILY_JOURNAL_ID   = 2;
    public static $SELF_ASSESEMENT_ID = 3;
}
