<!DOCTYPE html>
<html>
  <head>
    <title>@yield('title', 'Sample App') - Laravel 入门教程</title>
    <link rel="stylesheet" href="/css/app.css">
  </head>
  <body>
    @include('layout._header')

    <div class="container">
      @yield('content')
      @include('layout._footer')
    </div>    
  </body>
</html>