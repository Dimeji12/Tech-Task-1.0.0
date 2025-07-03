<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>Full Stack Tech Test</title>
        <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        <div id="app">
            <edit-book :book='@json($book)'></edit-book>
        </div>

        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
