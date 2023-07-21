<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionPlanResource;
use App\Models\SubscriptionPlan;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::active()
            ->get();
        return response()
            ->json([
                "message" => $plans->count() . " plans found.",
                "data"    => SubscriptionPlanResource::collection($plans),
            ]);
    }
}
