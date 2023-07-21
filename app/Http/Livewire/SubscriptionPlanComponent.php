<?php

namespace App\Http\Livewire;

use App\Models\SubscriptionPlan;
use Livewire\Component;
use Livewire\WithPagination;

class SubscriptionPlanComponent extends Component
{
    use WithPagination;
    public $perPage           = 10;
    public $search;
    protected $paginationTheme = 'bootstrap';

    protected $listeners  = ["refresh", "delete"];

    public function render()
    {
        return view('livewire.subscription-plan-component', [
            "plans" => $this->getPlans(),
        ]);
    }
    private function getPlans()
    {
        return SubscriptionPlan::filter($this->search)->latest()->paginate($this->perPage);
    }
    public function refresh()
    {
        $this->resetPage();
        // $this->render();
    }
    public function delete(SubscriptionPlan $plan)
    {
        $plan->delete();
        $this->emit('swalalert', ['title' => '', 'subtitle' => 'Subscription plan deleted.', 'type' => 'success']);
    }
}
