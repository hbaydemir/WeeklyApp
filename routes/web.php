<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\QuestController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::resource('plans', PlanController::class)->only(['store']);
});

Route::middleware(['auth'])->group(function () {
    Route::resource('quests', QuestController::class)->only(['store']);
});

Route::post('quests/{id}/status', [QuestController::class, 'updateStatus'])->name('quests.updateStatus');

Route::put('quests/{id}', [QuestController::class, 'update'])->name('quests.update');

Route::delete('quests/{id}', [QuestController::class, 'destroy'])->name('quests.destroy');

// Route::middleware(['auth'])->group(function () {

//     Route::resource('plans', PlanController::class);
//     Route::resource('plans', PlanController::class)->only(['store']);

//     Route::resource('quests', QuestController::class);
// });

// Doğrulanmış kullanıcıların belirli sayfalara erişebilmesi için verified middleware'ini kullanabilirsiniz.
// Route::get('/home', [HomeController::class, 'index'])->middleware(['auth', 'verified']);
