<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DatatableController;
use App\Http\Controllers\Dashboard\MainController as DashMainController;
use Illuminate\Support\Facades\Route;

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

Route::get('login', function () {
    return view('pages.auth.login');
})->name('login');

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::group(['middleware' => 'auth', 'prefix' => 'dashboard'], function () {
    Route::controller(DashMainController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard.index');
        Route::get('/new-case', 'createCase')->name('dashboard.new-case');
        Route::get('/review-case', 'reviewCase')->name('dashboard.review-case');
        Route::get('/review-case/user', 'reviewCaseUser')->name('dashboard.review-case-user');
        Route::get('/review-case/supervisor', 'reviewCaseSupervisor')->name('dashboard.review-case-supervisor');
        Route::get('/review-case/download-pdf', 'reviewCasePDFDownload')->name('dashboard.review-case.download-pdf');
        Route::get('/review-case/detail/download-pdf/{id}', 'reviewCaseDetailPDFDownload')->name('dashboard.review-case-detail.download-pdf');
        Route::get('/review-case/detail/{id}', 'reviewCaseDetail')->name('dashboard.review-case-detail');
        Route::post('/store-case', 'storeCase')->name('dashboard.store-case');
        Route::get('/detail-case/{id}', 'detailCase')->name('dashboard.detail-case');
        Route::post('/detail-case/store', 'storeCaseInsidentDetail')->name('dashboard.detail-case.store');
        Route::post('/detail-case/store-file', 'storeCaseInsidentDetailFile')->name('dashboard.detail-case.store-file');
        Route::post('/detail-case/store-pic', 'storeCaseInsidentDetailPIC')->name('dashboard.detail-case.store-pic');
        Route::post('/detail-case/store-corrective-action', 'storeCaseInsidentDetailCA')->name('dashboard.detail-case.store-ca');
        Route::post('/detail-case/delete-ca', 'deleteCA')->name('dashboard.delete-ca');
        Route::post('/detail-case/delete-imp', 'deleteIMP')->name('dashboard.delete-imp');
    });

    Route::controller(DatatableController::class)->group(function () {
        Route::get('/datatable/list-case-not-done', 'listCaseNotDone')->name('ajax.datatable.list-case-not-done');
        Route::get('/datatable/implementationAttachmentData', 'implementationAttachmentData')->name('ajax.datatable.implementationAttachmentData');
        Route::get('/datatable/corectiveActionAttachmentData', 'corectiveActionAttachmentData')->name('ajax.datatable.corectiveActionAttachmentData');
    });
});
