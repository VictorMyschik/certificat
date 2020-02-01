<nav class="navbar navbar-expand-md navbar-light shadow-sm mr-bg-muted-blue">
  <div class="container">
    @php
      use App\Http\Models\MrUser;
      $user = MrUser::me();
      $offices = array();
      if($user)
      {
        $offices = $user->GetUserOffices();
        $default_office = $user->getDefaultOffice();
      }
    @endphp

    <a class="navbar-brand" href="{{ url('/') }}">
      {{MrBaseHelper::MR_SITE_NAME}}
    </a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        @if(count($offices))
          <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="mr-color-white">Офисы</span><span class="caret"></span>
            </a>
            @foreach($offices as $office)
              <a class="dropdown-menu padding-horizontal"
                 href="{{route('office_page',['office_id'=>$office->id()])}}">{{ $office->getName() }}</a>
            @endforeach
          </li>
        @else
          <li class="nav-item">
            {!! MrBtn::loadForm('admin_office_edit', 'Admin\\MrAdminOfficeEditForm', ['id'=>'0'], 'Создать пустой офис', ['btn btn-primary btn-xs']) !!}
          </li>
        @endif
        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
             data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-color-white">{{ __('mr-t.Справочники') }}</span><span class="caret"></span>
          </a>
          <a class="dropdown-menu padding-horizontal" href="/reference/country">{{ __('mr-t.Страны мира') }}</a>
        </li>

        @guest
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}"><span class="mr-color-white">{{ __('Login') }}</span></a>
          </li>
          @if (Route::has('register'))
            <li class="nav-item">
              <a class="nav-link" href="{{ route('register') }}"><span
                    class="mr-color-white">{{ __('Register') }}</span></a>
            </li>
          @endif
        @else
          <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><span class="mr-color-white">
								{{ Auth::user()->name }} <span class="caret"></span></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              @if(MrUser::me()->IsSuperAdmin())
                <a class="nav-link" href="{{ route('admin') }}">
                  Админка
                </a>
                <a class="nav-link" href="/phpmyadmin">
                  PhpMyAdmin
                </a>
                <a class="nav-link" href="/clear">
                  Очистить кэш
                </a>
              @endif
              @if(isset($default_office))
                <a class="nav-link"
                   href="{{route('office_settings_page',['office_id'=>$default_office->id()])}}">{{ __('mr-t.Настройки') }}</a>
              @endif
              <a class="nav-link" href="{{ route('logout') }}"
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
      </ul>
    </div>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="{{ __('Toggle navigation') }}">
      <span class="navbar-toggler-icon"></span>
    </button>

  </div>
</nav>