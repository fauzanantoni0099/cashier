<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::middleware(['auth'])->group(function (){
    Route::prefix('admin')->group(function () {
        Route::resource('category','CategoryController');
        Route::resource('product','ProductController');
        Route::resource('unit','UnitController');
        Route::resource('user', 'UserController');
        Route::resource('service_name', 'ServiceNameController');
        //order
        Route::prefix('order')->group(function () {
            Route::get('/', 'OrderController@admin')->name('order.admin');
            Route::get('/{order}/edit', 'OrderController@edit')->name('order.edit');
            Route::put('/{order}', 'OrderController@update')->name('order.update');
            Route::delete('/{order}', 'OrderController@destroy')->name('order.destroy');
            Route::get('/dailyReport', 'OrderController@dailyReport')->name('order.dailyReport');
            Route::get('/monthlyReport', 'OrderController@monthlyReport')->name('order.monthlyReport');
            Route::get('/annualReport', 'OrderController@annualReport')->name('order.annualReport');
            Route::get('/dailyReport/{tanggal}/reportPdfDaily', 'OrderController@reportPdfDaily')->name('order.reportPdfDaily');
            Route::get('/monthlyReport/{bulan}/reportPdfMonth', 'OrderController@reportPdfMonth')->name('order.reportPdfMonth');
            Route::get('/annualReport/{tahun}/reportPdfAnnual', 'OrderController@reportPdfAnnual')->name('order.reportPdfAnnual');
        });
        //service
        Route::prefix('service')->group(function () {
            Route::get('/', 'ServiceController@admin')->name('service.admin');
            Route::get('/{service}/edit', 'ServiceController@edit')->name('service.edit');
            Route::put('/{service}', 'ServiceController@update')->name('service.update');
            Route::delete('/{service}', 'ServiceController@destroy')->name('service.destroy');
            Route::get('/dailyReport', 'ServiceController@dailyReport')->name('service.dailyReport');
            Route::get('/monthlyReport', 'ServiceController@monthlyReport')->name('service.monthlyReport');
            Route::get('/annualReport', 'ServiceController@annualReport')->name('service.annualReport');
            Route::get('/dailyReport/{tanggal}/reportPdfDaily', 'ServiceController@reportPdfDaily')->name('service.reportPdfDaily');
            Route::get('/monthlyReport/{bulan}/reportPdfMonth', 'ServiceController@reportPdfMonth')->name('service.reportPdfMonth');
            Route::get('/annualReport/{tahun}/reportPdfAnnual', 'ServiceController@reportPdfAnnual')->name('service.reportPdfAnnual');
        });
        Route::get('/index', function () {
            return view('layouts/index');
        });
    });

});

//Order
Route::get('/order', 'OrderController@index')->name('order.index');
Route::get('/order/create', 'OrderController@create')->name('order.create');
Route::post('/order/create', 'OrderController@store')->name('order.store');
Route::get('/order/{order}', 'OrderController@show')->name('order.show');
Route::get('/order/{order}/printBarcode', 'OrderController@printBarcode')->name('order.printBarcode');

//service
Route::get('/service', 'ServiceController@index')->name('service.index');
Route::get('/service/create', 'ServiceController@create')->name('service.create');
Route::post('/service/create', 'ServiceController@store')->name('service.store');
Route::get('/service/{service}', 'ServiceController@show')->name('service.show');
Route::get('/service/{service}/printBarcode', 'ServiceController@printBarcode')->name('service.printBarcode');

Route::get('/input', function () {
    return view('layouts/input');
});


Route::get('/home', 'HomeController@index')->name('home');

