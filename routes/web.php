<?php

use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\ExampleController;
use Illuminate\Support\Facades\Route;

Route::get('/', DocumentationController::class)->name('documentation');
Route::get('/examples', [ExampleController::class, 'index'])->name('examples.index');
Route::get('/examples/authentication', [ExampleController::class, 'authentication'])->name('examples.authentication');
Route::get('/examples/dashboard', [ExampleController::class, 'dashboard'])->name('examples.dashboard');
Route::get('/examples/users', [ExampleController::class, 'usersIndex'])->name('examples.users.index');
Route::get('/examples/users/create', [ExampleController::class, 'usersCreate'])->name('examples.users.create');
Route::get('/components/{component}', [DocumentationController::class, 'show'])
    ->name('documentation.components.show');
Route::get('/pages/{page}/preview', [DocumentationController::class, 'pagePreview'])
    ->name('documentation.pages.preview');
Route::get('/pages/{page}', [DocumentationController::class, 'page'])
    ->name('documentation.pages.show');
