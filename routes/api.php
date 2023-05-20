<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PullRequestController;

Route::group(["prefix" => "pull-requests"], function(){

    Route::get('/old', [PullRequestController::class, 'getOldPullRequests']);
    Route::get('/review-required', [PullRequestController::class, 'getPullRequestsWithReviewRequired']);
    Route::get('/review-successful', [PullRequestController::class, 'getPullRequestsWithSuccessfulReview']);
    Route::get('/no-reviews-requested', [PullRequestController::class, 'getPullRequestsWithNoReviewsRequested']);
});