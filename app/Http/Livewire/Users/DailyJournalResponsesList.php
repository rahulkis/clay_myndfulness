<?php

namespace App\Http\Livewire\Users;

use App\Models\DailyJournalReponse;
use Livewire\Component;
use Livewire\WithPagination;

class DailyJournalResponsesList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $single_user = false;
    public $show_filter = true;
    public $perPage = 20;
    public $search;
    public $user_id;
    public function viewMore()
    {
        $this->perPage += $this->perPage;
    }
    public function render()
    {
        return view('livewire.users.daily-journal-responses-list', [
            "records" => $this->getRecords(),
        ]);
    }
    private function getRecords()
    {
        return DailyJournalReponse::query()
            ->search($this->search)
            ->with("user:id,name,email")
            ->userFilter($this->user_id)
            ->latest()
            ->paginate($this->perPage);
    }
}
