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

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware'=>'auth'],function (){

    Route::post('/projects/{project}/tasks','ProjectTasksController@store');

    Route::patch('/projects/{project}/tasks/{task}','ProjectTasksController@update');


    Route::post('/projects','ProjectsController@store');

    Route::get('/projects','ProjectsController@index');

    Route::get('/projects/create','ProjectsController@create');

    Route::delete('/projects/{project}','ProjectsController@destroy');


    Route::get('/projects/{project}/edit','ProjectsController@edit');

    Route::get('/projects/{project}','ProjectsController@show');

    Route::patch('/projects/{project}','ProjectsController@update');

    Route::get('/home', 'HomeController@index')->name('home');

});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

