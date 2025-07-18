<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonController;
use App\Http\Controllers\MessageController;




/* Route::get('/', function () {
    $dons = App\Models\Don::latest()->take(12)->get(); // Limite à 12 dons récents
    return view('welcome', compact('dons'));
}); */

/* Route::get('/', [DonController::class, 'welcome'])->name('welcome'); */


Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index'])->name('welcome');
Route::get('/show/{don}', [App\Http\Controllers\WelcomeController::class, 'show'])->name('dons.show');
/* 
Route::get('/dashboard', function () {
    Route::get('/dashboard', [MessageController::class, 'dashboard'])->name('donateur.dashboard');
    //return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
 */
Route::get('/dashboard', [MessageController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::resource('dons', DonController::class)->except(['show'])->middleware(['auth']);

//Route::resource('messages', MessageController::class)->middleware(['auth']);
Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/create/{don}', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages/store/{don}', [MessageController::class, 'store'])->name('messages.store');

    Route::get('/messages/thread/{don}/{user}', [MessageController::class, 'thread'])->name('messages.thread');
    Route::post('/messages/thread/{don}/{user}', [MessageController::class, 'reply'])->name('messages.reply');

    Route::get('/messages/unread-count', [MessageController::class, 'unreadCount'])->name('messages.unread.count');
});
