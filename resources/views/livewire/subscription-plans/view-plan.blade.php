<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-gradient-primary text-white">
            <h5 class="modal-title" id="view-subscription-modal">Subscription plan details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body table-responsive">
            @if ($subscription_plan)
                <table class="table table-bordered">
                    <tr>
                        <th>Name</th>
                        <td>: {{$subscription_plan->name}} <span class="badge badge-primary">{{$subscription_plan->getTypeString()}}</span></td>
                        <th>Description</th>
                        <td>: {{$subscription_plan->description}}</td>
                    </tr>
                    <tr>
                        <th>Apple Product ID</th>
                        <td>: {{$subscription_plan->product_uid}}</td>
                        <th>Google Product ID</th>
                        <td>: {{$subscription_plan->product_uid_google}}</td>
                    </tr>
                    <tr>
                        <th>Plan price</th>
                        <td>: {{$subscription_plan->price}}</td>
                        <th>Duration</th>
                        <td>: {{$subscription_plan->duration}} days</td>
                    </tr>
                    <tr>
                        <th>Habit limitation</th>
                        <td>: {{$subscription_plan->isLimitedString("is_habit_limited")}}</td>
                        <th>Habit limit</th>
                        <td>: {{$subscription_plan->habit_limit ?? "NA"}}</td>
                    </tr>
                    <tr>
                        <th>Self assessment limitation</th>
                        <td>: {{$subscription_plan->isLimitedString("is_self_assessment_limited")}}</td>
                        <th>Self assessment limit</th>
                        <td>: {{$subscription_plan->self_assessment_limit}}</td>
                    </tr>
                    <tr>
                        <th>Daily journal limitation</th>
                        <td>: {{$subscription_plan->isLimitedString("is_daily_journal_limited")}}</td>
                        <th>Daily journal limit</th>
                        <td>: {{$subscription_plan->daily_journal_limit}}</td>
                    </tr>
                </table>
            @else
                <div class="loader text-center" wire:loading></div>
            @endif
        </div>
    </div>
</div>
