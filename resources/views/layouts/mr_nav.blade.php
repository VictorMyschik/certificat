<nav class="navbar navbar-expand-md navbar-light shadow-sm mr-bg-muted-blue">
  <div class="container">

    <a class="navbar-brand" href="{{ url('/') }}">
      <span class="mr-color-white">{{ \App\Http\Controllers\Helpers\MrBaseHelper::MR_SITE_NAME }}</span>
    </a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Right Side Of Navbar -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="/references"><span class="mr-color-white">{{ __('mr-t.Справочники') }}</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/faq"><span class="mr-color-white">FAQ</span></a>
        </li>

        @guest
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}"><span class="mr-color-white">{{ __('Login') }}</span></a>
          </li>
          @if (Route::has('register'))
            <li class="nav-item">
              <a class="nav-link" href="{{ route('register') }}"><span class="mr-color-white">{{ __('Register') }}</span></a>
            </li>
          @endif
        @else
          <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><span class="mr-color-white">
								{{ Auth::user()->name }} <span class="caret"></span></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">


              @if(\App\Http\Models\MrUser::me()->IsAdmin())
                <a class="dropdown-item" href="{{ route('admin') }}">
                  Админка
                </a>
                <a class="dropdown-item" href="/phpmyadmin">
                  PhpMyAdmin
                </a>
                <a class="dropdown-item" href="{{ route('office_page') }}">
                  Кабинет USER
                </a>
                <a class="dropdown-item" href="/clear">
                  Очистить кэш
                </a>
              @else
                <a class="dropdown-item" href="{{ route('office_page') }}">
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

        <li class="nav-item dropdown border mr-border-radius-5">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
             data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><span class="mr-color-white">
								{{ mb_strtoupper(app()->getLocale()) }} <span class="caret"></span></span>
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
      </ul>
    </div>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="{{ __('Toggle navigation') }}">
      <span class="navbar-toggler-icon"></span>
    </button>

  </div>
</nav>