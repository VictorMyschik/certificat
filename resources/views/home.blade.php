@extends('layouts.app')

@section('content')
<div class="mr-bg-img">
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

					<li class="nav-item dropdown border mr-border-radius-5">
						<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
							 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><span class="mr-color-white">
								{{ mb_strtoupper(app()->getLocale()) }} <span class="caret"></span></span>
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
	<div class="container padding-t-20">
		<div>
			<h1 class="mr-bold">Работаете с сертификатами?</h1>

			<h3 class="mr-bold">On-line</h3>

			<h4 class="mr-bold">Библиотека актуальных декларации о соответствии</h4>
			<div class="row">
					<div class="col-md-6 margin-t-20">
						{{ Form::open(['name'=>'blog','method' => 'POST', 'files' => false]) }}
						@csrf
						<div class="input-group col-md-12">
							<input class="form-control py-2 mr-bg-index-form"
										 name='search' value=''
										 id="search" required
										 type="search" placeholder="{{ __('mr-t.Поиск сертификата') }}">
						</div>
						{!! Form::close() !!}
						<ul id="resSearch" class="margin-t-10 col-md-12"></ul>
						<script type="text/javascript">
                $(function () {
                    $("#search").keyup(function () {
                        var search = $("#search").val();
                        $.ajax({
                            type: "POST",
                            url: "/search",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: {"search": search},
                            cache: false,
                            success: function (response) {
                                let text_out = '';
                                for (let key in response) {
                                    text_out += '<div class="mr-bg-founded padding-horizontal border border-dark mr-border-radius-5 "><a class="mr-color-dark-blue" href="/certificate/' + key + '">' + response[key] + '</div>';
                                }
                                $("#resSearch").html(text_out);
                            }
                        });
                        return false;

                    })
                })

						</script>
					</div>
			</div>
		</div>
	</div>
</div>
@endsection

