<?php

class MarkupTestController extends BaseController
{
    public function index($spec = 'index')
    {

        return View::make('markuptest.' . $spec)->with('title', '사용자 등록');
//        return View::make('markuptest.main')->with('title', '사용자 등록')->with('class', 'register');
    }
}