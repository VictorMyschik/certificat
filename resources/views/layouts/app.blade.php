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
  <link rel="shortcut icon" href="/public/images/other/favicon.ico">
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
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href='/public/css/mr-style.css' rel="stylesheet">
</head>
<body class="mr-img-background">
<div class="mr-base-border">
  <nav class="navbar navbar-expand-md navbar-light mr-bg mr-bg-footer shadow-sm">
    <div class="container">

      <a class="navbar-brand" href="{{ url('/') }}">
        {{ \App\Http\Controllers\Helpers\MrBaseHelper::MR_SITE_NAME }}
      </a>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
          <!-- Authentication Links -->
          <li class="nav-item">
            <a class="nav-link" href="/faq">FAQ</a>
          </li>


          @guest
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
              <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
              </li>
            @endif
          @else
            <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }} <span class="caret"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">


                @if(\App\Models\MrUser::me()->IsAdmin())
                  <a class="dropdown-item" href="{{ route('admin') }}">
                    Админка
                  </a>
                  <a class="dropdown-item" href="/phpmyadmin">
                    PhpMyAdmin
                  </a>
                  <a class="dropdown-item" href="{{ route('panel') }}">
                    Кабинет USER
                  </a>
                  <a class="dropdown-item" href="/clear">
                    Очистить кэш
                  </a>
                @else
                  <a class="dropdown-item" href="{{ route('panel') }}">
                    Кабинет
                  </a>
                @endif
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                  {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                      style="display: none;">
                  @csrf
                </form>
              </div>
            </li>
          @endguest
        </ul>
      </div>

      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
             data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            {{ mb_strtoupper(app()->getLocale()) }} <span class="caret"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            @foreach(\App\Models\MrLanguage::GetAll() as $item)
              @if($item->getName() == mb_strtoupper(app()->getLocale()))
                @continue
              @endif
              <a href="{{ url('/locale/'.mb_strtolower($item->getName())) }}" class="dropdown-item">
                <i class="fa fa-language"></i> {{ $item->getName() }}</a>
            @endforeach
          </div>
        </li>
      </ul>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent" aria-expanded="false"
              aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
      </button>

    </div>
  </nav>
  @yield('content')
</div>
<div class="mr-bg-footer">
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
    <script>
      let script = document.createElement('script');
      script.src = "https://cardbox.ml/public/js/api/mr_c.js";
      document.head.append(script);
    </script><div id="contacts"></div>
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
