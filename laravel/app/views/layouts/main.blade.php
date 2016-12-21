<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Chat</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="lib/bootstrap-3.3.1/css/bootstrap.min.css">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/chat.css')}}">
        
    </head>
    <body>
        @yield('body')
    </body>

    {{ HTML::script('lib/cloudflare/ajax-google-1.11.0.js') }}
    {{ HTML::script('lib/bootstrap-3.3.1/js/bootstrap.min.js') }}
    {{ HTML::script('lib/socket/socket1.2.js') }}
    {{ HTML::script('lib/cloudflare/cloudflare-vue-1.0.24.js') }}
    {{ HTML::script('lib/cloudflare/cloudflare-vue-0.7.2.js') }}
    @yield('scripts')
</html>