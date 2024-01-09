<?php

use App\Http\Controllers\administrator\JenisMitra;
use App\Http\Controllers\administrator\laporan\Followup;
use App\Http\Controllers\administrator\laporan\Mitra;
use App\Http\Controllers\administrator\laporan\Nota;
use App\Http\Controllers\administrator\laporan\Quotation;
use App\Http\Controllers\administrator\Pengguna;
use App\Http\Controllers\authentications\Login;
use App\Http\Controllers\dashboard\Dashboard;
use Illuminate\Support\Facades\Route;

// Main Page Route

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/', [Login::class, 'index'])->name('login');
        Route::post('/auth', [Login::class, 'process']);
    });

    Route::group(['middleware' => ['auth']], function () {
        Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');
        Route::get('/logout', [Login::class, 'logout'])->name('logout');

        Route::get('/laporan/nota', [Nota::class, 'index'])->name('laporan-nota');
        Route::get('/laporan/nota/add', [Nota::class, 'add'])->name('laporan-nota.add');
        Route::post('/laporan/nota/store', [Nota::class, 'store'])->name('laporan-nota.store');
        Route::delete('/laporan/nota/delete/{id}', [Nota::class, 'delete'])->name('laporan-nota.delete');
        Route::get('/laporan/nota/update/{id}', [Nota::class, 'update'])->name('laporan-nota.update');
        Route::put('/laporan/nota/put/{id}', [Nota::class, 'put'])->name('laporan-nota.put');
        Route::get('/laporan/nota/download/{fileName}', [Nota::class, 'download'])->name('laporan-nota.download');
        Route::get('/laporan/nota/getById/{id}', [Nota::class, 'getById'])->name('laporan-nota.getById');

        Route::get('/laporan/quotation', [Quotation::class, 'index'])->name('laporan-quotation');
        Route::get('/laporan/quotation/add', [Quotation::class, 'add'])->name('laporan-quotation.add');
        Route::post('/laporan/quotation/store', [Quotation::class, 'store'])->name('laporan-quotation.store');
        Route::delete('/laporan/quotation/delete/{id}', [Quotation::class, 'delete'])->name('laporan-quotation.delete');
        Route::get('/laporan/quotation/update/{id}', [Quotation::class, 'update'])->name('laporan-quotation.update');
        Route::put('/laporan/quotation/put/{id}', [Quotation::class, 'put'])->name('laporan-quotation.put');
        Route::get('/laporan/quotation/download/{fileName}', [Quotation::class, 'download'])->name('laporan-quotation.download');

        Route::get('/laporan/followup', [Followup::class, 'index'])->name('laporan-followup');
        Route::get('/laporan/followup/add', [Followup::class, 'add'])->name('laporan-followup.add');
        Route::post('/laporan/followup/store', [Followup::class, 'store'])->name('laporan-followup.store');
        Route::delete('/laporan/followup/delete/{id}', [Followup::class, 'delete'])->name('laporan-followup.delete');
        Route::get('/laporan/followup/update/{id}', [Followup::class, 'update'])->name('laporan-followup.update');
        Route::put('/laporan/followup/put/{id}', [Followup::class, 'put'])->name('laporan-followup.put');

        Route::get('/laporan/mitra', [Mitra::class, 'index'])->name('laporan-mitra');
        Route::get('/laporan/mitra/add', [Mitra::class, 'add'])->name('laporan-mitra.add');
        Route::post('/laporan/mitra/store', [Mitra::class, 'store'])->name('laporan-mitra.store');
        Route::delete('/laporan/mitra/delete/{id}', [Mitra::class, 'delete'])->name('laporan-mitra.delete');
        Route::get('/laporan/mitra/update/{id}', [Mitra::class, 'update'])->name('laporan-mitra.update');
        Route::put('/laporan/mitra/put/{id}', [Mitra::class, 'put'])->name('laporan-mitra.put');

        Route::get('/pengguna', [Pengguna::class, 'index'])->name('pengguna');
        Route::get('/pengguna/add', [Pengguna::class, 'add'])->name('pengguna.add');
        Route::post('/pengguna/store', [Pengguna::class, 'store'])->name('pengguna.store');
        Route::delete('/pengguna/delete/{id}', [Pengguna::class, 'delete'])->name('pengguna.delete');

        Route::get('/jenis-mitra', [JenisMitra::class, 'index'])->name('jenis-mitra');
        Route::get('/jenis-mitra/add', [JenisMitra::class, 'add'])->name('jenis-mitra.add');
        Route::post('/jenis-mitra/store', [JenisMitra::class, 'store'])->name('jenis-mitra.store');
        Route::delete('/jenis-mitra/delete/{id}', [JenisMitra::class, 'delete'])->name('jenis-mitra.delete');
        Route::get('/jenis-mitra/update/{id}', [JenisMitra::class, 'update'])->name('jenis-mitra.update');
        Route::put('/jenis-mitra/put/{id}', [JenisMitra::class, 'put'])->name('jenis-mitra.put');
    });
});
