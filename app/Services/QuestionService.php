<?php
namespace App\Services;

use App\Models\QuestionGroup;
use Illuminate\Database\Eloquent\Builder;

class QuestionService
{
    public static function onBoardingQuestion()
    {
        $query = QuestionGroup::query()
            ->onboarding();
        return (new self)->getQuestions($query);
    }
    public static function dailyJournalQuestions()
    {
        $query = QuestionGroup::query()
            ->dailyJournal();
        return (new self)->getQuestions($query);
    }
    public static function selfAssessmentQuestions()
    {
        $query = QuestionGroup::query()
            ->selfAssessment();
        return (new self)->getQuestions($query);
    }
    private function getQuestions(Builder $builder): array
    {
        $returnArray = [];
        $groups      = $builder
            ->with("group_questions.question", "group_questions.options.option:id,question_id,text")
            ->orderBy("order")
            ->get();
        // return $groups;
        $pages = [];
        foreach ($groups as $group) {
            $questions = [];
            foreach ($group->group_questions as $question_group) {
                $question                                    = $question_group->question->toArray();
                $question_group->question->group_question_id = $question_group->id;
                $question_group->question->options           = $question_group->options;
                $question["group_question_id"]               = $question_group->id;
                $question["options"]                         = $question_group->options;
                $questions[$question_group->id]              = $question;
            }
            $pages[] = [
                "page"              => $group->order,
                "first_question_id" => collect($questions)->first()["group_question_id"],
                "question"          => $questions,
            ];
        }
        $returnArray["total_page"] = sizeof($pages);
        $returnArray["pages"]      = $pages;
        return $returnArray;
    }
}
