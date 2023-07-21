<?php

namespace App\Http\Middleware;

use App\Exceptions\PlanLimitCrossedException;
use App\Exceptions\SubscriptionPlanExpiredException;
use Closure;
use Illuminate\Http\Request;

class CheckSubscriptionPlan
{
    private $available_types = [null, "habit", "daily_journal", "self_assessment"];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  String  $type null|habit|daily_journal|self_assessment
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $type = null)
    {
        $this->checkType($type);
        $user = $request->user();
        /***
         * @var \App\Models\UserSubscription $active_plan
         */
        $user->load("activePlan");
        $active_plan = $user->activePlan;
        abort_if(!$active_plan, 501, "No Active plan found.");
        if($active_plan->isPlanExpired()){
            throw new SubscriptionPlanExpiredException;
        }
        if($type && $type == "habit"){
            if($active_plan->isHabitLimitCrossed()){
                throw new PlanLimitCrossedException("Your habit limit of {$active_plan->habit_limit} is exceeded.");
            }
        }
        if($type && $type == "self_assessment"){
            if($active_plan->isSelfAssesmentLimitCrossed()){
                throw new PlanLimitCrossedException("Your self assessment limit of {$active_plan->self_assessment_limit} is exceeded.");
            }
        }
        if($type && $type == "daily_journal"){
            if($active_plan->isDailyJournalLimitCrossed()){
                throw new PlanLimitCrossedException("Your daily journal limit of {$active_plan->daily_journal_limit} is exceeded.");
            }
        }
        return $next($request);
    }
    public function checkType($type)
    {
        abort_if(!in_array($type, $this->available_types), 501, "invalid {$type} type checking.");
    }
}
