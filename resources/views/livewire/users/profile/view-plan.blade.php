<div>
    <div class="py-4">
        <p class="clearfix">
            <span class="float-left"> Plan </span>
            <span class="float-right text-muted">
                {{ $plan->name}}
            </span>
        </p>
        <p class="clearfix">
            <span class="float-left"> About the Plan </span>
            <span class="float-right text-muted">
                {{ $plan->description}}
            </span>
        </p>
        <p class="clearfix">
            <span class="float-left"> Price </span>
            <span class="float-right text-muted">
                <span class="text-success">{{ $plan->price}}</span>
            </span>
        </p>
        <p class="clearfix">
            <span class="float-left"> Validity </span>
            <span class="float-right text-muted">
                <span class="text-success">{{ $plan->duration}} days</span>
            </span>
        </p>
        <p class="clearfix">
            <span class="float-left"> Subscription Date </span>
            <span class="float-right text-muted">
                {{ niceDate($plan->start_date)}}
            </span>
        </p>
        <p class="clearfix">
            <span class="float-left"> Expiry Date </span>
            <span class="float-right text-muted">
                {{ niceDate($plan->end_date)}}
            </span>
        </p>
        <p class="clearfix">
            <span class="float-left"> Habit Limit </span>
            <span class="float-right text-muted">
                @if($plan->is_habit_limited)
                {{$plan->habit_limit}}
                @else
                <span class="text-success">Unlimited</span>
                @endif
            </span>
        </p>
        <p class="clearfix">
            <span class="float-left"> Self Assessment Limit </span>
            <span class="float-right text-muted">
                @if($plan->is_self_assessment_limited)
                {{$plan->self_assessment_limit}}
                @else
                <span class="text-success">Unlimited</span>
                @endif
            </span>
        </p>
        <p class="clearfix">
            <span class="float-left"> Daily Journal Limit </span>
            <span class="float-right text-muted">
                @if($plan->is_daily_journal_limited)
                {{$plan->daily_journal_limit}}
                @else
                <span class="text-success">Unlimited</span>
                @endif
            </span>
        </p>
    </div>
</div>
