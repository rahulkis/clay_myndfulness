<?php

namespace App\Http\Livewire\Users;

use App\Models\SelfAssessmentResponse;
use Livewire\Component;

class SelfAssessmentResponsesList extends Component
{
    public $single_user = false;
    public $show_filter = true;
    public $perPage = 10;
    public $search;
    public $user_id;
    protected $paginationTheme = 'bootstrap';
    public function viewMore()
    {
        $this->perPage += $this->perPage;
    }
    public function render()
    {
        return view('livewire.users.self-assessment-responses-list', [
            "records" => $this->getRecords(),
        ]);
    }
    private function getRecords()
    {
        return SelfAssessmentResponse::query()
            ->search($this->search)
            ->with("user:id,name,email")
            ->userFilter($this->user_id)
            ->latest()
            ->paginate($this->perPage);
    }
}
