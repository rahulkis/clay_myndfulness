<?php

namespace App\Http\Livewire\Habbit;

use App\Models\Habbit;
use App\Models\HabitCategory;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateNewHabbit extends Component
{
    use WithFileUploads;
    public $name;
    public $image;
    public $description;
    public $category_id;
    public $categories = [];

    public function mount()
    {
        $this->categories = HabitCategory::pluck("name", "id")->toArray();
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|max:255',
            'image' => 'required|max:512|mimes:png,jpg,jpeg,svg',
            'category_id' => 'required|exists:habit_categories,id',
            'description' => 'nullable|max:10000'
        ], [], [
          "category_id"     => "category"
        ]);
        try {
            if($this->image){
                $image_url = $this->image->store('habbits');
            }
            Habbit::create([
                'name' => $this->name,
                'image' => $image_url,
                'habit_category_id' => $this->category_id,
                'description' => $this->description
            ]);
            $this->emitTo('habbit.habbits-list','added');
            $this->emit('showTable');
            $this->emit('swalalert',['title' => '','subtitle' => 'Added New Habbit.','type' => 'success']);
        } catch (\Throwable $th) {
            $this->emit('swalalert',['title' => '','subtitle' => 'Something went wrong.','type' => 'error']);
        }
    }
    public function render()
    {
        return view('livewire.habbit.create-new-habbit');
    }
}
