<?php

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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/management', function () {
    return view('management.index');
})->name('management.index');

Route::resource('management/category','Management\CategoryController');
Route::resource('management/menu','Management\MenuController');
Route::resource('management/table','Management\TableController');
Route::get('/cashier', 'Cashier\CashierController@index')->name('cashier.index');
Route::get('/cashier/getTable', 'Cashier\CashierController@getTables');
Route::get('/cashier/getSaleDetailsByTable/{table_id}', 'Cashier\CashierController@getSaleDetailsByTable');
Route::get('/cashier/getMenuByCategory/{categoryid}', 'Cashier\CashierController@getMenuByCategory');
Route::post('/cashier/orderFood', 'Cashier\CashierController@orderFood');
Route::post('/cashier/confirmOrderStatus', 'Cashier\CashierController@confirmOrderStatus');