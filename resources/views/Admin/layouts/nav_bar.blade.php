<nav class="navbar navbar-expand-md navbar-light shadow-sm mr-bg-muted-blue">
  <div class="container">

    <a class="navbar-brand" href="{{ url('/') }}">
      {{ \App\Http\Controllers\Helpers\MrBaseHelper::MR_SITE_NAME }}
    </a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Right Side Of Navbar -->
      <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
             data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Проект<span class="caret"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/admin/tariffs">Тарифы</a>
            <a class="dropdown-item" href="/admin/offices">Офисы</a>
            <a class="dropdown-item" href="/admin/certificate">Сертификаты</a>
            <a class="dropdown-item" href="/admin/reference/country">Страны мира</a>
            <a class="dropdown-item" href="/admin/reference/currency">Валюты мира</a>
          </div>
        </li>

        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
             data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Сайт<span class="caret"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/admin/users">Пользователи</a>
            <a class="dropdown-item" href="/admin/language">Переводчик</a>
            <a class="dropdown-item" href="/admin/faq">FAQ</a>
            <a class="dropdown-item" href="/admin/feedback">Обратная связь</a>
            <a class="dropdown-item" href="/admin/articles">Статьи</a>
            <a class="dropdown-item" href="/admin/subscription">Подписка</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
             data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Системные<span class="caret"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/admin/hardware">Лог посещений</a>
            <a class="dropdown-item" href="/admin/hardware/bot">Bot фильтр</a>
            <a class="dropdown-item" href="/admin/hardware/dblog">Лог БД</a>
            <a class="dropdown-item" href="/admin/hardware/backup">BACK UP</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/clear"> Очистить кэш</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/phpmyadmin" target="_blank"> PhpMyAdmin</a>
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
      </ul>
    </div>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="{{ __('Toggle navigation') }}">
      <span class="navbar-toggler-icon"></span>
    </button>

  </div>
</nav>