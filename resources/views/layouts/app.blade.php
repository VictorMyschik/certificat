<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-78812020-7"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag()
    {
      dataLayer.push(arguments);
    }

    gtag('js', new Date());
    gtag('config', 'UA-78812020-7');
  </script>
  <meta name="yandex-verification" content="c02716ea9ed7e1d2"/>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--<link rel="shortcut icon" href="/public/images/other/favicon.ico">-->
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ \App\Http\Controllers\Helpers\MrBaseHelper::MR_SITE_NAME }}</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Styles -->
  <link href="/public/css/bootstrap.css" rel="stylesheet">
  <link href='/public/css/mr-style.css' rel="stylesheet">
</head>

<body class="mr-base-bg">
@yield('content')
<div class="mr-bg-muted-blue">
  <div class="container col-md-8 footer mr-middle">
    <div class="padding-t-15">

      <div class="d-inline-block align-top">
        <span class="mr-bold">{{ __('mr-t.Обратная связь') }}</span>
        <table>
          <tr>
            <td class="fa-phone">{{ __('mr-t.Телефон') }}:</td>
            <td class="fa-phone"><a href="tel:+375297896282" class="margin-l-5">+375(29)789-62-82</a></td>
          </tr>
          <tr>
            <td class="fa-envelope">Email:</td>
            <td><a href="mailto:allximik50@gmail.com" class="margin-l-5">allximik50@gmail.com</a></td>
          </tr>
          <tr>
            <td class="fa-link">{{ __('mr-t.Веб сайт') }}:</td>
            <td><a href="{{ \App\Http\Controllers\Helpers\MrBaseHelper::MR_SITE_URL }}"
                   class="margin-l-5">{{ \App\Http\Controllers\Helpers\MrBaseHelper::MR_SITE }}</a></td>
          </tr>
        </table>
      </div>

      <div class="d-inline-block align-top margin-l-10">
        <span class="mr-bold">{{ __('mr-t.Разделы сайта') }}</span>
        <li><a class="/faq" href="/faq">FAQ</a></li>
        <li><a class="/policy" href="/policy">{{ __('mr-t.Политика приватности') }}</a></li>
      </div>
    </div>

    <div class="text-center mr-middle mr-color-seryj">Copyright {{ date('Y') }}</div>

  </div>
</div>
<script>
  function mr_popup(url)
  {
    $("#mr_modal").modal("show").find('.modal-body').load(url);
  }
</script>
</body>
</html>
