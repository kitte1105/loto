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
Route::redirect('/', '/home', 301);

Route::get('/server', 'ServerController@index')->name('server');
Route::get('/client', 'ClientController@index')->name('client');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
