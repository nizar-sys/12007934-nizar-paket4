<?php

use App\Http\Controllers\AuctionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DataTableController;
use App\Http\Controllers\HistoryAuctionController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RouteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

# ------ Unauthenticated routes ------ #
Route::get('/', [RouteController::class, 'landing'])->name('landing');
require __DIR__.'/auth.php';


# ------ Authenticated routes ------ #
Route::middleware('auth')->prefix('dashboard')->group(function() {
    Route::get('/', [RouteController::class, 'dashboard'])->name('home'); # dashboard

    Route::prefix('profile')->group(function(){
        Route::get('/', [ProfileController::class, 'myProfile'])->name('profile');
        Route::put('/change-ava', [ProfileController::class, 'changeFotoProfile'])->name('change-ava');
        Route::put('/change-profile', [ProfileController::class, 'changeProfile'])->name('change-profile');
    }); # profile group

    Route::middleware('roles:admin')->group(function(){
        # ------ DataTables routes ------ #
        Route::prefix('data')->name('datatable.')->group(function(){
            Route::get('/users', [DataTableController::class, 'getUsers'])->name('users');
        });

        Route::get('/datatable/users', [UserController::class, 'userDataTable'])->name('users.datatables');
        Route::resource('users', UserController::class);

        Route::get('/generate-auctions', [PdfController::class, 'auctions'])->name('generate.auctions');
        Route::get('/generate-history-auction/{auctionId}', [PdfController::class, 'historyAuction'])->name('generate.history-auction');
        Route::get('/generate-report-most-selling-month', [PdfController::class, 'mostSellingMonth'])->name('generate.most-selling-month');
        Route::get('/generate-most-popular-bidder', [PdfController::class, 'mostPopularBidder'])->name('generate.most-popular-bidder');
        Route::get('/generate-most-popular-item', [PdfController::class, 'mostPopularItem'])->name('generate.most-popular-item');
    });
    Route::resource('items', ItemController::class)->middleware('roles:admin,petugas');

    Route::prefix('/auctions/{auctionId}')->name('auctions.')->group(function(){
        Route::middleware('roles:masyarakat')->group(function(){
            Route::get('/create-auction', [HistoryAuctionController::class, 'create'])->name('create-auction');
            Route::post('/create-auction', [HistoryAuctionController::class, 'store'])->name('store-auction');
        });
        Route::post('/validate-auction', [HistoryAuctionController::class, 'validateAuction'])->name('validate-auction');
        Route::put('/approve-auction/{historyId}', [HistoryAuctionController::class, 'update'])->name('update-auction');
        Route::delete('/destroy-auction/{historyId}', [HistoryAuctionController::class, 'destroy'])->name('destroy-auction');
    });
    Route::resource('auctions', AuctionController::class);
});
