<nav class="navbar navbar-expand-md navbar-light shadow-sm mr-bg-muted-blue">
  <div class="container">
    @php
      use App\Models\MrUser;
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
        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
             data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-color-white">{{ __('mr-t.Справочники') }}</span><span class="caret"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="nav-link" href="{{route('references',['name'=>'country'])}}">{{ __('mr-t.Страны мира') }}</a>
            <a class="nav-link padding-horizontal"
               href="{{route('references',['name'=>'currency'])}}">{{ __('mr-t.Валюты мира') }}</a>
            <a class="nav-link"
               href="{{route('references',['name'=>'measure'])}}">{{ __('mr-t.Классификатор единиц измерения') }}</a>
            <a class="nav-link" href="{{route('references',['name'=>'certificate_kind'])}}">Классификатор видов
              документов об оценке соответствия</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('faq_page') }}"><span class="mr-color-white">FAQ</span></a>
        </li>
        @guest
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}"><span class="mr-color-white">{{ __('Login') }}</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}"><span class="mr-color-white">{{ __('Register') }}</span></a>
          </li>
        @else
          <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><span class="mr-color-white">
								{{ $user->getDefaultOffice() ? $user->getDefaultOffice()->getName() : $user->getName() }}
                <span class="caret"></span></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              @if(MrUser::me()->IsSuperAdmin())
                <a class="nav-link m-b-10" href="{{ route('admin_page') }}">Админка</a>
              @endif
              @foreach($offices as $office)
                <a class="nav-link" href="{{route('office_page',['office_id'=>$office->id()])}}">{{$office->getName()}}</a>
              @endforeach
                <a class="nav-link" href="#" onclick="mr_popup('{{route('admin_office_edit',['id'=>0])}}');return false;">Создать пустой офис</a>
              @if(isset($default_office) && $default_office->canView())
                <a class="nav-link"
                   href="{{route('office_settings_page',['office_id'=>$default_office->id()])}}">{{ __('mr-t.Настройки') }}</a>
              @endif
              <a class="nav-link m-t-15" href="{{route('personal_page')}}">{{ __('mr-t.Личная страница') }}</a>
              <a class="nav-link m-t-15" href="{{ route('logout') }}"
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            </div>
          </li>
        @endguest

        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
             data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            <span class="mr-color-white">{{ mb_strtoupper(app()->getLocale()) }}</span> <span class="caret"></span>
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