<?php

use App\Http\Controllers\CommunityController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [FeedController::class, 'index'])->name('feed');
Route::get('/getMostConnectedUser', [UserController::class, 'getMostConnectedUser']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/user/{user_id}', [UserController::class, 'show'])->name('user.show');
    Route::get('/community/{community_id}', [CommunityController::class, 'show'])->name('community.show');

    Route::post('/like', [PostController::class, 'toggleLike']);
    Route::post('/participate', [EventController::class, 'toggleParticipate']);
    Route::get('/getComments', [PostController::class, 'getComments']);
    Route::post('/addComment', [PostController::class, 'addComment']);

    Route::post('/follow', [CommunityController::class, 'toggleFollow']);
    Route::post('/getAllMembers', [CommunityController::class, 'getAllMembers']);
});

require __DIR__.'/auth.php';
