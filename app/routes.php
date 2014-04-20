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

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('/test', function()
    {
        return View::make('test');
    });

Route::get('/user', function()
    {
        return Redirect::to('user/register');
    });

Route::get('/user/register', array( 'as' => 'ddd', 'uses' => 'UserController@register'));