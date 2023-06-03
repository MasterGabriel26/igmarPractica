<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//mis rutas pantallas
Route::get('/index', function () { return Inertia::render('index'); })->name('index');
Route::get('/autos', function () { return Inertia::render('autos'); })->name('autos');
Route::get('/createPerson', function () { return Inertia::render('createPerson'); })->name('createPerson');
Route::get('/createAuto', function () { return Inertia::render('createAuto'); })->name('createAuto');
Route::get('/updatePerson/{id}', function () { return Inertia::render('updatePerson'); })->name('updatePerson');
Route::get('/updatePerson/{personId}/updateAuto/{autoId}', function () { return Inertia::render('updateAuto'); })->name('updateAuto');


// Routas que ya venian en vue
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
//->name('test.token')
//["url"=>route('test.token')]
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
