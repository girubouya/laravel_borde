<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite(['resources/sass/app.scss','resources/js/app.js'])

  </head>

    <div class="container">
        <header class="text-center p-3">
            <h1 class="fw-bold text-danger">いろいろな掲示板サイト</h1>
        </header>
        <body>
            @yield('content')
        </body>
    </div>
</html>
