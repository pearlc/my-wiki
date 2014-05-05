<?php
/**
 * User: rchung
 * Date: 2014. 5. 2.
 * Time: 오후 8:21
 */

class WikiController extends BaseController{

    public function index()
    {
        // 위키 메인

        return View::make('wiki.index');
    }
} 