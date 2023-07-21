<?php

namespace App\Http\Livewire\Onboarding;

use App\Models\OnboardingResponse;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class OnboardingResponsesList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $perPage = 25;
    public function render()
    {

        return view('livewire.onboarding.onboarding-responses-list', [
            "users" => $this->getUsers(),
        ]);
    }
    private function getUsers()
    {
        return User::addSelect([
            "response_created_at" => OnboardingResponse::select("updated_at")
                ->whereColumn("user_id", "users.id")
                ->orderByDesc("updated_at")
                ->limit(1),
        ])
        ->whereHas("onboarding_responses")
        ->orderByDesc("response_created_at")
        ->paginate($this->perPage);
    }
}
