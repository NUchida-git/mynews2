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

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('news/create', 'Admin\NewsController@add');
    Route::post('news/create', 'Admin\NewsController@create');
    Route::get('news', 'Admin\NewsController@index');
    Route::get('news/edit', 'Admin\NewsController@edit');
    Route::post('news/edit', 'Admin\NewsController@update');
    Route::get('news/delete', 'Admin\NewsController@delete');

    Route::get('profile/create', 'Admin\ProfileController@add');
    Route::post('profile/create', 'Admin\ProfileController@create');
    Route::get('profile', 'Admin\ProfileController@index');
    Route::get('profile/edit', 'Admin\ProfileController@edit');
    Route::post('profile/edit', 'Admin\ProfileController@update');
    Route::get('profile/delete', 'Admin\ProfileController@delete');

    Route::get('task/create', 'Admin\TaskController@add');
    Route::post('task/create', 'Admin\TaskController@create');
    Route::get('task', 'Admin\TaskController@index');
    Route::get('task/completed_list', 'Admin\TaskController@indexComp');
    Route::get('task/edit', 'Admin\TaskController@edit');
    Route::post('task/edit', 'Admin\TaskController@update');
    Route::get('task/delete', 'Admin\TaskController@delete');
    Route::post('task/complete', 'Admin\TaskController@complete');
    Route::post('task/incomplete', 'Admin\TaskController@incomplete');

    Route::get('category/create', 'Admin\CategoryController@add');
    Route::post('category/create', 'Admin\CategoryController@create');
    Route::get('category', 'Admin\CategoryController@index');
    Route::get('category/edit', 'Admin\CategoryController@edit');
    Route::post('category/edit', 'Admin\CategoryController@update');
    Route::get('category/delete', 'Admin\CategoryController@delete');

});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/news', 'NewsController@index');
Route::get('/profile', 'ProfileController@index');
Route::get('/task', 'TaskController@index');
Route::get('/category', 'CategoryController@index');
