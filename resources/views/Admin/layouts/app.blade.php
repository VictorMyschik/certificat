<aside id="left-panel" class="left-panel">
  <nav class="navbar navbar-expand-sm navbar-default">

    <div class="navbar-header">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu"
              aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-bars"></i>
      </button>
      <a class="navbar-brand" href="/"><img src="/public/images/Admin/admin_lable.png" alt="Logo"></a>
    </div>

    <div id="main-menu" class="main-menu collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="/admin"> <i class="menu-icon fa fa-dashboard"></i>Главная</a></li>
        <h3 class="menu-title">Категории</h3>

        <li><a href="/admin/language"><i class="fa fa-language"></i> Переводчик</a></li>
        <li><a href="/admin/users"><i class="fa fa-user"></i> Пользователи</a></li>
        <li><a href="/admin/tariffs"><i class="fa fa-users"></i> тарифы</a></li>
        <li><a href="/admin/offeces"><i class="fa fa-users"></i> Офисы</a></li>
        <li><a href="/admin/certificate"><i class="fa fa-dot-circle-o"></i> Сертификаты</a></li>

        <li class="menu-item-has-children dropdown">
          <a href="/admin/pudlic" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
             aria-expanded="false"> <i class="menu-icon fa fa-book"></i>Разделы сайта</a>
          <ul class="sub-menu children dropdown-menu">
            <li><i class="fa fa-list"></i><a href="/admin/faq">FAQ</a></li>
            <li><i class="fa fa-list"></i><a href="/admin/feedback">Обратная связь</a></li>
            <li><i class="fa fa-list"></i><a href="/admin/policy">Policy</a></li>
          </ul>
        </li>

        <li class="menu-item-has-children dropdown">
          <a href="/admin/pudlic" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
             aria-expanded="false"> <i class="menu-icon fa fa-comments-o"></i>Интерактив</a>
          <ul class="sub-menu children dropdown-menu">
            <li><i class="fa fa-list"></i><a href="/admin/subscription">Подписка</a></li>
          </ul>
        </li>

        <li class="menu-item-has-children dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="menu-icon fa fa-wrench"></i>Сиситемные</a>
          <ul class="sub-menu children dropdown-menu">
            <li><i class="fa fa-tachometer"></i><a href="/admin/hardware">Лог посещений</a></li>
            <li><i class="fa fa-tachometer"></i><a href="/admin/hardware/bot">Bot фильтр</a></li>
            <li><i class="fa fa-tachometer"></i><a href="/admin/hardware/dblog">Лог БД</a></li>
          </ul>
        </li>

        <li class="menu-item-has-children dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="menu-icon fa fa-book"></i>Справочники</a>
          <ul class="sub-menu children dropdown-menu">
            <li><i class="fa fa-tachometer"></i><a href="/admin/reference/country">Страны мира</a></li>
          </ul>
        </li>

        <li class="margin-t-20">
          <a class="dropdown-item" href="/clear"> Очистить кэш</a>
        </li>
        <li>
          <a class="dropdown-item" href="/phpmyadmin" target="_blank"> PhpMyAdmin</a>
        </li>

        <li>
          <a class="dropdown-item" href="{{ route('logout') }}"
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
  </nav>
</aside>

@yield('content')

<div class="modal fade" id="mr_modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>

<script>
    function mr_popup(url) {
        $("#mr_modal").modal("show").find('.modal-body').load(url);
    }
</script>
