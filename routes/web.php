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

Route::get('/', 'HomeController@index');

Route::resource('menus', 'MenuController');
Route::resource('posts', 'PostController');
Route::resource('pages', 'PageController');

Auth::routes();

Route::get('exports', 'EmployeeController@export')->name('export');
Route::get('importExportViews', 'EmployeeController@importExportView');
Route::post('imports', 'EmployeeController@import')->name('import');;
