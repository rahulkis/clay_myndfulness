<?php

namespace App\Http\Requests;

use App\Models\Question;
use Illuminate\Foundation\Http\FormRequest;

class SelfAssessmentStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
/**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "*.question_id" => "required|exists:questions,id",
            "*.answers"     => "required",
            "*.type"        => "required|in:" . implode(",", Question::$QUESTION_TYPES),
        ];
    }
    public function prepareData()
    {
        $return_array = [];
        foreach ($this->all() as $key => $object) {
            $currentObject = $object;
            // checking single answer type
            if (isset($currentObject['answers']["text"])) {
                $currentObject["answers"] = [[
                    "optionId" => $currentObject['answers']["optionId"] ?? null,
                    "text"     => $currentObject['answers']["text"],
                ]];
            }
            $return_array[] = $currentObject;
        }
        return $return_array;
    }
    public function filterOptionIds(array $optionsArray): array
    {
        return collect($optionsArray)
        ->filter(function($data){
            return isset($data["optionId"]) && !is_null($data["optionId"]);
        })
        ->pluck("optionId")
        ->toArray();
    }
}
