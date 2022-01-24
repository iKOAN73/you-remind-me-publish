<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      font-family: 'Nunito', sans-serif;
    }

  </style>

  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

  <script src=" {{ mix('js/app.js') }} "></script>
  <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

  <title>You Remind Me | リマインダー体験</title>

</head>

<body class="text-center text-white bg-dark d-flex h-100">
  <div class="d-flex w-100 mx-auto flex-column">
    <div class="sticky-top bg-dark">
      <header class="mb-auto container">
        <div>
          <h3 class="mb-0 float-md-start mb-2">You Remind Me</h3>
          <nav class="nav container text-center nav-masthead justify-content-center float-md-end">
            @if (Session::get('iid') == 'qwertyuiiop')

              <a class="nav-link text-white-50 rem-font" href="/">Reminder</a>
              <a class="nav-link text-white-50 rem-font" href="/AdminEditor">AdminEditor</a>
              <a class="nav-link text-white-50 rem-font" href="/InstantUser">User</a>
              <a class="nav-link text-white-50 rem-font" href="/UserList">UserList</a>
              <a class="nav-link text-white-50 rem-font" href="/ResetSession">ResetSession</a>
            @else
              <a class="nav-link text-white-50 navrem" href="/">仕事場</a>
              <a class="nav-link text-white-50 navrem" href="/InstantUser">アナタの情報</a>
              <a class="nav-link text-white-50 navrem" href="/ResetSession">最初からやり直す</a>
            @endif
            <x-user-info-btn class="navrem"/>
          </nav>
        </div>
        <p>{{ Session::get('message') }}</p>
      </header>
    </div>

    <div class="container my-auto mycontainer">
      <x-user-info />
      {{ $slot }}
    </div>


    <footer class="mt-auto text-white-50">
      <p> <a href="https://github.com/iKOAN73/you_remind_me" class="text-white">You Remind Me</a>, by <a
          href="https://github.com/iKOAN73" class="text-white">@iKOAN73</a>.</p>
    </footer>
  </div>
  <script src="{{ mix('/js/app.js') }}" defer></script>


  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
  </script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>

</body>

</html>
