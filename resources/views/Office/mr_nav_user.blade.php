<nav class="navbar navbar-expand-md navbar-light shadow-sm mr-bg-muted-blue">
  <div class="container">

    <a class="navbar-brand" href="{{ url('/') }}">
      {{ \App\Http\Models\MrUser::me()->getDefaultOffice()->getName() }}
    </a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">

        <li class="nav-item">
          <a class="nav-link mr-bold" href="{{ route('office_page') }}"><span
                class="mr-color-white">{{ __('mr-t.Мой офис') }}</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('office_finance_page') }}"><span
                class="mr-color-white">{{ __('mr-t.Финансы') }}</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('office_settings_page') }}"><span
                class="mr-color-white">{{ __('mr-t.Настройки') }}</span></a>
        </li>

        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
             data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-color-white">{{ __('mr-t.Справочники') }}</span><span class="caret"></span>
          </a>
          <a class="dropdown-menu padding-horizontal" href="/reference/country">{{ __('mr-t.Страны мира') }}</a>
        </li>

        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
             data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            <span class="mr-color-white">{{ mb_strtoupper(app()->getLocale()) }}</span> <span class="caret"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            @foreach(\App\Http\Models\MrLanguage::GetAll() as $item)
              @if($item->getName() == mb_strtoupper(app()->getLocale()))
                @continue
              @endif
              <a href="{{ url('/locale/'.mb_strtolower($item->getName())) }}" class="dropdown-item">
                <i class="nav-item  fa fa-language"></i> {{ $item->getName(). ' - '. $item->getDescription() }}</a>
            @endforeach
          </div>
        </li>

        @if(\App\Http\Models\MrUser::me()->IsAdmin())
          <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              <span class="mr-color-white">{{ \App\Http\Models\MrUser::me()->getName() }}</span> <span
                  class="caret"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <a class="nav-link" href="{{ route('admin') }}">
                Админка
              </a>
              <a class="nav-link" href="/phpmyadmin">
                PhpMyAdmin
              </a>
              <a class="nav-link" href="/clear">
                Очистить кэш
              </a>
            </div>
          </li>
        @endif

        <li class="nav-item dropdown">
          <a class="nav-link" href="{{ route('logout') }}"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span class="mr-color-white">{{ __('Logout') }}</span>
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