@extends('layouts.app')

@section('content')
<style>
	body {
		font-family: Arial;
	}

	/* Style the tab */
	.tab {
		overflow: hidden;: 1 px solid #ccc;
	}

	/* Style the buttons inside the tab */
	.tab button {
		background-color: inherit;
		float: left;: none;
		outline: none;
		cursor: pointer;
		padding: 14px 16px;
		transition: 0.3s;
		font-size: 17px;
	}

</style>

<div class="mr-bg-img">
	<div class="">
		<div class="container padding-t-20">
			<div class="mr-center mr-trans">
				<div class="row padding-t-20">
					<div class="col-md-7 col-sm-12 padding-l-20 ">
						<h2 class="margin-l-20 mr-bold">{{ __('mr-t.Нужна визитка?') }}</h2>
						<h4 class="margin-l-20">{{ __('mr-t.Отправляйте одну ссылку сразу на все контакты') }}</h4>

						<div class="row">
							<div class="col-md-12">
								<div class="col-md-6 margin-t-20">
									{{ Form::open(['name'=>'blog','method' => 'post', 'files' => false]) }}
									@csrf
									<div class="input-group col-md-12">
										<input class="form-control py-2 mr-bg-index-form"
													 name='search' value=''
													 id="search" required
													 type="search" placeholder="Search">
									</div>
									{!! Form::close() !!}
									<ul id="resSearch" class="margin-t-10 col-md-12"></ul>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-5 col-sm-12 padding-l-20  ">
						<div class="mr-border-radius-10 padding-horizontal">
							<h5 class="mr-bold">Добавляйте на сайт</h5>
							<ul>
								<li><i>{{ __('mr-t.Простая интеграция')}}</i></li>
								<li><i>{{ __('mr-t.Быстрая настройка')}}</i></li>
							</ul>
							<div class="col-md-12 text-center">
                  <textarea class="form-control mr-bg-index-form mr-middle" style="height: 100px;">
<script>

</script>
<div id="contacts"></div>
                  </textarea>

								@guest
								<div class="margin-t-10 mr-middle">
									<a href="/login">
										<button class="mr-bg-btn-body mr-border-radius-10"
														style="min-width: 100px;">{{ __('mr-t.Вход') }}
										</button>
									</a>
									<a href="/register">
										<button class="mr-bg-btn-body mr-border-radius-10"
														style="min-width: 100px;">{{ __('mr-t.Регистрация') }}
										</button>
									</a>
								</div>
								@else
								<a href="/panel/vcards">
									<button class="mr-bg-btn-body mr-border-radius-10 margin-t-10">Настроить визитку
									</button>
								</a>
								@endguest
								<div class="margin-t-10 margin-b-10 mr-middle">
									@foreach($messengers as $msg)
									<img src="/public/images/social_icons/{{ $msg->getName() }}.png"
											 class="mr-social-icon-middle"
											 title="{{ $msg->getName() }}">
									@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

</div>
@endsection

