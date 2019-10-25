@extends('layouts.app')

@section('content')
@include('layouts.mr_nav')


<div class="container">

	<div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center"
			 data-scrollax-parent="true">
		<div class="col-md-9 text-center ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
			<h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">
				@if (Session::has('message'))
				{{ Session::get('message') }}
				@else
				{{ $message??__('mr-t.Ваши вопросы - наши ответы') }}
				@endif
			</h1>
		</div>
	</div>


	<div class="row justify-content-start pb-3">
		<div class="col-md-7">
			<span class="subheading">{{ __('mr-t.ЧАВо') }}</span>
			<h3>{{ __('mr-t.Часто задаваемые вопросы') }}</h3>
		</div>
	</div>

	<div id="accordion">
		@foreach($list as $value)
		<div class="card-header col-md-12">
			<a class="card-link mr-color-black" data-toggle="collapse" href="#menu{{ $value->id() }}"
				 aria-expanded="true"
				 aria-controls="menu{{ $value->id() }}">{{ $value->getTitle() }}<span
					class="collapsed">
                        <i class="icon-plus-circle"></i></span><span class="expanded"><i class="icon-minus-circle"></i></span></a>
		</div>

		<div id="menu{{ $value->id() }}" class="collapse">
			<div class="card-body">
				{!! $value->getText() !!}
			</div>
		</div>
		@endforeach
	</div>

	<div class="margin-t-20">
		<span class="subheading">{{ __('mr-t.Обратная связь') }}</span>
		<h3 class="form-group">{{ __('mr-t.Если остались вопросы, напишите нам') }}</h3>

		{!! \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}
		<form action="/feedback" method="post">
			{{ Form::token() }}

			<label for="name" class="form-group col-md-6 col-sm-12">{{ __('mr-t.Имя') }}
				<input required type="text" name="name" class="form-control"></label>

			<label for="email" class="form-group col-md-6 col-sm-12">Email
				<input required type="email" name="email" class="form-control"></label>

			<div class="form-group col-md-12">
				<label for="message">{{ __('mr-t.Сообщение') }}</label>
				<textarea name="text" id="message" cols="30" rows="10" class="form-control"></textarea>
			</div>

			<div class="form-group">
				<input type="submit" value="{{ __('mr-t.Отправить') }}" class="btn btn-primary">
			</div>
			<br>
		</form>
	</div>
</div>
@endsection
