<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ActivityLogController;

// Route::get('/signin', function () {
//     return view('pages.auth.signin', ['title' => 'Sign In']);
// })->name('signin');

// Route::get('/signup', function () {
//     return view('pages.auth.signup', ['title' => 'Sign Up']);
// })->name('signup');

Route::get('/login', function () {
    return redirect()->route('signin');
})->name('login');

Route::middleware('guest')->group(function () {

    Route::view('/signin', 'pages.auth.signin')
        ->name('signin');

    Route::post('/signin', LoginController::class);

    Route::view('/signup', 'pages.auth.signup')
        ->name('signup');

    Route::post('/signup', RegisterController::class);
});

Route::post('/logout', LogoutController::class)
    ->middleware('auth')
    ->name('logout');

// dashboard pages

Route::middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/dashboard/filter', [DashboardController::class, 'filter'])
        ->name('dashboard.filter');

    Route::resource('tasks', TaskController::class)->except(['show']);

    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])
        ->name('tasks.status');

    Route::get('/tasks/deleted', [TaskController::class, 'deleted'])
        ->name('tasks.deleted');

    Route::post('/tasks/{id}/restore', [TaskController::class, 'restore'])
        ->name('tasks.restore');

    Route::get('/kanban', [TaskController::class, 'kanban'])
        ->name('tasks.kanban');

    Route::get('/tasks/export', [TaskController::class, 'export'])
        ->name('tasks.export');

    Route::get('/activity-logs',[ActivityLogController::class, 'index'])
    ->name('activity.logs');

    // Route::patch('/tasks/{task}/kanban-status', [TaskController::class, 'updateKanbanStatus'])
    // ->name('tasks.kanban-status');

});
// Route::get('/', function () {
//     return view('pages.dashboard.ecommerce', ['title' => 'E-commerce Dashboard']);
// })->name('dashboard');

// task pages

// Route::resource('tasks', TaskController::class);

// Route::get('/task', function () {
//     return view('pages.task.create-task', ['title' => 'Create Task']);
// })->name('create-task');

Route::get('/show-task', function () {
    return view('pages.task.show-task', ['title' => 'Show Task']);
})->name('show-task');

// calender pages
Route::get('/calendar', function () {
    return view('pages.calender', ['title' => 'Calendar']);
})->name('calendar');

// profile pages
Route::get('/profile', function () {
    return view('pages.profile', ['title' => 'Profile']);
})->name('profile');

// form pages
Route::get('/form-elements', function () {
    return view('pages.form.form-elements', ['title' => 'Form Elements']);
})->name('form-elements');

// tables pages
Route::get('/basic-tables', function () {
    return view('pages.tables.basic-tables', ['title' => 'Basic Tables']);
})->name('basic-tables');

// pages

Route::get('/blank', function () {
    return view('pages.blank', ['title' => 'Blank']);
})->name('blank');

// error pages
Route::get('/error-404', function () {
    return view('pages.errors.error-404', ['title' => 'Error 404']);
})->name('error-404');

// chart pages
Route::get('/line-chart', function () {
    return view('pages.chart.line-chart', ['title' => 'Line Chart']);
})->name('line-chart');

Route::get('/bar-chart', function () {
    return view('pages.chart.bar-chart', ['title' => 'Bar Chart']);
})->name('bar-chart');

// authentication pages
// Route::get('/signin', function () {
//     return view('pages.auth.signin', ['title' => 'Sign In']);
// })->name('signin');

// Route::get('/signup', function () {
//     return view('pages.auth.signup', ['title' => 'Sign Up']);
// })->name('signup');

// ui elements pages
Route::get('/alerts', function () {
    return view('pages.ui-elements.alerts', ['title' => 'Alerts']);
})->name('alerts');

Route::get('/avatars', function () {
    return view('pages.ui-elements.avatars', ['title' => 'Avatars']);
})->name('avatars');

Route::get('/badge', function () {
    return view('pages.ui-elements.badges', ['title' => 'Badges']);
})->name('badges');

Route::get('/buttons', function () {
    return view('pages.ui-elements.buttons', ['title' => 'Buttons']);
})->name('buttons');

Route::get('/image', function () {
    return view('pages.ui-elements.images', ['title' => 'Images']);
})->name('images');

Route::get('/videos', function () {
    return view('pages.ui-elements.videos', ['title' => 'Videos']);
})->name('videos');
