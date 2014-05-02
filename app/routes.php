<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function() { return View::make('hello'); });

Route::get('/', array('as' => 'index', 'uses' => 'MainController@main'));

Route::get('/markuptest/{spec?}', array('as' => 'markuptest', 'uses' => 'MarkupTestController@main'));
Route::get('/user', array( 'as' => 'user', 'uses' => 'UserController@profile'));
Route::get('/user/profile', array( 'as' => 'user_profile', 'uses' => 'UserController@profile'));
Route::get('/user/register', array( 'as' => 'user_register', 'uses' => 'UserController@register'));