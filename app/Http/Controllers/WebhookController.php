<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Webhook;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function appleWebhook(Request $request)
    {
        try {
            Webhook::create([
                "payload" => $request->all(),
                "provider"  => User::$APPLE_TYPE,
            ]);
        } catch (\Throwable $th) {
            report($th);
            return response()
                ->json([
                    "message" => "Failed.",
                ], 500);
        }
        return response()
            ->json([
                "message" => "received.",
            ]);
    }
    public function googleWebhook(Request $request)
    {
        try {
            Webhook::create([
                "payload" => $request->all(),
                "provider"  => User::$GOOGLE_TYPE,
            ]);
        } catch (\Throwable $th) {
            report($th);
            return response()
                ->json([
                    "message" => "Failed.",
                ], 500);
        }
        return response()
            ->json([
                "message" => "received.",
            ]);
    }
}
