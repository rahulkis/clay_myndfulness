<?php

namespace App\Http\Controllers\Api\User;

use App\Helper\CommonHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\SocialAuthRequest;
use App\Http\Resources\UserResource;
use App\Models\SubscriptionPlan;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Socialite\Two\InvalidStateException;
use Log;
use Socialite;

class SocialAuthController extends Controller
{
    public function register(SocialAuthRequest $request)
    {
        // steps
        // check social type available or not
        // step 1 check user using social auth from token
        // check id, email for uniqueness
        // if found insert and return profile with token
        // else profile with token
        // checking social auth type
        $token    = $request->social_auth_token;
        $provider = $request->social_auth_type;
        try {
            $social_user = Socialite::driver($provider)
                ->userFromToken($token);
        } catch (InvalidStateException $e) {
            report($e);
            return response()->json([
                "message" => $e->getMessage(),
            ], 400);
        } catch (\Throwable $th) {
            report($th);
            return response()->json([
                "message" => "Invalid credentials.",
            ], 400);
        }
        if (!$social_user) {
            return response()->json([
                "message" => "Invalid credentials.",
            ], 400);
        }
        $db_user = User::query()
            ->where("social_id", $social_user->getId())
            ->where("social_auth_type", $request->social_auth_type)
            ->first();
        if ($db_user) {
            return response([
                'message'      => __('messages.login_successful'),
                'data'         => new UserResource($db_user),
                'access_token' => $db_user->createToken("Mobile", config("modules.FREE_USER_ABBILITIES"))->plainTextToken,
            ], Response::HTTP_OK);
        }

        $data = $request->prepareData();
        if (!$request->get("name")) {
            $data["name"] = $social_user->getName() ?? $social_user->getNickname();
        }
        DB::beginTransaction();
        try {
            $data["social_id"]= $social_user->getId();
            $data["avatar"] = $social_user->getAvatar();
            $data["email"]  = $social_user->getEmail();
            /**
             * @var \App\Model\User $user
             */
            $user = User::create($data);
            $user->save();
            // add free plan to users as default
            // dont throw exception if not found Plan.
            try {
                // of pass the user id as parameter in command
                $free_plan = SubscriptionPlan::free()->firstOrFail();
                $user->updateNewPlan($free_plan, now(), now()->addYear(5), now()->addYear(5)->addDays(3));
            } catch (\Throwable $th) {
                report($th);
            }

            $token = $user->createToken("Mobile", config("modules.FREE_USER_ABBILITIES"));

            $response = response()->json([
                "message"      => "Successfully registered.",
                "user"         => new UserResource($user),
                "access_token" => $token->plainTextToken,
            ], Response::HTTP_CREATED);

            DB::commit();
            return $response;
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();
            return CommonHelper::badRequestResponse(__("messages.user_registration_failed"));
        }
    }
    public function profileUpdate(ProfileUpdateRequest $request)
    {
        /**
         * @var \App\Models\User $user
         */
        $user = auth()->user();
        $data = $request->only(["name", "email", "time_zone"]);
        $user->update($data);
        return response()
            ->json([
                "message" => "Profile updated.",
            ], Response::HTTP_OK);
    }
    public function profile()
    {
        $user = auth()->user();
        return response()->json([
            "user" => new UserResource($user),
        ], Response::HTTP_OK);
    }
    public function handleGoogleCallback(Request $request)
    {
        logger($request->all());
        $user = Socialite::driver('google')->user();
        // logger($user);
        $finduser = User::where('social_id', $user->id)->first();
        dd($user);
    }
    public function redirectToGoogle()
    {

        return Socialite::driver('google')->redirect();

    }
    public function destroySelf()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = auth("sanctum")->user();
        DB::beginTransaction();
        try {
            // Please check boot method of the user model for more events
            $user->delete();
        } catch (\Throwable $th) {
            DB::rollback();
            return response()
                ->json([
                    "message" => "Whoops something went wrong.",
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return response()
            ->json([
                "message" => "Deleted successfully.",
            ], Response::HTTP_OK);
    }
}
