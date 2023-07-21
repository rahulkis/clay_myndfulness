<?php

namespace App\Http\Livewire\QuestionGroup;

use App\Models\GroupQuestion;
use App\Models\GroupQuestionOption;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\QuestionGroup;
use DB;

class QuestionGroupsList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    protected $listeners = ['updated','confirmDelete',];

    public function confirmDelete($group_id){
        DB::beginTransaction();
        try {
            $group = QuestionGroup::find($group_id);
            $group_questions = GroupQuestion::where('question_group_id',$group_id)->get();
            foreach($group_questions as $gq){
                $gq->delete();
            }
            $group_name = $group->name;
            $group->delete();
        } catch (\Throwable $th) {
            DB::rollback();
            $this->emit('swalalert',['title' => '','subtitle' => 'Something went wrong.','type' => 'error']);
        }
        DB::commit();
        $this->emit('swalalert',['title' => '','subtitle' => "Deleted Habit {$group_name}.",'type' => 'success']);
    }
    public function updated()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = QuestionGroup::query();
        $query->where('name', 'like', '%' . $this->search . '%');
        $query->orWhere('category', 'like', '%' . $this->search . '%');

        return view('livewire.question-group.question-groups-list',[
            'groups' => $query->paginate(10)
        ]);
    }
}
