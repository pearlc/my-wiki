<?php

class MarkupTestController extends BaseController
{
    public function index()
    {

        return View::make('markuptest.index', array('title' => 'Title::테스트'));
//        return View::make('markuptest.main')->with('title', '사용자 등록')->with('class', 'register');
    }

    public function sendEmail()
    {
        $user = Sentry::getUser();

        if ($user) {

            Mail::send('emails.test', array(), function($message) use ($user)
                {
                    $message->to($user->email)->subject('테스트 메일입니다');
                });

            return '메일 발송됨';
        }

        echo '로그인 필요';
    }

    public function clientInfo()
    {
        print_r($_SERVER);
        return '';
    }

    public function editor()
    {
        return View::make('markuptest.editor', array('title' => 'CKeditor 테스트'));
    }
}