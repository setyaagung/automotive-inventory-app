<?php

use GuzzleHttp\Middleware;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('product', 'ProductController');
    Route::resource('category', 'CategoryController');
    Route::resource('customer', 'CustomerController');
    Route::resource('supplier', 'SupplierController');
    Route::resource('sale', 'SaleController');
    Route::post('/sale/addproduct/{id}', 'SaleController@addProductCart')->name('sale.addproduct');
    Route::delete('/sale/removeproduct/{id}', 'SaleController@removeProductCart')->name('sale.removeproduct');
    Route::post('/sale/increasecart/{id}', 'SaleController@increasecart')->name('sale.increasecart');
    Route::post('/sale/decreasecart/{id}', 'SaleController@decreasecart')->name('sale.decreasecart');
    Route::post('/sale/clear', 'SaleController@clear')->name('sale.clear');
    Route::post('/sale/pay', 'SaleController@pay')->name('sale.pay');
});
