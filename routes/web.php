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

Route::get('export', 'ExportController@export')->name('export');
Route::get('importExportView', 'ImportController@importExportView');
Route::post('import', 'ImportController@import')->name('import');;
