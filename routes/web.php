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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/show-column-encrypt/{table_name}', 'HomeController@showColumnEncrypt')->name('show-column-encrypt');
Route::get('/show-column-decrypt/{table_name}', 'HomeController@showColumnDecrypt')->name('show-column-decrypt');
Route::post('/start-encrypt', 'HomeController@startEncrypt')->name('start-encrypt');
Route::post('/start-decrypt', 'HomeController@startDecrypt')->name('start-decrypt');
