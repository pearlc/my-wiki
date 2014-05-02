<?php
/**
 * User: rchung
 * Date: 2014. 4. 19.
 * Time: 오후 8:14
 */

class UserController extends BaseController
{
    public function profile()
    {
        return 'profile';
    }

    public function register()
    {

//        if (Sentry::check()) {
//            Redirect::to('/user/profile');
//        }

        return View::make('user.register')->with('title', '사용자 등록')->with('class', 'register');
    }
}