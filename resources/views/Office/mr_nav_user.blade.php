<nav class="navbar navbar-expand-md navbar-light shadow-sm mr-bg-muted-blue">
  <div class="container">

    <a class="navbar-brand" href="{{ url('/') }}">
      {{ \App\Http\Controllers\Helpers\MrBaseHelper::MR_SITE_NAME }}
    </a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">


        <li class="nav-item">
          <a class="nav-link" href="{{ route('office_personal_page') }}">{{ __('mr-t.Персональные') }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('office_monitoring_page') }}">{{ __('mr-t.Мониторинг') }}</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('office_settings_page') }}">{{ __('mr-t.Настройки') }}</a>
        </li>

        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
             data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ __('mr-t.Справочники') }} <span class="caret"></span>
          </a>
          <a class="dropdown-menu padding-horizontal" href="/reference/country">{{ __('mr-t.Страны мира') }}</a>
        </li>

        @if(\App\Http\Models\MrUser::me()->IsAdmin())
          <li class="nav-item">
            <a class="nav-link" href="/office">Офис</a>
          </li>
        @endif

        <li class="nav-item">
          <a class="nav-link" href="/faq">FAQ</a>
        </li>

        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
             data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            {{ mb_strtoupper(app()->getLocale()) }} <span class="caret"></span>
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