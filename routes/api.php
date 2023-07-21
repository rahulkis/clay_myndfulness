<?php

use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\Api\HabitController;
use App\Http\Controllers\Api\PaymentHandler;
use App\Http\Controllers\Api\RewardController;
use App\Http\Controllers\Api\RoutineController;
use App\Http\Controllers\Api\SelftAssessmentController;
use App\Http\Controllers\Api\SubscriptionPlanController;
use App\Http\Controllers\Api\User\BootApiController;
use App\Http\Controllers\Api\User\DailyJournalController;
use App\Http\Controllers\Api\User\QuestionController;
use App\Http\Controllers\Api\User\SocialAuthController;
use App\Http\Controllers\Api\UserHabitTaskController;
use Illuminate\Support\Facades\Route;

Route::get('boot', [BootApiController::class, "boot"]);
Route::post('register', [SocialAuthController::class, "register"]);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('on-boarding-question', [QuestionController::class, "onBoardingQuestions"]);
    Route::post('on-boarding-question', [QuestionController::class, "onBoardingQuestionResponse"]);
    Route::prefix('habits')->group(function () {
        Route::get("/", [HabitController::class, "index"]);
        Route::get("/categories", [HabitController::class, "categories"]);
    });
    Route::prefix('profile')->group(function () {
        Route::put("/", [SocialAuthController::class, "profileUpdate"]);
        Route::delete("/delete", [SocialAuthController::class, "destroySelf"]);
        Route::get("/", [SocialAuthController::class, "profile"]);
    });
    Route::prefix('daily-journal')->group(function () {
        Route::get("/questions", [DailyJournalController::class, "questions"]);
        Route::get("/", [DailyJournalController::class, "index"]);
        Route::post("/", [DailyJournalController::class, "store"])
            ->middleware("plan_check:daily_journal");
        Route::post("/", [DailyJournalController::class, "store"]);
        Route::delete("/{response}", [DailyJournalController::class, "destroy"]);
    });
    Route::prefix('contact-us')->group(function () {
        Route::post("/", [ContactUsController::class, "store"]);
    });
    Route::prefix('self-assessment')->group(function () {
        Route::get("/questions", [SelftAssessmentController::class, "questions"]);
        Route::get("/", [SelftAssessmentController::class, "index"]);
        Route::post("/", [SelftAssessmentController::class, "store"])
            ->middleware("plan_check:self_assessment");
    });
    Route::prefix("routines")->group(function(){
        Route::get("/", [RoutineController::class, "index"]);
        Route::put("/{routine}", [RoutineController::class, "changeStatus"]);
        Route::put("/change/{routine}", [RoutineController::class, "changeStatus"])
            ->middleware("plan_check");
        Route::get("/todays", [RoutineController::class, "todaysRoutine"]);
        Route::post("/create", [RoutineController::class, "store"])
            ->middleware("plan_check:habit");
        Route::delete("/delete/{user_habit}", [RoutineController::class, "destroy"]);
        Route::put("/edit/{routine}", [RoutineController::class, "update"]);
        Route::put("/completed/{routine_transaction}", [RoutineController::class, "completeRoutineTransaction"]);
        Route::get("/tasks", [UserHabitTaskController::class, "index"]);
        Route::put("/task-completed/{task}", [UserHabitTaskController::class, "completed"]);
        Route::put("/task-incomplete/{task}", [UserHabitTaskController::class, "incomplete"]);

    });
    Route::prefix('plans')->group(function () {
        Route::get('/', [SubscriptionPlanController::class, "index"]);
    });
    Route::get("leaderboard", [RewardController::class, "leaderboard"]);
    Route::get("achievement", [RewardController::class, "achievement"]);
    Route::group(['prefix' => 'expo/devices', 'middleware' => ['auth:sanctum']], function () {
        Route::post('subscribe', [\NotificationChannels\ExpoPushNotifications\Http\ExpoController::class, 'subscribe'
        ])->name("register-interest");

        Route::post('unsubscribe', [
            \NotificationChannels\ExpoPushNotifications\Http\ExpoController::class,'unsubscribe'
        ])->name("remove-interest");
    });
    Route::post('payment-done', [PaymentHandler::class, "paymentDone"]);
    Route::get('payment-history', [PaymentHandler::class, "paymentHistory"]);
});
