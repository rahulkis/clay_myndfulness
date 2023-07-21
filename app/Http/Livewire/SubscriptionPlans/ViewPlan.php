<?php

namespace App\Http\Livewire\SubscriptionPlans;

use App\Models\SubscriptionPlan;
use Livewire\Component;

class ViewPlan extends Component
{
    public $subscription_plan;
    protected $listeners  = ["setPlan"];
    public function render()
    {
        return view('livewire.subscription-plans.view-plan');
    }
    public function setPlan(SubscriptionPlan $subscription_plans)
    {
        $this->subscription_plan = $subscription_plans;
    }
}
