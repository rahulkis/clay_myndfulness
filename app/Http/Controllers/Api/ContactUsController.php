<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactUsStoreRequest;
use App\Models\ContactUs;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class ContactUsController extends Controller
{

    public function store(ContactUsStoreRequest $request)
    {
        /**
         * @var \App\Models\User $user
         */
        $user   = $request->user();
        DB::beginTransaction();
        try {
            $contact_us = ContactUs::create([
                "user_id"   => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "text" => $request->text
            ]);
        } catch (\Throwable$th) {
            report($th);
            DB::rollback();
            return response()
                ->json([
                    "message"   => "Whoops! something went wrong."
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return response()
            ->json([
                "message"   => "Contact us is submitted successfully.",
            ], Response::HTTP_OK);
    }
}
