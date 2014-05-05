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

// TODO : DB 시간 기록 : 정책 정하기 (한국시간으로 할건지 아니면, utc 그냥 이용? app과의 호환성은 어찌해결?)

// TODO : DB 핸들링 : db migration 용 계정과 일반 사용 계정을 분리해야할듯

// TODO : 로그인 해야만 접근 가능한 route 필터링, 로그인 안해야만 접근 가능한 route 필터링(로그인, 회원가입 등)

// TODO : 라우팅 실패시 404 페이지로 리디렉트 되도록

//Route::get('/', function() { return View::make('hello'); });
//
Route::get('/', array('as' => 'index', 'uses' => 'MainController@index'));

Route::get('/markuptest', array('as' => 'markuptest', 'uses' => 'MarkupTestController@index'));
Route::get('/markuptest/email', array('as' => 'markuptest_email', 'uses' => 'MarkupTestController@sendEmail'));
Route::get('/markuptest/client_info', array('as' => 'markuptest_client_info', 'uses' => 'MarkupTestController@clientInfo'));

Route::group(array('prefix' => 'user'), function() {

        // TODO : register, login, reset password(reset code 왔다갔다 하는곳) 에 https 적용 (걍 user 그룹엔 다 적용하는것 고려)

        Route::get('/', array('as' => 'user', function() { return Redirect::route('user_profile');}));
        Route::get('/profile', array('as' => 'user_profile', 'uses' => 'UserController@profile'));
        Route::get('/profile/edit', array('as' => 'user_profile_edit', 'uses' => 'UserController@profileEdit'));
        Route::get('/welcome', array('as' => 'user_welcome', 'uses' => 'UserController@welcome'));
        Route::get('/register', array('as' => 'user_register', 'uses' => 'UserController@register'));
        Route::get('/activate/{activationCode}', array('as' => 'user_activate', 'uses' => 'UserController@activate'));
        Route::get('/login', array('as' => 'user_login', 'uses' => 'UserController@login'));
        Route::get('/logout', array('as' => 'user_logout', 'uses' => 'UserController@logout'));
        Route::get('/delete', array('as' => 'user_delete', 'uses' => 'UserController@delete'));
        Route::get('/delete_confirm', array('as' => 'user_delete_confirm', 'uses' => 'UserController@deleteConfirm'));
        Route::get('/forgot_password', array('as' => 'user_forgot_password', 'uses' => 'UserController@forgotPassword'));
        Route::get('/password_reset/{payload}', array('as' => 'user_password_reset', 'uses' => 'UserController@passwordReset'));
        Route::get('/password_edit', array('as' => 'user_password_edit', 'uses' => 'UserController@passwordEdit'));

        Route::post('/login', array('as' => 'user_login_post', 'uses' => 'UserController@loginPost'));
        Route::post('/register', array( /* 'before' => 'csrf', */'as' => 'user_register_post', 'uses' => 'UserController@registerPost'));
        Route::post('/forgot_password', array('as' => 'user_forgot_password_post', 'uses' => 'UserController@forgotPasswordPost'));
        Route::post('/password_reset', array('as' => 'user_password_reset_post', 'uses' => 'UserController@passwordResetPost'));
        Route::post('/password_edit', array('as' => 'user_password_edit_post', 'uses' => 'UserController@passwordEditPost'));
        Route::post('/profile/edit', array('as' => 'user_profile_edit_post', 'uses' => 'UserController@profileEditPost'));
    });
