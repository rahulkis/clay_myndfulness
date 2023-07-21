<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search  = "";
    public $perPage = 10;
    public function render()
    {
        return view('livewire.users.user-list', [
            "users" => User::search($this->search)->paginate($this->perPage),
        ]);
    }
}
