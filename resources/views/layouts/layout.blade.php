<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Image Gallery</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="flex-center position-ref">
            <div class="content">
                <div class="title m-b-md">
                    Image Gallery
                </div>

                <div class="links">
                    <a href="/images">Upload Images</a>
                    <a href="/view">View Gallery</a>
                </div>

                <hr />

                @yield('content')
            </div>
        </div>
    </body>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
</html>
