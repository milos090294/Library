<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\ProfileController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/user', [ProfileController::class, 'index'])->name('user');
    Route::get('/getUsers', [ProfileController::class, 'getUsers'])->name('getUsers');
    Route::delete('/deleteUser/{id}', [ProfileController::class, 'deleteUser'])->name('deleteUSer');
    Route::put('/updateUser/{id}', [ProfileController::class, 'updateUser'])->name('updateUser');
    Route::get('/getUser/{id}', [ProfileController::class, 'getUser'])->name('getUser');
    Route::get('/searchUser/{search}', [ProfileController::class, 'searchUser'])->name('searchUser');

    Route::get('/book', [BookController::class, 'index'])->name('book');
    Route::get('/allBooks', [BookController::class, 'getBooks'])->name('allBooks');
    Route::post('/storeBook', [BookController::class, 'store'])->name('storeBook');
    Route::delete('/deleteBook/{id}', [BookController::class, 'destroy'])->name('deleteBook');
    Route::get('/getBook/{id}', [BookController::class, 'getBook'])->name('getBook');
    Route::put('/updateBook/{id}', [BookController::class, 'updateBook'])->name('updateBook');
    Route::get('/searchBook/{search}', [BookController::class, 'searchBook'])->name('searchBook');
    Route::get('/issuing', [BookController::class, 'issuingView'])->name('issuing');
    Route::get('/return', [BookController::class, 'returnView'])->name('return');
    Route::post('/addIssuing', [BookController::class, 'addIssuing'])->name('addIssuing');
    Route::post('/returnBook', [BookController::class, 'returnBook'])->name('returnBook');
    Route::get('/membersBooks/{id}', [BookController::class, 'membersBooks'])->name('membersBooks');

    Route::get('/member', [MembersController::class, 'index'])->name('member');
    Route::get('/allMembers', [MembersController::class, 'getMembers'])->name('allMembers');
    Route::post('/storeMember', [MembersController::class, 'store'])->name('storeMember');
    Route::delete('/deleteMember/{id}', [MembersController::class, 'destroy'])->name('deleteMember');
    Route::put('/updateMember/{id}', [MembersController::class, 'updateMember'])->name('updateMember');
    Route::get('/getMember/{id}', [MembersController::class, 'getMember'])->name('getMember');
    Route::get('/searchMember/{search}', [MembersController::class, 'searchMember'])->name('searchMember');
    Route::get('/allBorrowMembers', [MembersController::class, 'allBorrowMembers'])->name('allBorrowMembers');
    Route::get('/lateMembers', [MembersController::class, 'getLateMembers'])->name('lateMembers');
});

require __DIR__ . '/auth.php';
