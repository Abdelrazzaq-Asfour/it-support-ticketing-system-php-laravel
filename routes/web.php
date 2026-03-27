<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';


// This group makes tickets available only to registered (Authenticated Users) 
// // This group makes tickets and crew management available only to registered users
Route::middleware('auth')->group(function () {
    
    // Ticket links (for everyone: user and admin)
    Route::resource('tickets', TicketController::class);

  // Staff management links (for admins only - we will protect them inside the Controller later)
    Route::get('/staff', [App\Http\Controllers\StaffController::class, 'index'])->name('staff.index');
    Route::patch('/staff/{user}/toggle', [App\Http\Controllers\StaffController::class, 'toggleAdmin'])->name('staff.toggle');
    Route::get('/admin/dashboard', [TicketController::class, 'dashboard'])->name('admin.dashboard');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::post('/tickets/{ticket}/comments', [TicketController::class, 'storeComment'])->name('tickets.comment');
});



