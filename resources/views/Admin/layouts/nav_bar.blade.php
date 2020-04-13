<nav class="navbar navbar-expand-md navbar-light shadow-sm mr-bg-muted-blue">
  <div class="container">

    <a class="navbar-brand" href="{{ url('/') }}">
      {{ MrBaseHelper::MR_SITE_NAME }}
    </a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Right Side Of Navbar -->
      <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
             data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Справочники<span class="caret"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{route('admin_country_page')}}">Страны мира</a>
            <a class="dropdown-item" href="{{route('admin_currency_page')}}">Валюты мира</a>
          </div>
        </li>

        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
             data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Офисы<span class="caret"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/admin/offices">Офисы</a>
          </div>
        </li>

        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
             data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Сертификаты<span class="caret"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/admin/certificate">Сертификаты</a>
            <a class="dropdown-item" href="/admin/certificate/communicate">Связь</a>
            <a class="dropdown-item" href="/admin/certificate/manufacturer">Производители</a>
            <a class="dropdown-item" href="/admin/certificate/address">Адреса</a>
          </div>
        </li>

        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
             data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Сайт<span class="caret"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{route('admin_users')}}">Пользователи</a>
            <a class="dropdown-item" href="{{route('admin_language_list')}}">Переводчик</a>
            <a class="dropdown-item" href="{{route('admin_faq_page')}}">FAQ</a>
            <a class="dropdown-item" href="{{route('admin_feedback_list')}}">Обратная связь</a>
            <a class="dropdown-item" href="{{route('admin_article_page')}}">Статьи</a>
            <a class="dropdown-item" href="{{route('admin_subscription')}}">Подписка</a>
            <a class="dropdown-item" href="{{route('admin_emails_page')}}">Почта</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
             data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Системные<span class="caret"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{route('clear')}}">Очистить кэш</a>
            <a class="dropdown-item m-b-15" target="_blank" href="/phpmyadmin">PhpMyAdmin</a>

            <a class="dropdown-item" href="{{route('admin_logs')}}">Лог посещений</a>
            <a class="dropdown-item" href="{{route('admin_db_log_page') }}">Лог БД</a>
            <a class="dropdown-item" href="{{route('admin_backup_page')}}">BACK UP</a>
            <a class="dropdown-item" href="{{route('admin_page')}}">Нагрузка</a>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('logout') }}"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST"
                style="display: none;">
            @csrf
          </form>
        </li>
        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle border mr-border-radius-5" href="#" role="button"
             data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            {{ mb_strtoupper(app()->getLocale()) }}<span class="caret"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            @foreach(\App\Models\MrLanguage::GetAll() as $item)
              @if($item->getName() == mb_strtoupper(app()->getLocale()))
                @continue
              @endif
              <a href="{{ url('/locale/'.mb_strtolower($item->getName())) }}" class="dropdown-item">
                <i class="nav-item fa fa-language"></i> {{ $item->getName(). ' - '. $item->getDescription() }}</a>
            @endforeach
          </div>
        </li>
      </ul>
    </div>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="{{ __('Toggle navigation') }}">
      <span class="navbar-toggler-icon"></span>
    </button>

  </div>
</nav>