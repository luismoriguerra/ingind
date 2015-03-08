<?php

class LanguageController extends BaseController {	
    public function __construct()
    {
        $this->beforeFilter('auth');
    }

    public function getIdioma()
    {
        Session::set('language', Input::get('language'));
        Session::set('language_id', Input::get('language_id'));
        return Redirect::back();
    }
}