<?php

use App\Category;
use App\Note;
use App\User;

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

Route::get('name', function () {
	return User::first()->name;
});

Route::get('api/v1/notes', function () {
	return Note::all();
});