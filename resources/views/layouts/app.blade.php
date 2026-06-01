<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Garage 62')</title>
  <link rel="stylesheet" type="text/css" href="{{ asset('style.min.css') }}">
  <link rel="icon" type="image/x-icon" href="{{ asset('images/62.png') }}">
</head>
<body>
  @include('partials.header')

  <main class="@yield('mainClass', 'container')">
    @yield('content')
  </main>

  @hasSection('footer')
    @yield('footer')
  @else
    @include('partials.footer')
  @endif

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
  <script src="{{ asset('main.min.js') }}"></script>
</body>
</html>
