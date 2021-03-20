<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobEntryController;

Route::get('/', [JobEntryController::class, 'index'])->name('job-entry.form');
Route::post('submit-job-entry', [JobEntryController::class, 'store'])->name('job-entry.submit');