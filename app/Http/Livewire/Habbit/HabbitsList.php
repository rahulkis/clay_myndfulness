<?php

namespace App\Http\Livewire\Habbit;

use Livewire\Component;
use App\Models\Habbit;
use Livewire\WithPagination;

class HabbitsList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    protected $listeners = ['confirmDelete','added'];

    public function added()
    {

    }
    public function confirmDelete($habbit_id){
        try {
            $habbit = Habbit::find($habbit_id);
            $habbit_name = $habbit->name;
            $habbit->delete();
            $this->emit('swalalert',['title' => '','subtitle' => "Deleted Habit {$habbit_name}.",'type' => 'success']);
        } catch (\Throwable $th) {
            $this->emit('swalalert',['title' => '','subtitle' => 'Something went wrong.','type' => 'error']);
        }
    }
    public function render()
    {
        $query = Habbit::query();
        $query->where('name', 'like', '%' . $this->search . '%');
        return view('livewire.habbit.habbits-list',[
            'habbits' => $query->paginate(10)
        ]);
    }
}
