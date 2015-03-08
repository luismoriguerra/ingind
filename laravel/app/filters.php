<?php

App::before(function($request)
{
	Lang::setLocale( Session::get('language_id') );
});


App::after(function($request, $response)
{
	//
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('/');
});


Route::filter('auth.basic', function()
{
	return Auth::basic("username");
});

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

Route::filter('csrf', function()
{
	if (Session::token() !== Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

Route::filter('cumpleanios', function(){
	if(date("d/m")=="16/12"){
		return "Feliz Cumpleaños";
	}
});

?>