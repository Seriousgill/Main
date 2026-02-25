<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'visitor.registration')->name('visitor.registration');
Route::get('/visitor/status/{visit}', [\App\Http\Controllers\Visitor\StatusController::class, 'show'])->name('visitor.status');

require __DIR__.'/admin.php';
require __DIR__.'/host.php';
