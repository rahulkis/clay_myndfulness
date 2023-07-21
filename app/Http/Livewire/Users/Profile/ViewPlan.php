<?php

namespace App\Http\Livewire\Users\Profile;

use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use Livewire\Component;

class ViewPlan extends Component
{
    public $user_id;
    public $plan;

    public function mount()
    {
        $this->plan = UserSubscription::where('user_id',$this->user_id)->where('is_active',1)->first();
    }
    public function render()
    {
        return view('livewire.users.profile.view-plan');
    }
}
