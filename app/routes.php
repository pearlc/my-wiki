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

// TODO : DB 시간 기록 : 정책 정하기 (한국시간으로 할건지 아니면

// TODO : 라우팅 실패시 404 페이지로 리디렉트 되도록

//Route::get('/', function() { return View::make('hello'); });
//
Route::get('/', array('as' => 'index', 'uses' => 'MainController@index'));

Route::get('/markuptest/{spec?}', array('as' => 'markuptest', 'uses' => 'MarkupTestController@index'));

Route::group(array('prefix' => 'user'), function() {

        Route::get('/', array( 'as' => 'user', 'uses' => 'UserController@profile'));
        Route::get('/profile', array( 'as' => 'user_profile', 'uses' => 'UserController@profile'));
        Route::get('/welcome', array( 'as' => 'user_welcome', 'uses' => 'UserController@welcome'));
        Route::get('/register', array( 'as' => 'user_register', 'uses' => 'UserController@register'));
        Route::get('/activate/{userId}/{activationCode}', array( 'as' => 'user_activate', 'uses' => 'UserController@activate'));
        Route::get('/login', array('as' => 'user_login', 'uses' => 'UserController@login'));
        Route::get('/logout', array( 'as' => 'user_logout', 'uses' => 'UserController@logout'));

        Route::post('/login', array( 'as' => 'user_login_post', 'uses' => 'UserController@loginPost'));
        Route::post('/register', array( /* 'before' => 'csrf', */'as' => 'user_register_post', 'uses' => 'UserController@registerPost'));
    });
