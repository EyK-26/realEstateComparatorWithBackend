<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/password-reset/{email}/{token}/{datetime}', [PasswordResetController::class, 'reset'])
    ->name('password.reset');

Route::group(['middleware' => 'can:admin'], function () {
    Route::get('/enquiry/{offer_id}/{user_id}', [EnquiryController::class, 'show'])
        ->whereNumber(['offer_id', 'user_id'])
        ->name('enquiry.show');

    Route::get('/enquiry/answer/{enquiry_id}', [EnquiryController::class, 'answer'])
        ->whereNumber('enquiry_id')
        ->name('enquiry.answer');

    Route::post('/answers', [AnswerController::class, 'store'])
        ->name('answers.store');

    Route::get('/offer', [OfferController::class, 'create'])
        ->name('offer.create');

    Route::post('/offer', [OfferController::class, 'store'])
        ->name('offer.store');

    Route::get('/offers', [OfferController::class, 'index'])
        ->name('offers.index');

    Route::get('/offers/{offer}', [OfferController::class, 'edit'])->whereNumber('offer')
        ->name('offers.edit');

    Route::post('/offers/{offer}', [OfferController::class, 'update'])->whereNumber('offer')
        ->name('offers.update');

    Route::delete('/offers/{offer}', [OfferController::class, 'destroy'])->whereNumber('offer')
        ->name('offer.destroy');

    Route::get('/questions-all/', [QuestionController::class, 'index'])
        ->name('questions.index');

    Route::get('/questions', [QuestionController::class, 'create'])
        ->name('questions.create');

    Route::get('/questions/{question}', [QuestionController::class, 'edit'])
        ->name('questions.edit');

    Route::post('/questions/', [QuestionController::class, 'store'])
        ->name('questions.store');

    Route::post('/questions/{question}', [QuestionController::class, 'update'])->whereNumber('question')
        ->name('questions.update');

    Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->whereNumber('question')
        ->name('questions.destroy');
});

Route::view('/{path?}', 'home')
    ->where('path', '.*');
