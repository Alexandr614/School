<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Site</title>
  <link rel="stylesheet" href="{{ asset('assets/css/uikit.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/uikit-rtl.css') }}">
</head>
<body>
<div id="app">
  <app></app>
  <main style="margin-top: 20px;">
    <div class="uk-container">
      <router-view></router-view>
    </div>
  </main>
</div>
<script src="{{ asset('assets/js/uikit.js') }}"></script>
<script src="{{ asset('assets/js/uikit-icons.js') }}"></script>
<script src="/js/app.js"></script>
</body>
</html>
