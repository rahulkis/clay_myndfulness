<?php

namespace App\Http\Livewire\Question;

use Livewire\Component;
use App\Models\Question;
use App\Models\QuestionOption;
use Livewire\WithPagination;

class QuestionsList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    protected $listeners = ['confirmDelete'];

    public function confirmDelete($question_id){
        try {
            $question = Question::find($question_id);
            $options = QuestionOption::where('id',$question_id)->delete();
            $question->delete();
            $this->emit('swalalert',['title' => '','subtitle' => "Deleted a question.",'type' => 'success']);
        } catch (\Throwable $th) {
            $this->emit('swalalert',['title' => '','subtitle' => 'Something went wrong.','type' => 'error']);
        }
    }
    public function render()
    {
        $query = Question::query();
        $query->where('question', 'like', '%' . $this->search . '%');

        return view('livewire.question.questions-list',[
            'questions' => $query->paginate(10)
        ]);
    }
}
