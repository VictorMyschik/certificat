@extends('layouts.app')

@section('content')
@include('layouts.mr_nav')


<div class="container">

	<div class="row no-gutters align-items-center justify-content-center margin-t-10" data-scrollax-parent="true">
		<h1 class="mb-3 bread">{{ __('mr-t.Ваши вопросы - наши ответы') }}</h1>
	</div>

	<div class="row justify-content-start pb-3">
		<div class="col-md-7">
			<span class="subheading">{{ __('mr-t.ЧАВо') }}</span>
			<h3>{{ __('mr-t.Часто задаваемые вопросы') }}</h3>
		</div>
	</div>

	<div id="accordion">
		@foreach($list as $value)
		<div class="card-header">
			<a class="card-link mr-color-black mr-bold" data-toggle="collapse" href="#menu{{ $value->id() }}"
				 aria-expanded="true"
				 aria-controls="menu{{ $value->id() }}">{{ $value->getTitle() }}
			</a>
		</div>

		<div id="menu{{ $value->id() }}" class="collapse">
			<div class="card-body">
				{!! $value->getText() !!}
			</div>
		</div>
		@endforeach
	</div>

	<div class="margin-t-20">
		<a data-toggle="collapse" href="#feedback" aria-expanded="true" class=" mr-color-black mr-bold">
			{{ __('mr-t.Обратная связь') }}
			<h3 class="form-group">{{ __('mr-t.Если остались вопросы, напишите нам') }}</h3>
		</a>

		{!! \App\Http\Controllers\Helpers\MrMessageHelper::GetMessage() !!}

		<div id="feedback" class="collapse">

			<form action="/feedback" method="post">
				{{ Form::token() }}

				<label for="name" class="form-group col-md-6 padding-l-0 padding-r-0">{{ __('mr-t.Имя') }}
					<input required type="text" name="name" class="form-control"></label>

				<label for="email" class="form-group col-md-6 padding-l-0 padding-r-0">Email
					<input required type="email" name="email" class="form-control"></label>

				<div class="form-group">
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
</div>

</div>
@endsection
