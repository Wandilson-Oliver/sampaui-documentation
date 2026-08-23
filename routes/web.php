<?php

use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\PlaygroundController;
use Illuminate\Support\Facades\Route;

Route::get('/', DocumentationController::class)->name('documentation');
Route::get('/playground', [PlaygroundController::class, 'index'])->name('playground');
Route::post('/playground/compile', [PlaygroundController::class, 'compile'])->name('playground.compile');
Route::get('/examples', [ExampleController::class, 'index'])->name('examples.index');
Route::get('/examples/authentication', [ExampleController::class, 'authentication'])->name('examples.authentication');
Route::get('/examples/dashboard', [ExampleController::class, 'dashboard'])->name('examples.dashboard');
Route::get('/examples/admin-form', [ExampleController::class, 'adminForm'])->name('examples.admin-form');
Route::get('/examples/destructive-modal', [ExampleController::class, 'destructiveModal'])->name('examples.destructive-modal');
Route::get('/examples/filter-drawer', [ExampleController::class, 'filterDrawer'])->name('examples.filter-drawer');
Route::get('/examples/advanced-table', [ExampleController::class, 'advancedTable'])->name('examples.advanced-table');
Route::get('/examples/profile', [ExampleController::class, 'profile'])->name('examples.profile');
Route::get('/examples/verification', [ExampleController::class, 'verification'])->name('examples.verification');
Route::get('/examples/command-palette', [ExampleController::class, 'commandPalette'])->name('examples.command-palette');
Route::get('/examples/settings', [ExampleController::class, 'settings'])->name('examples.settings');
Route::get('/examples/feedback', [ExampleController::class, 'feedback'])->name('examples.feedback');
Route::get('/examples/chat', [ExampleController::class, 'chat'])->name('examples.chat');
Route::get('/examples/icons', [ExampleController::class, 'icons'])->name('examples.icons');
Route::get('/examples/users', [ExampleController::class, 'usersIndex'])->name('examples.users.index');
Route::get('/components/{component}', [DocumentationController::class, 'show'])
    ->name('documentation.components.show');
Route::get('/pages/{page}/preview', [DocumentationController::class, 'pagePreview'])
    ->name('documentation.pages.preview');
Route::get('/pages/{page}', [DocumentationController::class, 'page'])
    ->name('documentation.pages.show');
