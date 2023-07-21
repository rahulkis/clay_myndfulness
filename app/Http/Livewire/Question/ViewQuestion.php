<?php

namespace App\Http\Livewire\Question;

use Livewire\Component;
use App\Models\Question;

class ViewQuestion extends Component
{
    public $question;
    protected $listeners = ['setQuestion'];
    public function setQuestion($question_id){
        $this->question = Question::where('id',$question_id)->with(['options' => function($q){
            $q->orderBy('id','ASC');
        }])->first();
    }
    public function render()
    {
        return view('livewire.question.view-question');
    }
}
