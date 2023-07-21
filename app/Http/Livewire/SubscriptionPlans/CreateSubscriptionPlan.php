<?php

namespace App\Http\Livewire\SubscriptionPlans;

use App\Models\SubscriptionPlan;
use Livewire\Component;

class CreateSubscriptionPlan extends Component
{
    public $name;
    public $product_uid;
    public $product_uid_google;
    public $description;
    public $is_paid;
    public $price            = 0;
    public $duration         = 0;
    public $is_habit_limited = "";
    public $habit_limit;
    public $is_self_assessment_limited = "";
    public $self_assessment_limit;
    public $is_daily_journal_limited = "";
    public $daily_journal_limit;
    public $limitTypes = [
        0 => "Unlimited",
        1 => "Limited",
    ];

    public function render()
    {
        return view('livewire.subscription-plans.create-subscription-plan');
    }

    public function store()
    {
        $validatedData = $this->validate([
            "name"                       => "required|max:255|min:3",
            "product_uid"           => "nullable|max:255|unique:subscription_plans",
            "product_uid_google"          => "nullable|max:255|unique:subscription_plans",
            "description"                => "required|max:500|min:3",
            "is_paid"                    => "required|in:" . implode(",", array_keys(SubscriptionPlan::$SERVICE_TYPE)),
            "price"                      => "required_if:is_paid,1",
            "duration"                   => "required_if:is_paid,1|nullable|numeric|min:0",
            "is_habit_limited"           => "required|boolean",
            "habit_limit"                => "required_if:is_habit_limited,1",
            "is_self_assessment_limited" => "required|boolean",
            "self_assessment_limit"      => "required_if:is_self_assessment_limited,1",
            "is_daily_journal_limited"   => "required|boolean",
            "daily_journal_limit"        => "required_if:is_daily_journal_limited,1",
        ]);
        $validatedData["price"]    = $validatedData["price"] ?? 0;
        $validatedData["duration"] = $validatedData["duration"] ?? 0;
        SubscriptionPlan::create($validatedData);
        $this->dispatchBrowserEvent("closeModal");
        $this->emitTo("subscription-plan-component", "refresh");
        $this->emit('swalalert', ['title' => '', 'subtitle' => 'Subscription added.', 'type' => 'success']);
        $this->reset();
    }
    public function updatedIsHabitLimited($value)
    {
        $this->habit_limit = !$value ? 0 : $this->habit_limit;
    }
    public function updatedIsSelfAssessmentLimited($value)
    {
        $this->self_assessment_limit = !$value ? 0 : $this->self_assessment_limit;
    }
    public function updatedIsDailyJournalLimited($value)
    {
        $this->daily_journal_limit = !$value ? 0 : $this->daily_journal_limit;
    }
    // Computed Property
    public function getServicesProperty()
    {
        return SubscriptionPlan::$SERVICE_TYPE;
    }
}
