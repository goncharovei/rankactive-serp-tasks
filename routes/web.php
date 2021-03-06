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

Route::get('/', 'SerpController@index')->name('task_form');
Route::get('search-engines', 'SerpController@searchEnginesGet')->name('task_search_engines');
Route::get('locations', 'SerpController@locationsGet')->name('task_locations');
Route::post('task-add', 'SerpController@taskAdd')->name('task_add');
Route::get('tasks', 'SerpController@taskList')->name('task_list');
Route::get('task-detail/{task}', 'SerpController@taskDetail')->name('task_detail');


