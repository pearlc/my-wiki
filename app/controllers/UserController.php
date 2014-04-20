<?php
/**
 * User: rchung
 * Date: 2014. 4. 19.
 * Time: 오후 8:14
 */

class UserController extends BaseController
{
    public function register()
    {
echo 'im in user controller';

//        ini_set('display_errors', 1);

        if (Sentry::check()) {
//            Redirect::to('/user/profile');
        }

        return View::make('user.register')->with('title', '사용자 등록')->with('class', 'register');
    }
}