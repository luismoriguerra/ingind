<?php

class AuthController extends \BaseController {

    public function getLogin() {
        if(Auth::user()) {
            return Redirect::route('chat.index');
        }

        return View::make('templates/login');
    }

    public function postLogin() {
        $input = Input::only(array(
            'usuario',
            'password'
        ));

        $rules = array(
            'usuario'    => 'required|numeric',
            'password' => 'required|min:6'
        );

        $validator = Validator::make($input, $rules);

        if($validator->fails()) {
            return Redirect::route('auth.postLogin')->withErrors($validator);
        }

        if(Auth::attempt(['dni' => Input::get('usuario'), 'password' => Input::get('password')], false)) {
            return Redirect::route('chat.index');
        }
    }

    public function logout() {
        Auth::logout();
        Session::flush();
        return Redirect::to('/');
    }

}
