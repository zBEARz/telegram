<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;

Route::get('/', [FormController::class, 'showForm']);
Route::post('/form-submit', [FormController::class, 'submit']);
