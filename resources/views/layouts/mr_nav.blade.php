<nav class="navbar navbar-expand-md navbar-light shadow-sm mr-bg-muted-blue">
  <div class="container">

    <a class="navbar-brand" href="{{ url('/') }}">
      {{ \App\Http\Controllers\Helpers\MrBaseHelper::MR_SITE_NAME }}
    </a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Right Side Of Navbar -->
      <ul class="navbar-nav ml-auto">
        <!-- Authentication Links -->
        <li class="nav-item">
          <a class="nav-link" href="/references">{{ __('mr-t.Справочники') }}</a>
        </li>
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
            <a class="dropdown-item" href="{{ route('office') }}">
              Кабинет USER
            </a>
            <a class="dropdown-item" href="/clear">
              Очистить кэш
            </a>
            @else
            <a class="dropdown-item" href="{{ route('office') }}">
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
              <i class="nav-item  fa fa-language"></i> {{ $item->getName(). ' - '. $item->getDescription() }}</a>
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