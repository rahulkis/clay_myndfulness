<?php

namespace App\Http\Livewire\Category;

use App\Models\HabitCategory;
use App\Traits\WithSortable;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryList extends Component
{
    use WithPagination;
    use WithSortable;
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $perPage      = 25;
    protected $listeners = ["refresh", "delete"];
    public $category;
    public $name;
    
    public function render()
    {
        return view('livewire.category.category-list', [
            "records" => HabitCategory::search($this->search)
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate($this->perPage),
        ]);
    }

    public function refresh()
    {
        $this->resetPage();
    }
    public function delete(HabitCategory $category)
    {
        $category->delete();
        $this->emit('swalalert', ['title' => '', 'subtitle' => 'Category deleted.', 'type' => 'success']);
    }
    public function edit(HabitCategory $category)
    {
        $this->fill([
            "category" => $category,
            "name"     => $category->name,
        ]);
        $this->dispatchBrowserEvent("editModal");
    }
    public function update()
    {
        $data = $this->validate([
            "name" => "required|min:1|max:255",
        ]);
        $this->category->update($data);
        $this->reset("name", "category");
        $this->emit('swalalert', ['title' => '', 'subtitle' => 'Category updated.', 'type' => 'success']);
        $this->dispatchBrowserEvent("closeModal");
    }
}
