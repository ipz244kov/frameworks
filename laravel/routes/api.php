<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubjectController;

Route::apiResource('subjects', SubjectController::class);
