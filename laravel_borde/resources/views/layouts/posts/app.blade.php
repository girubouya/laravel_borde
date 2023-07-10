<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite(['resources/sass/app.scss','resources/js/app.js'])

  </head>

    <body>
        <header class="p-3  text-end">
            <p class="fw-bold fs-5">login:{{$loginUser['name']}}</p>
        </header>

        <div class="container">
            <main>
                <h1 class="fw-bold text-danger text-center">掲示板サイト</h1>
                @yield('content')
            </main>
        </div>
    </body>
</html>
