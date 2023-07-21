<?php

namespace App\Http\Controllers;

use App\Models\Habbit;
use App\Models\Question;
use App\Models\QuestionOption;
use DB;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        return view('pages.questions.index');
    }
    public function add()
    {
        $habbits = Habbit::select('id', 'name')->get();
        return view('pages.questions.add', compact('habbits'));
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->merge([
                'options' => json_decode($request->options, true),
            ]);
            $validator = $request->validate([
                'question'       => 'required|string|max:10000',
                'explanation'    => 'nullable|string|max:10000',
                'type'           => 'required',
                'options'        => 'required_if:type,Single Answer Choice,Multiple Answer Choice',
                'options.*.text' => 'required_if:type,Single Answer Choice,Multiple Answer Choice|string|max:10000',
            ], [
                'question.required'  => 'Please enter the question',
                'explanation.max'    => 'Max length exceeded',
                'type.required'      => 'Please select question type',
                'options.required_if'   => 'Please add atleast one option',
                'options.*.text.max' => 'Max length exceeded',
                'options.*.text.required_if' => 'Please enter text',
            ]);
            $question = Question::create([
                'question'    => $request->question,
                'explanation' => $request->explanation,
                'type'        => $request->type,
            ]);

            foreach ($request->options as $option) {
                $habbits       = $option['related_habbits'];
                $habbits_array = [];
                foreach ($habbits as $habbit) {
                    array_push($habbits_array, $habbit['id']);
                }
                $habbit_string = implode(',', $habbits_array);
                QuestionOption::create([
                    'question_id'     => $question->id,
                    'text'            => $option['text'],
                    'related_habbits' => $habbit_string,
                ]);
            }

        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json(400);
        }
        DB::commit();
        return response()->json(200);
    }
    public function edit($question_id)
    {
        $question = Question::where('id',$question_id)->with(['options' => function($q){
            $q->orderBy('id','ASC');
        }])->first();
        $habbits = Habbit::select('id', 'name')->get();
        return view('pages.questions.edit', compact('habbits','question'));
    }
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->merge([
                'options' => json_decode($request->options, true),
            ]);
            $validator = $request->validate([
                'question'       => 'required|string|max:10000',
                'explanation'    => 'nullable|string|max:10000',
                'type'           => 'required',
                'options'        => 'required_if:type,Single Answer Choice,Multiple Answer Choice',
                'options.*.text' => 'required_if:type,Single Answer Choice,Multiple Answer Choice|string|max:10000',
            ], [
                'question.required'  => 'Please enter the question',
                'explanation.max'    => 'Max length exceeded',
                'type.required'      => 'Please select question type',
                'options.required_if'   => 'Please add atleast one option',
                'options.*.text.max' => 'Max length exceeded',
                'options.*.text.required_if' => 'Please enter text',
            ]);
            $question =  Question::find($request->id);
            $question->update([
                'question'    => $request->question,
                'explanation' => $request->explanation,
                'type'        => $request->type,
            ]);

            foreach ($request->options as $option) {
                $habbits       = $option['related_habbits'];
                $habbits_array = [];
                foreach ($habbits as $habbit) {
                    array_push($habbits_array, $habbit['id']);
                }
                $habbit_string = implode(',', $habbits_array);
                if($option['id']){
                    $question_option =  QuestionOption::find($option['id']);
                    $question_option->update([
                        'question_id'     => $question->id,
                        'text'            => $option['text'],
                        'related_habbits' => $habbit_string,
                    ]);
                }else{
                    QuestionOption::create([
                        'question_id'     => $question->id,
                        'text'            => $option['text'],
                        'related_habbits' => $habbit_string,
                    ]);
                }
            }

        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json(400);
        }
        DB::commit();
        return response()->json(200);
    }
}
