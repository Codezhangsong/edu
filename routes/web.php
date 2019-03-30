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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::any('student/search', 'StudentsController@search');
Route::any('student/add', 'StudentsController@add');
Route::any('student/edit', 'StudentsController@edit');
Route::any('student/del', 'StudentsController@del');
Route::get('student/get', 'StudentsController@get');

Route::any('parent/search', 'ParentsController@search');
Route::any('parent/add', 'ParentsController@add');
Route::any('parent/edit', 'ParentsController@edit');
Route::any('parent/del', 'ParentsController@del');
Route::any('parent/get', 'ParentsController@get');

Route::any('tag/search', 'TagController@search');
Route::any('tag/add', 'TagController@add');
Route::any('tag/edit', 'TagController@edit');
Route::any('tag/del', 'TagController@del');
Route::any('tag/get', 'TagController@get');

Route::any('level/search', 'LevelController@search');
Route::any('level/add', 'LevelController@add');
Route::any('level/edit', 'LevelController@edit');
Route::any('level/del', 'LevelController@del');
Route::any('level/get', 'LevelController@get');


Route::any('test/get', 'TestController@get');



