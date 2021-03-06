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

// TODO : 라우팅 실패시 404 페이지로 리디렉트 되도록

// TODO : validator 오류메시지 한글화

//Route::when('*', 'csrf', ['post', 'put', 'patch']);

// TODO : 필터 위치 여기가 맞는가?
Route::filter('sentryAuth', function() {
        if (!Sentry::getUser()) {
            return Redirect::route('index');
        }
    });

Route::filter('sentryNotAuth', function() {

        if (Sentry::getUser()) {
            return Redirect::route('index');
        }
    });

Route::get('/', ['as' => 'index', 'uses' => 'MainController@index']);

Route::get('/markuptest', ['as' => 'markuptest', 'uses' => 'MarkupTestController@index']);
Route::get('/markuptest/email', ['as' => 'markuptest_email', 'uses' => 'MarkupTestController@sendEmail']);
Route::get('/markuptest/client_info', ['as' => 'markuptest_client_info', 'uses' => 'MarkupTestController@clientInfo']);
Route::get('/markuptest/editor', ['as' => 'markuptest_editor', 'uses' => 'MarkupTestController@editor']);


// Wiki
Route::group(['prefix' => 'wiki'], function() {

    // TODO : page/show/{page} 라우팅 처럼 길게 만들필요 없이 그냥 '/' 를 각 페이지로 연결하고, 위키 메인에 대한 route를 '/main' 이런식으로 하면 더 깔끔할듯

    Route::get('/', ['as' => 'wiki', 'uses' => 'WikiController@index']);

    Route::get('page/search', ['as' => 'wiki.page.search', 'uses' => 'WikiPageController@search']);
    Route::get('page/recent', ['as' => 'wiki.page.recent', 'uses' => 'WikiPageController@recent']);
    Route::get('page/history/{title}', ['as' => 'wiki.page.history', 'uses' => 'WikiPageController@history']);
    Route::get('page/old/{id}', ['as' => 'wiki.page.old', 'uses' => 'WikiPageController@old']);
    Route::get('page/show/{page}', ['as' => 'wiki.page.show', 'uses' => 'WikiPageController@show']);    // 'search', 'recent' 등 라우팅에 사용되는 문자열과 문서제목간의 충돌을 없애기 위해 show 라우팅을 재정의
    Route::resource('page', 'WikiPageController', ['except' => ['show']]);
});

// User
Route::group(['prefix' => 'user'], function() {

        // TODO : register, login, reset password(reset code 왔다갔다 하는곳) 에 https 적용 (걍 user 그룹엔 다 적용하는것 고려)

        Route::group(['before' => 'sentryAuth'], function() {
                Route::get('/', ['as' => 'user', function() { return Redirect::route('user_profile');}]);
                Route::get('/profile', ['as' => 'user_profile', 'uses' => 'UserController@profile']);
                Route::get('/profile/edit', ['as' => 'user_profile_edit', 'uses' => 'UserController@profileEdit']);
                Route::get('/logout', ['as' => 'user_logout', 'uses' => 'UserController@logout']);
                Route::get('/delete', ['as' => 'user_delete', 'uses' => 'UserController@delete']);
                Route::get('/delete_confirm', ['as' => 'user_delete_confirm', 'uses' => 'UserController@deleteConfirm']);
                Route::get('/password_edit', ['as' => 'user_password_edit', 'uses' => 'UserController@passwordEdit']);

                Route::post('/profile/edit', ['as' => 'user_profile_edit_post', 'uses' => 'UserController@profileEditPost']);
                Route::post('/password_edit', ['as' => 'user_password_edit_post', 'uses' => 'UserController@passwordEditPost']);
            });

        Route::group(['before' => 'sentryNotAuth'], function() {
                Route::get('/register', ['as' => 'user_register', 'uses' => 'UserController@register']);
                Route::get('/welcome', ['as' => 'user_welcome', 'uses' => 'UserController@welcome']);
                Route::get('/activate/{activationCode}', ['as' => 'user_activate', 'uses' => 'UserController@activate']);
                Route::get('/login', ['as' => 'user_login', 'uses' => 'UserController@login']);
                Route::get('/forgot_password', ['as' => 'user_forgot_password', 'uses' => 'UserController@forgotPassword']);
                Route::get('/password_reset/{payload}', ['as' => 'user_password_reset', 'uses' => 'UserController@passwordReset']);


                Route::post('/register', ['as' => 'user_register_post', 'uses' => 'UserController@registerPost']);
                Route::post('/login', ['as' => 'user_login_post', 'uses' => 'UserController@loginPost']);
                Route::post('/forgot_password', ['as' => 'user_forgot_password_post', 'uses' => 'UserController@forgotPasswordPost']);
                Route::post('/password_reset', ['as' => 'user_password_reset_post', 'uses' => 'UserController@passwordResetPost']);
            });
    });


// APIs
// TODO : ckeditor file upload
Route::post('ckeditor/fileUpload', [
    'as' => 'ckeditor.fileUpload',
    'uses' => 'CKEditorController@fileUpload'
]);
