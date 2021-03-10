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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('student/information/data', 'StudentController@get_data');
Route::post('student/information/store', 'StudentController@store_data');
Route::post('student/information/update', 'StudentController@update_data');
Route::post('student/information/delete', 'StudentController@delete_data');

//post route
Route::resource('posts', 'PostController');
Route::resource('tests', 'TestController');
Route::resource('customer', 'CustomerController');


//

Route::get('/ajax-form','AjaxController@ajax_form');
Route::post('/ajax','AjaxController@ajax');


//Teacher route

Route::get('/teacher','TeacherController@index');
Route::post('/teacher-store','TeacherController@store');

/**********************************************/
//--LOAD THE VIEW--//
Route::get('/laracruds','LinkController@index');

//--CREATE a link--//
Route::post('/links','LinkController@store');

//--GET LINK TO EDIT--//
Route::get('/links/{link_id?}','LinkController@edit');

//--UPDATE a link--//
Route::put('/links/{link_id?}', 'LinkController@update');

//--DELETE a link--//
Route::delete('/links/{link_id?}','LinkController@delete');
