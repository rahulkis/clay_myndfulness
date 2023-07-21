<?php

use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\DailyJournalController;
use App\Http\Controllers\Admin\HabitCategoryController;
use App\Http\Controllers\Admin\RewardController;
use App\Http\Controllers\Admin\SelfAssessmentController;
use App\Http\Controllers\Api\User\SocialAuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\WebhookController;

Route::get('/', function () {
    return redirect()
        ->route("login");
});

Route::middleware(['auth'])->group(function () {
    Route::get('/habits', 'HabbitController@index')->name('habbits.index');
    Route::get('/contact-us', [ContactUsController::class,"index"])->name('contact-us.index');
    Route::get('/categories', [HabitCategoryController::class, "index"])->name('habbits.category');
    // Route::prefix('questions')->group(function () {
        Route::get('questions-all', 'QuestionController@index')->name('questions.index');
        Route::post('questions/store', 'QuestionController@store');
        Route::get('question-add', 'QuestionController@add')->name('questions.add');
        Route::get('questions/edit-question/{question_id}', 'QuestionController@edit')->name('questions.edit');
        Route::post('questions/update', 'QuestionController@update');
    // });
    // Route::prefix('q-group')->group(function () {
        Route::get('/q-groups', 'QuestionGroupController@index')->name('questions-group.index');
        Route::get('/add-q-group', 'QuestionGroupController@add')->name('questions-group.add');
    // });
    Route::prefix('group-questions')->group(function () {
        Route::get('/{group_id}', 'GroupQuestionController@index')->name('group-questions.index');
        Route::post('/store', 'GroupQuestionController@store');
        // Route::get('/add-questions-group','QuestionGroupController@add')->name('group-questions.add');
    });
    Route::get('/dashboard', 'HomeController@dashboard')->middleware(['auth'])->name('dashboard');
    Route::get("change-password", [HomeController::class, "changePassword"])->name("change-password");
    Route::post("change-password", [HomeController::class, "changePasswordPost"])->name("change-password.post");
    Route::get('subscription-plan', function () {
        return view("subscription_plans.index");
    })->name("subscription-plan");
    Route::get('push-notifications', function () {
        return view("push-notification.index");
    })->name("push-notification.index");
    Route::prefix('users')->group(function () {
        Route::get("/", function () {
            return view("users.index");
        })->name("users.index");
        Route::get("/profile/{user}", [UserController::class, "profile"])->name("user.profile");
    });
    Route::prefix('onboarding-responses')->group(function () {
        Route::get("/", function () {
            return view("users.responses");
        })->name("users.responses");
    });
    Route::prefix('self-assessment-responses')->group(function () {
        Route::get("/", function () {
            return view("users.self-assessment.index");
        })->name("users.self-assessment-responses");
        Route::get("/{response}", [SelfAssessmentController::class, "show"])->name("self-assessment-responses.show");
    });
    Route::prefix('daily-journal')->as("daily-journal.")->group(function () {
        Route::get("/", [DailyJournalController::class, "index"])->name("index");
        Route::get("/{response}", [DailyJournalController::class, "show"])->name("show");
    });
    Route::get("leaderboard", [RewardController::class, "leaderboard"])->name("leaderboard");
});
Route::match(['get', 'post'], '/apple/webhook', [WebhookController::class, "appleWebhook"]);
Route::match(['get', 'post'], '/google/webhook', [WebhookController::class, "googleWebhook"]);
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle']);
require __DIR__ . '/auth.php';
