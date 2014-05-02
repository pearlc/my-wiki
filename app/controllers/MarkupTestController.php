<?php

class MarkupTestController extends BaseController
{
    public function main($spec = 'main')
    {

        return View::make('markuptest.' . $spec)->with('title', '사용자 등록');
//        return View::make('markuptest.main')->with('title', '사용자 등록')->with('class', 'register');
    }
}