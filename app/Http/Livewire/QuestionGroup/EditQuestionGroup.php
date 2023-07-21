<?php

namespace App\Http\Livewire\QuestionGroup;

use App\Models\QuestionCategory;
use App\Models\QuestionGroup;
use Livewire\Component;

class EditQuestionGroup extends Component
{
    public $category;
    public $name;
    public $order;
    public $group;
    public $old_name;

    protected $listeners = ['setGroup'];
    public function setGroup(QuestionGroup $group)
    {
        $this->group    = $group;
        $this->old_name = $group->name;
        $this->order    = $group->order;
        $this->category = $group->question_category_id;
        $this->name     = $group->name;
    }
    public function store()
    {
        $this->validate([
            'name'     => 'required|max:255',
            'order'    => 'required|numeric',
            'category' => 'required',
        ]);
        try {
            $category = QuestionCategory::find($this->category);
            $this->group->update([
                'name'                 => $this->name,
                'order'                => $this->order,
                'question_category_id' => $this->category,
                'category'             => $category->name,
            ]);
            $this->emitTo('question-group.question-groups-list', 'updated');
            $this->emit('closeModal');
            $this->emit('swalalert', ['title' => '', 'subtitle' => "Updated Group {$this->old_name}.", 'type' => 'success']);
        } catch (\Throwable $th) {
            $this->emit('swalalert', ['title' => '', 'subtitle' => 'Something went wrong.', 'type' => 'error']);
        }

    }
    public function render()
    {
        $categories = QuestionCategory::select('id', 'name')->get();
        return view('livewire.question-group.edit-question-group', [
            'categories' => $categories,
        ]);
    }
}
