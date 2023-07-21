<?php

namespace App\Http\Livewire\Category;

use App\Models\HabitCategory;
use Livewire\Component;

class CreateCategory extends Component
{
    public $name;

    public function render()
    {
        return view('livewire.category.create-category');
    }
    public function store()
    {
        $data = $this->validate([
            "name"  => "required|min:3|max:255",
        ]);
        HabitCategory::create($data);
        $this->dispatchBrowserEvent("closeModal");
        $this->emitTo("category.category-list", "refresh");
        $this->emit('swalalert', ['title' => '', 'subtitle' => 'Category created.', 'type' => 'success']);
        $this->reset();

    }
}
