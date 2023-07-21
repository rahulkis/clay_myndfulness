<?php

namespace App\Http\Controllers;

use App\Models\GroupQuestion;
use App\Models\GroupQuestionOption;
use App\Models\Question;
use App\Models\QuestionCategory;
use App\Models\QuestionGroup;
use App\Models\QuestionOption;
use Illuminate\Http\Request;
use DB;

class GroupQuestionController extends Controller
{
    public function index($group_id){
        $questions = Question::select('id','question')->with(['options' => function($q){
            $q->select('id','question_id','text')->orderBy('id','ASC');
        }])->get();
        $question_categories = QuestionCategory::select('id','name')->orderBy('name','ASC')->get();
        $group = QuestionGroup::where('id',$group_id)->with(['group_questions' => function($q){
            $q->with(['question:id,question','group_question_options.option:id,text','group_question_options.next_question.question:id,question'])
                ->with(['prev_option.option:id,text'])
                ->with(['prev_question.question:id,question'])
                ->orderBy('prev_group_question_id','ASC');
        }])->firstOrFail();
        return view('pages.group-questions.add', compact('questions','question_categories','group'));
    }
    public function add()
    {
        $questions = Question::select('id','question')->with(['options' => function($q){
            $q->select('id','question_id','text')->orderBy('id','ASC');
        }])->get();
        $question_categories = QuestionCategory::select('id','name')->orderBy('name','ASC')->get();
        return view('pages.group-questions.add', compact('questions','question_categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'question_id' => 'required',
            'group_id' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $question = Question::where('id',$request->question_id)->with('options')->first();
            $is_exist = GroupQuestion::where('question_group_id',$request->group_id)->where('group_question_option_id',$request->group_question_option_id)->where('prev_group_question_id', $request->prev_group_question_id)->first();
            if($is_exist){
                return response()->json(['msg' => 'exist'],200);
            }
            $group_question =  GroupQuestion::create([
                'question_id' => $request->question_id,
                'question_group_id' => $request->group_id
            ]);
            if($request->group_question_option_id){
                $op = GroupQuestionOption::where('id',$request->group_question_option_id)->first();
                $op->update(['next_question_id' => $group_question->id]);
                $group_question->update([
                    'group_question_option_id' => $request->group_question_option_id,
                    'prev_group_question_id' => $request->prev_group_question_id
                ]);
            }
            foreach($question->options as $option_original){
                GroupQuestionOption::create([
                    'group_question_id' => $group_question->id,
                    'option_id' => $option_original->id
                ]);
            }
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json(400);
        }
        DB::commit();
        $group = QuestionGroup::where('id',$request->group_id)->with(['group_questions' => function($q){
            $q->with(['question:id,question','group_question_options.option:id,text','group_question_options.next_question.question:id,question'])
                ->with(['prev_option.option:id,text'])
                ->with(['prev_question.question:id,question'])
                ->orderBy('prev_group_question_id','ASC');
        }])->firstOrFail();
        return response()->json(['group' => $group],200);
    }
}
