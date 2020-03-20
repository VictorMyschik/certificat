<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--<link rel="shortcut icon" href="/public/images/other/favicon.ico">-->
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $page_title ?? MrBaseHelper::MR_SITE_NAME }}</title>

  <!-- Scripts -->
  <script src="//cdn.ckeditor.com/4.11.3/full/ckeditor.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript" defer rel="script" src="{{asset('js/app.js')}}"></script>
  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href='/public/css/mr-style.css' rel="stylesheet">
</head>

<body class="mr-base-bg">
<div id="app" style="height: 90vh; min-height: 90vh;">
  @yield('content')
</div>
<div class="mr-bg-muted-blue">
  <div class="container col-md-8 mr-middle">
    <div class="padding-t-15">

      <div class="d-inline-block align-top">
        <span class="mr-bold">{{ __('mr-t.Обратная связь') }}</span>
        <table>
          <tr>
            <td class="fa fa-phone"> {{ __('mr-t.Телефон') }}:</td>
            <td><a href="tel:{{ MrBaseHelper::ADMIN_PHONE }}"
                   class="margin-l-5">{{ MrBaseHelper::ADMIN_PHONE_FORMAT }}</a></td>
          </tr>
          <tr>
            <td class="fa fa-envelope"> Email:</td>
            <td><a href="mailto:{{ MrBaseHelper::MR_EMAIL }}" class="margin-l-5">{{ MrBaseHelper::MR_EMAIL }}</a></td>
          </tr>
          <tr>
            <td class="fa fa-link"> {{ __('mr-t.Веб сайт') }}:</td>
            <td><a href="{{ MrBaseHelper::MR_SITE_URL }}"
                   class="margin-l-5">{{ MrBaseHelper::MR_SITE_NAME }}</a></td>
          </tr>
        </table>
      </div>

      <div class="d-inline-block align-top margin-l-10">
        <span class="mr-bold">{{ __('mr-t.Разделы сайта') }}</span>
        <li><a class="/faq" href="{{ route('faq_page') }}">FAQ</a></li>
        <li><a class="/policy" href="{{ route('policy_page') }}">{{ __('mr-t.Политика приватности') }}</a></li>
      </div>
      <div class="d-inline-block align-top margin-l-10">
      </div>
    </div>

    <div class="text-center mr-middle mr-color-seryj">Copyright {{ date('Y') }}</div>

  </div>
</div>
<div class="modal fade padding-0" id="mr_modal" role="dialog"></div>
<script src="/public/js/mr_popup.js"></script>
<script src="/public/js/mr_elfinder.js" defer></script>
</body>
</html>
