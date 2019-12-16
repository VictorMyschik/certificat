<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--<link rel="shortcut icon" href="/public/images/other/favicon.ico">-->
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <title>{{ \App\Http\Controllers\Helpers\MrBaseHelper::MR_SITE_NAME }}</title>

  <!-- Scripts -->
  <script type="text/javascript" rel="script" src="{{asset('js/app.js')}}"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Styles -->
  <link href='/public/css/mr-style.css' rel="stylesheet">
  <link href='/public/css/fontawesome.min.css' rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="mr-base-bg">
<div id="app">
  @yield('content')
</div>
<div class="mr-bg-muted-blue">
  <div class="container col-md-8 footer mr-middle">
    <div class="padding-t-15">

      <div class="d-inline-block align-top">
        <span class="mr-bold">{{ __('mr-t.Обратная связь') }}</span>
        <script src="https://cardbox.ml/public/js/api/mr_c.js"></script>
        <div id="contacts"></div>
        <table>
          <tr>
            <td class="fa fa-phone"> {{ __('mr-t.Телефон') }}:</td>
            <td><a href="tel:+375297896282" class="margin-l-5">+375(29)789-62-82</a></td>
          </tr>
          <tr>
            <td class="fa fa-envelope"> Email:</td>
            <td><a href="mailto:allximik50@gmail.com" class="margin-l-5">allximik50@gmail.com</a></td>
          </tr>
          <tr>
            <td class="fa fa-link"> {{ __('mr-t.Веб сайт') }}:</td>
            <td><a href="{{ \App\Http\Controllers\Helpers\MrBaseHelper::MR_SITE_URL }}"
                   class="margin-l-5">{{ \App\Http\Controllers\Helpers\MrBaseHelper::MR_SITE }}</a></td>
          </tr>
        </table>
      </div>

      <div class="d-inline-block align-top margin-l-10">
        <span class="mr-bold">{{ __('mr-t.Разделы сайта') }}</span>
        <li><a class="/faq" href="/faq">FAQ</a></li>
        <li><a class="/policy" href="/policy">{{ __('mr-t.Политика приватности') }}</a></li>
        <li><a class="/policy" href="/references">{{ __('mr-t.Справочники') }}</a></li>
      </div>
      <div class="d-inline-block align-top margin-l-10">
        <span class="mr-bold">{{ __('mr-t.Услуги') }}</span>
        <li><a class="/faq" href="/api">API</a></li>
        <li><a class="/policy" href="/monitoring">{{ __('mr-t.Мониторинг') }}</a></li>
      </div>
    </div>

    <div class="text-center mr-middle mr-color-seryj">Copyright {{ date('Y') }}</div>

  </div>
</div>
<div class="modal fade padding-0" id="mr_modal" role="dialog"></div>
<script src="/public/js/mr_popup.js"></script>
</body>
</html>
