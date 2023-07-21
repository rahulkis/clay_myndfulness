<?php

namespace App\Http\Livewire\QuestionGroup;

use App\Models\QuestionCategory;
use App\Models\QuestionGroup;
use Livewire\Component;

class CreateQuestionGroup extends Component
{
    public $category;
    public $name;
    public $order;
    public function store()
    {
        $this->validate([
            'name'     => 'required|max:255',
            'order'    => 'required|numeric',
            'category' => 'required',
        ]);
        try {
            $category = QuestionCategory::find($this->category);
            $group    = QuestionGroup::create([
                'name'                 => $this->name,
                'order'                => $this->order,
                'question_category_id' => $this->category,
                'category'             => $category->name,
            ]);
            return redirect()->route('group-questions.index', ['group_id' => $group->id]);
            $this->emit('swalalert', ['title' => '', 'subtitle' => 'Added New Habit.', 'type' => 'success']);
        } catch (\Throwable $th) {
            $this->emit('swalalert', ['title' => '', 'subtitle' => 'Something went wrong.', 'type' => 'error']);
        }

    }
    public function render()
    {
        $categories = QuestionCategory::select('id', 'name')->get();
        return view('livewire.question-group.create-question-group', [
            'categories' => $categories,
        ]);
    }
}
