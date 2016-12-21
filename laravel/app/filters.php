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
Route::filter('authChat', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('loginchat');
		}
	}
});

Route::filter('auth.basic', function()
{
	return Auth::basic("username");
});

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

Route::filter(
    'csrf', 
    function() {
        if (App::environment()=="testing" || App::environment()=="txt") {
            return;    /*development*/
        }
        // if ( !Request::is('admin/*')) {}
        if (Request::ajax()) {
            //echo Session::token()." | ".Input::get('token');
            if (Session::token()!==Input::get('token') AND Session::token() !== Request::header('csrftoken')) {
                return Response::json(false, 401); 
                throw new Illuminate\Session\TokenMismatchException;
            }
        } elseif (Session::token() !== Input::get('_token')) {
            /*Input::get('token')*/
            throw new Illuminate\Session\TokenMismatchException;
        }
    }
);

Route::filter('cumpleanios', function(){
	if(date("d/m")=="16/12"){
		return "Feliz Cumpleaños";
	}
});

?>