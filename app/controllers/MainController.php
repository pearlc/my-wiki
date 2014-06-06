<?php
/**
 * User: rchung
 * Date: 2014. 5. 1.
 * Time: 오후 11:59
 */

class MainController extends BaseController
{
    public function index()
    {
        return View::make('index');
    }
}
