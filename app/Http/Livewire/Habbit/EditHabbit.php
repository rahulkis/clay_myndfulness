<?php

namespace App\Http\Livewire\Habbit;

use App\Models\Habbit;
use App\Models\HabitCategory;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditHabbit extends Component
{
    use WithFileUploads;
    public $name;
    public $image;
    public $description;
    public $habit_category_id;
    public $habbit;
    public $old_name;
    public $categories = [];
    public $url;

    protected $listeners = ['setHabbit'];

    public function mount()
    {
        $this->categories = HabitCategory::pluck("name", "id")->toArray();
    }
    public function setHabbit(Habbit $habbit)
    {
        $this->habbit = $habbit;
        $this->old_name = $habbit->name;
        $this->url = $habbit->image;
        $this->habit_category_id = $habbit->habit_category_id;
        $this->description = $habbit->description;
        $this->name = $habbit->name;
    }
    public function store()
    {
        $this->validate([
            'name' => 'required|max:255',
            'image' => 'nullable|max:512|mimes:png,jpg,jpeg,svg',
            'description' => 'nullable|max:10000',
            'habit_category_id' => 'required|exists:habit_categories,id',
        ], [], [
            "habit_category_id" => "category"
        ]);
        try {
            $image_url = $this->habbit->image;
            if($this->image){
                $image_url = $this->image->store('habbits');
            }
            $this->habbit->update([
                'name' => $this->name,
                'image' => $image_url,
                'description' => $this->description,
                'habit_category_id' => $this->habit_category_id
            ]);
            $this->emitTo('habbit.habbits-list','added');
            $this->emit('closeModal');
            $this->emit('swalalert',['title' => '','subtitle' => "Updated Habit {$this->old_name}.",'type' => 'success']);
        } catch (\Throwable $th) {
            $this->emit('swalalert',['title' => '','subtitle' => 'Something went wrong.','type' => 'error']);
        }
    }
    public function render()
    {
        return view('livewire.habbit.edit-habbit');
    }
}
