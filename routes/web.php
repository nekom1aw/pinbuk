<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAcessController;
use App\Http\Controllers\UserController;    
use App\Http\Controllers\BukuController;
use App\Http\Controllers\ControllerLogin;
use App\Http\Middleware\UserAccess;
use App\Http\Controllers\PeminjamanUser;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AssetController;

Route::get('login', [ControllerLogin::class, 'showLogin'])->name('login');
Route::post('login', [ControllerLogin::class, 'login'])->name('login.process');

// Admin Route dengan middleware untuk mengakses level admin

Route::prefix('admin')->name('admin.')->middleware([UserAccess::class . ':admin'])->group(function () {
    Route::get('/dashboard', [ControllerLogin::class, 'index'])->name('admin.dashboard');
    Route::post('/logout', [ControllerLogin::class, 'logout'])->name('logout');
    
    // Grup rute untuk mengelola users
    Route::prefix('users')->name('admin.users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('{id}/detail', [UserController::class, 'show'])->name('detail');
        Route::get('{id}/edit', [UserController::class, 'edit'])->name('edit'); 
        Route::put('{id}', [UserController::class, 'update'])->name('update');
        Route::delete('{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('buku')->name('admin.buku.')->group(function () {
        Route::get('/', [BukuController::class, 'index'])->name('index');
        Route::get('create', [BukuController::class, 'create'])->name('create');
        Route::post('/', [BukuController::class, 'store'])->name('store');
        Route::get('{id}/detail', [BukuController::class, 'show'])->name('detail');
        Route::get('{id}/view', [BukuController::class, 'view'])->name('view');
        Route::get('{id}/edit', [BukuController::class, 'edit'])->name('edit');
        Route::put('{id}', [BukuController::class, 'update'])->name('update');
        Route::delete('{id}', [BukuController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/pinjam', [BukuController::class, 'pinjam'])->name('pinjam'); 
        Route::get('/kategori', [BukuController::class, 'kategori'])->name('index');
        Route::get('/kategori-buku', [BukuController::class, 'katebuku'])->name('katebuku');
        Route::get('/kategori-buku/{id}', [BukuController::class, 'katedetail'])->name('katedetail');
        Route::get('kategori-buku/{kategoriId}/subkategori/{subkategoriId}', [BukuController::class, 'kategoriSubkategori'])->name('subkategori1');
        Route::get('/kategori-buku/{kategori}/subkategori/{sub1}/sub2/{sub2}', [BukuController::class, 'kategorisubkategori2'])->name('subkategori2');
    });

    Route::prefix('peminjaman')->name('admin.peminjaman.')->group(function () {  
        Route::get('/', [PeminjamanController::class, 'index'])->name('index');
        Route::get('/{id}/edit', [PeminjamanController::class, 'edit'])->name('edit');  
        Route::put('/{id}', [PeminjamanController::class, 'update'])->name('update');  
        Route::delete('/{id}', [PeminjamanController::class, 'destroy'])->name('destroy'); 
        Route::get('/{id}/detail', [PeminjamanController::class, 'show'])->name('detail'); 

    });

        Route::prefix('aset')->name('admin.asset.')->group(function () {
        Route::get('/', [AssetController::class, 'index'])->name('index');
        Route::get('/create', [AssetController::class, 'create'])->name('create');
        Route::post('/', [AssetController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AssetController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AssetController::class, 'update'])->name('update');
        Route::delete('/{id}', [AssetController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/detail', [AssetController::class, 'show'])->name('detail');
        Route::get('/{id}/pinjam', [AssetController::class, 'pinjam'])->name('pinjam');
    });
});



Route::prefix('user')->name('user.')->middleware([UserAccess::class . ':user'])->group(function () {
    Route::get('/dashboard', [ControllerLogin::class, 'indexuser'])->name('dashboard');
    Route::post('/logout', [ControllerLogin::class, 'logout'])->name('logout');

    Route::prefix('buku')->name('buku.')->group(function () {
        Route::get('/', [UserAcessController::class, 'indexbuku'])->name('index');
        Route::get('{id}/detail', [UserAcessController::class, 'show'])->name('detail');
        Route::get('{id}/view', [UserAcessController::class, 'view'])->name('view');
        Route::get('{id}/katalog', [UserAcessController::class, 'katalog'])->name('katalog');
        Route::get('/search/{key}', [UserAcessController::class, 'key'])->name('user.search.result');
        
    });

    Route::prefix('peminjaman')->name('peminjaman.')->group(function () {
        Route::get('/', [PeminjamanUser::class, 'index'])->name('index');
        Route::get('{id}/detail', [PeminjamanUser::class, 'show'])->name('detail');
    });

});


Route::get('/', function () {
    return view('welcome');
});
