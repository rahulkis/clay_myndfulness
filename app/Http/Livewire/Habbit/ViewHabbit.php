<?php

namespace App\Http\Livewire\Habbit;

use App\Models\Habbit;
use Livewire\Component;

class ViewHabbit extends Component
{
    public $habbit;
    protected $listeners = ['setHabbit'];
    public function setHabbit(Habbit $habbit){
        $this->habbit = $habbit;
    }
    public function render()
    {
        return view('livewire.habbit.view-habbit');
    }
}
